<?php
include 'header.php';
require_once __DIR__ . '/inc/db.php';

$pdo = get_db();

$stmt = $pdo->prepare("
    SELECT p.id, p.name, p.img, p.`desc`, v.visits
    FROM products p
    JOIN product_visits v ON p.id = v.product_id
    ORDER BY v.visits DESC
    LIMIT 5
");
$stmt->execute();
$top5 = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <div class="container page-offset">
        <h1>Top 5 Most Visited Products</h1>
    </div>

    <div class="container">
        <?php if (empty($top5)): ?>
            <p>No product visits yet.</p>
        <?php else: ?>
            <ul class="top5-list">
                <?php foreach ($top5 as $product): ?>
                    <li>
                        <a href="product.php?id=<?= $product['id'] ?>">
                            <img src="<?= $product['img'] ?>" alt="<?= $product['name'] ?>">
                            <span class="product-name"><?= $product['name'] ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <div class="container text-center mt-4 mb-4">
        <a href="last_visited.php" class="btn btn-outline-primary me-2">Last 5 Visited</a>
        <a href="product_list.php" class="btn btn-primary">All Products</a>
    </div>
</body>