<?php
include 'product_item.php';
include 'header.php';
include_once __DIR__ . '/inc/visits.php';

$visit_counter = get_all_visits();
arsort($visit_counter);
$top5 = array_slice($visit_counter, 0, 5, true);

?>

<body>
    <div class="container page-offset">

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
    
</body>