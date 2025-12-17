<?php
// visits.php - simple file-backed visit counter for products
// Stores a JSON object mapping product_id => count in ../data/visits.json

function visits_file_path() {
    return __DIR__ . '/../data/visits.json';
}

function ensure_data_dir() {
    $file = visits_file_path();
    $dir = dirname($file);
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

function increment_visit($id) {
    $id = (string)$id;
    ensure_data_dir();
    $file = visits_file_path();

    $fp = @fopen($file, 'c+');
    if (!$fp) return false;
    if (!flock($fp, LOCK_EX)) { fclose($fp); return false; }

    // read existing data (support old flat map or new structure)
    $contents = stream_get_contents($fp);
    $counts = [];
    if ($contents !== false && strlen($contents) > 0) {
        $decoded = json_decode($contents, true);
        if (is_array($decoded)) {
            // If file stores the flat map (legacy), use it directly
            if (array_keys($decoded) !== range(0, count($decoded) - 1)) {
                // associative array: could be either flat map or {counts:..., top5:...}
                if (isset($decoded['counts']) && is_array($decoded['counts'])) {
                    $counts = $decoded['counts'];
                } else {
                    $counts = $decoded; // legacy flat map
                }
            }
        }
    }

    if (isset($counts[$id])) $counts[$id] = (int)$counts[$id] + 1;
    else $counts[$id] = 1;

    // compute top5 as array of [id,count]
    $sorted = $counts;
    arsort($sorted);
    $top5 = array_slice($sorted, 0, 5, true);
    $top5_list = [];
    foreach ($top5 as $pid => $cnt) {
        $top5_list[] = ['id' => $pid, 'count' => $cnt];
    }

    $out = ['counts' => $counts, 'top5' => $top5_list];

    // write back
    ftruncate($fp, 0);
    rewind($fp);
    fwrite($fp, json_encode($out));
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
    return true;
}

function get_all_visits() {
    $file = visits_file_path();
    if (!file_exists($file)) return [];
    $fp = @fopen($file, 'r');
    if (!$fp) return [];
    if (!flock($fp, LOCK_SH)) { fclose($fp); return []; }
    $contents = stream_get_contents($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
    if ($contents === false || strlen($contents) === 0) return [];
    $data = json_decode($contents, true);
    if (!is_array($data)) return [];
    // support both legacy flat map and new structure {counts:..., top5:...}
    if (isset($data['counts']) && is_array($data['counts'])) {
        return $data['counts'];
    }
    // legacy: entire file is the map
    return $data;
}

function get_top5_from_file() {
    $file = visits_file_path();
    if (!file_exists($file)) return [];
    $fp = @fopen($file, 'r');
    if (!$fp) return [];
    if (!flock($fp, LOCK_SH)) { fclose($fp); return []; }
    $contents = stream_get_contents($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
    if ($contents === false || strlen($contents) === 0) return [];
    $data = json_decode($contents, true);
    if (!is_array($data)) return [];
    if (isset($data['top5']) && is_array($data['top5'])) return $data['top5'];
    // fallback compute from counts
    $counts = (isset($data['counts']) && is_array($data['counts'])) ? $data['counts'] : $data;
    arsort($counts);
    $top = array_slice($counts, 0, 5, true);
    $top5_list = [];
    foreach ($top as $pid => $cnt) $top5_list[] = ['id' => $pid, 'count' => $cnt];
    return $top5_list;
}

function get_visit_count($id) {
    $all = get_all_visits();
    $id = (string)$id;
    return isset($all[$id]) ? (int)$all[$id] : 0;
}

?>
