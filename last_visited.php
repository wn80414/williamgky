<?php
include('header.php');
include 'product_item.php';

$visited_ids = isset($_COOKIE['visited_products']) ? explode(',', $_COOKIE['visited_products']) : [];
?>

<body>
    <div class="container page-offset">

        <h1>Last 5 Visited Products</h1>
    </div>
    
    <div class="container">
        <h1>Last 5 Visited Products</h1>
        <ul class="top5-list">
            <?php foreach ($visited_ids as $id): ?>
                <li>
                    <a href="product.php?id=<?= $id ?>">
                        <img src="<?= $products[$id]['img'] ?>" alt="<?= $products[$id]['name'] ?>">
                        <span class="product-name"><?= $products[$id]['name'] ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="container">
        <p><a href="product_list.php">Back to Products</a></p>
    </div>

</body>