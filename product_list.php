<?php

require_once __DIR__ . '/inc/db.php';
include('header.php');

$pdo = get_db();

/* ---------- Handle Price Filter ---------- */
$minPrice = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
$maxPrice = isset($_GET['max_price']) ? (float)$_GET['max_price'] : 1000;

/* ---------- Fetch Products from DB ---------- */
$stmt = $pdo->prepare("
    SELECT id, name, `desc`, img, price
    FROM products
    WHERE price BETWEEN ? AND ?
    ORDER BY id ASC
");
$stmt->execute([$minPrice, $maxPrice]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <div class="container page-offset">
        <h1>Our Products</h1>
    </div>
    <!-- Sidebar Filter -->
    <div class="container d-flex mb-4">
        <div class="col-md-3 me-4">
            <h4>Filter by Price</h4>
            <form method="get" action="product_list.php">
                <div class="mb-2">
                    <label for="min_price">Min Price</label>
                    <input type="number" step="0.01" name="min_price" id="min_price" class="form-control" value="<?= htmlspecialchars($minPrice) ?>">
                </div>
                <div class="mb-2">
                    <label for="max_price">Max Price</label>
                    <input type="number" step="0.01" name="max_price" id="max_price" class="form-control" value="<?= htmlspecialchars($maxPrice) ?>">
                </div>
                <button type="submit" class="btn btn-primary mt-2">Filter</button>
            </form>
        </div>
    </div>

    <div class="container">
        <ul>
            <?php foreach ($products as $product): ?>
                <li>
                    <a href="product.php?id=<?= $product['id'] ?>">
                        <img src="<?= $product['img'] ?>" alt="<?= $product['name'] ?>">
                        <span class="product-name"><?= $product['name'] ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="container text-center mt-4 mb-4">
        <a href="last_visited.php" class="btn btn-outline-primary me-2">Last 5 Visited</a>
        <a href="most_visited.php" class="btn btn-primary">Most Visited</a>
    </div>
</body>