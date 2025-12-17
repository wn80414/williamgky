<?php
// reviews.php - file-backed reviews storage
// Structure: { "productId": [ {"user":"alice","rating":5,"comment":"...","time":1234567890}, ... ], ... }

function reviews_file_path() {
    return __DIR__ . '/../data/reviews.json';
}

function ensure_reviews_dir() {
    $file = reviews_file_path();
    $dir = dirname($file);
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

function load_all_reviews() {
    $file = reviews_file_path();
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
    return $data;
}

function save_all_reviews($data) {
    ensure_reviews_dir();
    $file = reviews_file_path();
    $fp = @fopen($file, 'c+');
    if (!$fp) return false;
    if (!flock($fp, LOCK_EX)) { fclose($fp); return false; }
    ftruncate($fp, 0);
    rewind($fp);
    fwrite($fp, json_encode($data));
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
    return true;
}

function get_reviews($productId) {
    $all = load_all_reviews();
    $pid = (string)$productId;
    if (!isset($all[$pid]) || !is_array($all[$pid])) return [];
    // sort by time desc
    $reviews = $all[$pid];
    usort($reviews, function($a,$b){ return ($b['time'] ?? 0) - ($a['time'] ?? 0); });
    return $reviews;
}

function user_has_reviewed($productId, $username) {
    $all = load_all_reviews();
    $pid = (string)$productId;
    if (!isset($all[$pid]) || !is_array($all[$pid])) return false;
    foreach ($all[$pid] as $r) {
        if (isset($r['user']) && strcasecmp($r['user'], $username) === 0) return true;
    }
    return false;
}

function add_review($productId, $username, $rating, $comment) {
    $pid = (string)$productId;
    $username = (string)$username;
    $rating = max(1, min(5, (int)$rating));
    $comment = trim((string)$comment);
    $all = load_all_reviews();
    if (!isset($all[$pid]) || !is_array($all[$pid])) $all[$pid] = [];
    // enforce one review per user
    foreach ($all[$pid] as $existing) {
        if (isset($existing['user']) && strcasecmp($existing['user'], $username) === 0) {
            return false;
        }
    }
    $entry = [ 'user' => $username, 'rating' => $rating, 'comment' => $comment, 'time' => time() ];
    $all[$pid][] = $entry;
    return save_all_reviews($all);
}

?>
