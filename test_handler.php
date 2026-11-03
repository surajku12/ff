<?php
// Simulate POST to order_action_handler.php
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST = [
    'action' => 'cancel',
    'order_id' => 'ORD-2026-875C0C',
    'item_name' => 'Nuon Beige Cargo Pants',
    'reason' => 'Test cancel'
];

require_once 'order_action_handler.php';
?>