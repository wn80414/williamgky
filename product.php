<?php
include('header.php');
include 'product_item.php';
include_once __DIR__ . '/inc/visits.php';
include_once __DIR__ . '/inc/reviews.php';

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
// increment global visit counter stored in data/visits.json
increment_visit($id);

// Reviews handling (POST)
$review_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_submit'])) {
    if (!isset($_SESSION['user']) || $_SESSION['logged_in'] !== true) {
        $review_error = 'You must be logged in to submit a review.';
    } else {
        $username = $_SESSION['user'];
        if (user_has_reviewed($id, $username)) {
            $review_error = 'You have already submitted a review for this product.';
        } else {
            $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
            $comment = trim($_POST['comment'] ?? '');
            if ($rating < 1 || $rating > 5) {
                $review_error = 'Please provide a rating between 1 and 5.';
            } else {
                $ok = add_review($id, $username, $rating, $comment);
                if ($ok) {
                    header("Location: product.php?id=$id");
                    exit;
                } else {
                    $review_error = 'Unable to save your review. You may have already reviewed this item.';
                }
            }
        }
    }
}

$reviews = get_reviews($id);
?>

<body>
    <div class="container page-offset center-screen">
        <div class="row justify-content-center w-100">
            <div class="col-auto">
                <div class="card no-hover-card product-card-large mx-auto">
                    <img src="<?= htmlspecialchars($product['img']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($product['desc']) ?></p>
                        <?php $visits = get_visit_count($id); ?>
                        <p class="text-muted small">Visited: <?= $visits ?> <?= $visits === 1 ? 'time' : 'times' ?></p>

                        <div class="btn-row">
                            <a href="product_list.php" class="btn btn-outline-secondary">Back to Products</a>
                            <a href="last_visited.php" class="btn btn-outline-primary">Last 5</a>
                            <a href="most_visited.php" class="btn btn-primary">Most Visited</a>
                        </div>
                    </div>
                            <div class="container">
                                <div class="product-reviews">
                                    <h3>Customer Reviews</h3>
                                    <?php if (!empty($reviews)): ?>
                                        <?php foreach ($reviews as $r): ?>
                                            <div class="card mb-2" style="max-width:720px;margin:0 auto;text-align:left;padding:12px;">
                                                <div><strong><?= htmlspecialchars($r['user']) ?></strong> — <small class="text-muted"><?php echo date('Y-m-d H:i', $r['time'] ?? time()); ?></small></div>
                                                <div>Rating: <?= str_repeat('★', max(1,(int)$r['rating'])) ?><?= str_repeat('☆', 5-max(1,(int)$r['rating'])) ?></div>
                                                <?php if (!empty($r['comment'])): ?><div style="margin-top:8px;"><?= nl2br(htmlspecialchars($r['comment'])) ?></div><?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p>No reviews yet. Be the first to review this product.</p>
                                    <?php endif; ?>

                                    <div style="max-width:720px;margin:18px auto 60px;">
                                        <?php if (isset($_SESSION['user']) && $_SESSION['logged_in'] === true): ?>
                                            <?php if (user_has_reviewed($id, $_SESSION['user'])): ?>
                                                <p class="text-muted">You have already submitted a review for this product.</p>
                                            <?php else: ?>
                                                <?php if (!empty($review_error)): ?><div class="alert alert-danger"><?= htmlspecialchars($review_error) ?></div><?php endif; ?>
                                                <form method="post" action="product.php?id=<?= (int)$id ?>">
                                                    <div class="mb-2">
                                                        <label for="rating" class="form-label">Rating</label>
                                                        <select name="rating" id="rating" class="form-control" required>
                                                            <option value="5">5 - Excellent</option>
                                                            <option value="4">4 - Good</option>
                                                            <option value="3">3 - Okay</option>
                                                            <option value="2">2 - Poor</option>
                                                            <option value="1">1 - Terrible</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="comment" class="form-label">Comment (optional)</label>
                                                        <textarea name="comment" id="comment" class="form-control" rows="4" maxlength="2000"></textarea>
                                                    </div>
                                                    <div>
                                                        <button type="submit" name="review_submit" class="btn btn-primary">Submit Review</button>
                                                    </div>
                                                </form>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <p>Please <a href="login.php">log in</a> to submit a review.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>
    </div>




    </div>
</body>