<?php
include('header.php');
include 'product_item.php';

$id = $_GET['id'] ?? 1;
$product = $products[$id] ?? $products[1];

// Top 5 Visits
$visited = isset($_COOKIE['visited_products']) ? explode(',', $_COOKIE['visited_products']) : [];

if (($key = array_search($id, $visited)) !== false) {
    unset($visited[$key]);
}
array_unshift($visited, $id);
$visited = array_slice($visited, 0, 5);
setcookie('visited_products', implode(',', $visited), time() + (86400 * 9000), "/");

//Visit counter
$visit_counter = isset($_COOKIE['visit_counter']) ? json_decode($_COOKIE['visit_counter'], true) : [];
if (isset($visit_counter[$id])) {
    $visit_counter[$id] += 1;
} else {
    $visit_counter[$id] = 1;
}
setcookie('visit_counter', json_encode($visit_counter), time() + (86400 * 9000), "/");
?>

<body>
    <div class="container">
        <h1><?= $product['name'] ?></h1>
    </div>
    <div class="container">
        <img src="<?= $product['img'] ?>" alt="<?= $product['name'] ?>" width="300">



    </div>
    <div class="container">
        <p><?= $product['desc'] ?></p>
    </div>
    <div class="container">
        <p><a href="product_list.php">Back to Products</a></p>
    </div>
    <div class="container">
        <p><a href="last_visited.php">See Last 5 Visited Products</a></p>
    </div>
    </div>
    <div class="container">
        <p><a href="most_visited.php">See Most Visited Products</a></p>

    </div>



</body>