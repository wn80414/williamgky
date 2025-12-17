<?php
// reviews.php
require_once __DIR__ . '/db.php';

function get_reviews($productId)
{
    $pdo = get_db();

    $stmt = $pdo->prepare("
        SELECT username AS user,
               rating,
               comment,
               UNIX_TIMESTAMP(created_at) AS time
        FROM reviews
        WHERE product_id = ?
        ORDER BY created_at DESC
    ");

    $stmt->execute([$productId]);
    return $stmt->fetchAll();
}

function user_has_reviewed($productId, $username)
{
    $pdo = get_db();

    $stmt = $pdo->prepare("
        SELECT 1
        FROM reviews
        WHERE product_id = ?
          AND LOWER(username) = LOWER(?)
        LIMIT 1
    ");

    $stmt->execute([$productId, $username]);
    return (bool) $stmt->fetch();
}

function add_review($productId, $username, $rating, $comment)
{
    $pdo = get_db();

    $rating = max(1, min(5, (int)$rating));
    $comment = trim((string)$comment);

    try {
        $stmt = $pdo->prepare("
            INSERT INTO reviews (product_id, username, rating, comment)
            VALUES (?, ?, ?, ?)
        ");

        return $stmt->execute([$productId, $username, $rating, $comment]);
    } catch (PDOException $e) {
        // Duplicate review
        if ($e->getCode() == 23000) return false;
        throw $e;
    }
}
