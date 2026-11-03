<?php
require_once 'includes/db.php';
$orderId = 'ORD-2026-875C0C'; // example
$stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
$stmt->execute([$orderId]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "Items for $orderId:\n";
print_r($items);
?>