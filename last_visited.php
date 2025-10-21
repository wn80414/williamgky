<?php
include('header.php');
include 'product_item.php';

$visited_ids = isset($_COOKIE['visited_products']) ? explode(',', $_COOKIE['visited_products']) : [];
?>

<body>
    <div class="container">

        <h1>Last 5 Visited Products</h1>
    </div>
    <div class="container">
        <?php if (empty($visited_ids)): ?>
            <p>No products visited yet.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($visited_ids as $id): ?>
                    <li>
                        <a href="product.php?id=<?= $id ?>">
                            <img src="<?= $products[$id]['img'] ?>" alt="<?= $products[$id]['name'] ?>">
                            <span class="product-name"><?= $products[$id]['name'] ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <div class="container">
        <p><a href="product_list.php">Back to Products</a></p>
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
