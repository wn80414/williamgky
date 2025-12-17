<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once __DIR__ . '/inc/db.php';
$pdo = get_db();

try {
    // Fetch all products from the database
    $stmt = $pdo->query("
        SELECT id, name, `desc`, img, price
        FROM products
        ORDER BY id ASC
    ");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => "success",
        "count" => count($products),
        "result" => $products
    ], JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Database error: " . $e->getMessage()
    ], JSON_PRETTY_PRINT);
}
