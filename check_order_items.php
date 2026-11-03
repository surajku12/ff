<?php
require_once 'includes/db.php';
$result = $pdo->query('DESCRIBE order_items');
$columns = $result->fetchAll(PDO::FETCH_ASSOC);
foreach ($columns as $col) {
    echo $col['Field'] . ' - ' . $col['Type'] . ' - ' . $col['Null'] . ' - ' . ($col['Key'] ?? '') . ' - ' . ($col['Default'] ?? 'NULL') . ' - ' . ($col['Extra'] ?? '') . PHP_EOL;
}
?>