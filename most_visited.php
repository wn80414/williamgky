<?php
include 'product_item.php';
include 'header.php';

$visit_counter = isset($_COOKIE['visit_counter']) ? json_decode($_COOKIE['visit_counter'], true) : [];
arsort($visit_counter);
$top5 = array_slice($visit_counter, 0, 5, true);

?>

<body>
    <div class="container">

        <h1>Top 5 Most Visited Products</h1>
    </div>
    <div class="container">
        <?php if (empty($top5)): ?>
            <p>No product visits yet.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($top5 as $id => $count): ?>
                    <li>
                        <a href="product.php?id=<?= $id ?>">
                            <img src="<?= $products[$id]['img'] ?>" alt="<?= $products[$id]['name'] ?>">
                            <?= $products[$id]['name'] ?> (Visited <?= $count ?> times)
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