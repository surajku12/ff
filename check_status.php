<?php
require_once 'includes/db.php';
$stmt = $pdo->prepare('SELECT status FROM order_items WHERE order_id = ? AND product_name = ?');
$stmt->execute(['ORD-2026-875C0C', 'Nuon Beige Cargo Pants']);
$item = $stmt->fetch();
echo 'Status: ' . $item['status'];
?>