<?php include('header.php'); ?>
<?php include 'product_item.php'; ?>

<body>
    <div class="container page-offset">
        <h1>Our Products</h1>
    </div>
    <div class="container">
        <ul>
            <?php foreach ($products as $id => $product): ?>
                <li>
                    <a href="product.php?id=<?= $id ?>">
                        <img src="<?= $product['img'] ?>" alt="<?= $product['name'] ?>">
                        <span class="product-name"><?= $product['name'] ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

    </div>

    <div class="container">
        <p><a href="last_visited.php">See Last 5 Visited Products</a></p><br>
        
    </div>
        <div class="container">
            <p><a href="most_visited.php">See Most Visited Products</a></p>
        
    </div>

    
</body>