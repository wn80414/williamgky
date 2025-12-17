<?php
include('header.php');
require_once __DIR__ . '/inc/db.php';

$pdo = get_db(); 

// ---------- Fetch Product ----------
$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "<p>Product not found.</p>";
    exit;
}

// ---------- Track Visit ----------
function track_product_visit($pdo, $productId) {
    // Increment or insert
    $stmt = $pdo->prepare("
        INSERT INTO product_visits (product_id, visits)
        VALUES (?, 1)
        ON DUPLICATE KEY UPDATE visits = visits + 1
    ");
    $stmt->execute([$productId]);

    // Fetch updated visits
    $stmt = $pdo->prepare("SELECT visits FROM product_visits WHERE product_id=?");
    $stmt->execute([$productId]);
    $row = $stmt->fetch();
    return $row['visits'] ?? 0;
}

$visits = track_product_visit($pdo, $id);

// ---------- Review Functions ----------
function get_reviews($pdo, $productId){
    $stmt = $pdo->prepare("
        SELECT id, username AS user, rating, comment, UNIX_TIMESTAMP(created_at) AS time 
        FROM reviews 
        WHERE product_id=? 
        ORDER BY created_at DESC
    ");
    $stmt->execute([$productId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function user_has_reviewed($pdo, $productId, $username){
    $stmt = $pdo->prepare("SELECT 1 FROM reviews WHERE product_id=? AND LOWER(username)=LOWER(?) LIMIT 1");
    $stmt->execute([$productId, $username]);
    return (bool)$stmt->fetch();
}

function add_review($pdo, $productId, $username, $rating, $comment){
    $rating = max(1,min(5,(int)$rating));
    $comment = trim($comment);
    $stmt = $pdo->prepare("INSERT INTO reviews (product_id, username, rating, comment) VALUES (?,?,?,?)");
    return $stmt->execute([$productId, $username, $rating, $comment]);
}

function update_review($pdo, $reviewId, $username, $rating, $comment){
    $rating = max(1,min(5,(int)$rating));
    $stmt = $pdo->prepare("UPDATE reviews SET rating=?, comment=? WHERE id=? AND LOWER(username)=LOWER(?)");
    return $stmt->execute([$rating, $comment, $reviewId, $username]);
}

function delete_review($pdo, $reviewId, $username){
    $stmt = $pdo->prepare("DELETE FROM reviews WHERE id=? AND LOWER(username)=LOWER(?)");
    return $stmt->execute([$reviewId, $username]);
}

// ---------- Handle POST Actions ----------
$review_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])){
    $username = $_SESSION['user'];

    // Add review
    if(isset($_POST['review_submit'])){
        $rating = (int)($_POST['rating'] ?? 0);
        $comment = trim($_POST['comment'] ?? '');
        if($rating < 1 || $rating > 5){
            $review_error = 'Rating must be between 1 and 5.';
        } elseif(user_has_reviewed($pdo,$id,$username)){
            $review_error = 'You have already submitted a review.';
        } else {
            add_review($pdo,$id,$username,$rating,$comment);
            header("Location: product.php?id=$id");
            exit;
        }
    }

    // Edit review
    if(isset($_POST['edit_review'])){
        $reviewId = (int)$_POST['review_id'];
        $rating = (int)($_POST['rating'] ?? 0);
        $comment = trim($_POST['comment'] ?? '');
        update_review($pdo,$reviewId,$username,$rating,$comment);
        header("Location: product.php?id=$id");
        exit;
    }

    // Delete review
    if(isset($_POST['delete_review'])){
        $reviewId = (int)$_POST['review_id'];
        delete_review($pdo,$reviewId,$username);
        header("Location: product.php?id=$id");
        exit;
    }
}

// ---------- Load Reviews ----------
$reviews = get_reviews($pdo,$id);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($product['name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container page-offset mt-4">
    <div class="card mx-auto product-card-large">
        <!-- Product Title at Top -->
        <div class="card-header text-center">
            <h2 class="card-title mb-0"><?= htmlspecialchars($product['name']) ?></h2>
        </div>

        <img src="<?= htmlspecialchars($product['img']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">

        <div class="card-body text-center">
            <p class="card-text"><?= htmlspecialchars($product['desc']) ?></p>
            <p class="text-muted small">Visited: <?= $visits ?> <?= $visits===1?'time':'times' ?></p>
            <p class="text-primary"><strong>$<?= number_format($product['price'],2) ?></strong></p>

            <div class="btn-row mb-3 d-flex justify-content-center gap-2">
                <a href="product_list.php" class="btn btn-outline-secondary">Back to Products</a>
                <a href="last_visited.php" class="btn btn-outline-primary">Last 5</a>
                <a href="most_visited.php" class="btn btn-primary">Most Visited</a>
            </div>

            <!-- Reviews Section -->
            <h3 class="text-start">Customer Reviews</h3>
            <?php if(!empty($reviews)): ?>
                <?php foreach($reviews as $r): ?>
                    <div class="card mb-2 p-2">
                        <div class="d-flex justify-content-between">
                            <strong><?= htmlspecialchars($r['user']) ?></strong>
                            <small class="text-muted"><?= date('Y-m-d H:i',$r['time']??time()) ?></small>
                        </div>
                        <div class="text-start mt-1">Rating: <?= str_repeat('★',$r['rating']) ?><?= str_repeat('☆',5-$r['rating']) ?></div>
                        <?php if(!empty($r['comment'])): ?>
                            <div class="mt-1"><?= nl2br(htmlspecialchars($r['comment'])) ?></div>
                        <?php endif; ?>

                        <?php if(isset($_SESSION['user']) && $_SESSION['user']==$r['user']): ?>
                            <form method="post" class="mt-2 text-center">
                                <input type="hidden" name="review_id" value="<?= $r['id'] ?>">
                                <input type="number" name="rating" value="<?= $r['rating'] ?>" min="1" max="5" style="width:60px;">
                                <input type="text" name="comment" value="<?= htmlspecialchars($r['comment']) ?>" style="width:300px;">
                                <div class="mt-2">
                                    <button type="submit" name="edit_review" class="btn btn-sm btn-success">Edit</button>
                                    <button type="submit" name="delete_review" class="btn btn-sm btn-danger" onclick="return confirm('Delete review?')">Delete</button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No reviews yet. Be the first!</p>
            <?php endif; ?>

            <!-- Add Review Form -->
            <?php if(isset($_SESSION['user']) && !user_has_reviewed($pdo,$id,$_SESSION['user'])): ?>
                <?php if($review_error) echo "<div class='alert alert-danger'>".htmlspecialchars($review_error)."</div>"; ?>
                <form method="post" class="mt-3 text-center">
                    <div class="text-start mb-1"><label>Rating</label></div>
                    <select name="rating" class="form-control w-25 mb-2 mx-auto">
                        <?php for($i=5;$i>=1;$i--): ?>
                            <option value="<?=$i?>"><?=$i?></option>
                        <?php endfor; ?>
                    </select>
                    <div class="text-start mb-1"><label>Comment</label></div>
                    <textarea name="comment" class="form-control w-75 mx-auto mb-2"></textarea>
                    <button type="submit" name="review_submit" class="btn btn-primary mt-2">Submit Review</button>
                </form>
            <?php elseif(!isset($_SESSION['user'])): ?>
                <p>Please <a href="login.php">log in</a> to submit a review.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
