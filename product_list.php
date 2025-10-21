<?php include('header.php'); ?>
<?php include 'product_item.php'; ?>

<body>
    <div class="container">
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

    <style>
        ul {
            list-style: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
        }

        li {
            margin: 15px;
            border: 1px solid #ccc;
            padding: 10px;
            width: 200px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .product-name {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
    </style>
</body>