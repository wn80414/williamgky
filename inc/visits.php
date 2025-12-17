<?php
require_once __DIR__ . '/db.php';

function increment_visit($productId)
{
    $pdo = get_db();

    $stmt = $pdo->prepare("
        INSERT INTO visits (product_id, visit_count)
        VALUES (?, 1)
        ON DUPLICATE KEY UPDATE visit_count = visit_count + 1
    ");

    $stmt->execute([$productId]);
}

function get_visit_count($productId)
{
    $pdo = get_db();

    $stmt = $pdo->prepare("
        SELECT visit_count
        FROM visits
        WHERE product_id = ?
    ");

    $stmt->execute([$productId]);
    return (int)($stmt->fetchColumn() ?? 0);
}
