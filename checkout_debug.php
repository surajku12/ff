<?php
header('Content-Type: application/json');

// Log all received data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

$logData = [
    'timestamp' => date('Y-m-d H:i:s'),
    'raw_json' => $json,
    'decoded_data' => $data,
    'post_data' => $_POST,
    'get_data' => $_GET,
];

// Write to log file
file_put_contents('checkout_debug.log', json_encode($logData, JSON_PRETTY_PRINT) . "\n\n", FILE_APPEND);

// Test database connection
try {
    require_once 'includes/db.php';
    
    // Check if database exists
    $result = $pdo->query("SELECT DATABASE() as db");
    $dbInfo = $result->fetch();
    
    // Check if tables exist
    $tables = $pdo->query("SHOW TABLES IN fashiofy");
    $tableList = $tables->fetchAll(PDO::FETCH_COLUMN);
    
    echo json_encode([
        'success' => true,
        'message' => 'Database connection working',
        'database' => $dbInfo['db'],
        'tables_found' => $tableList,
        'data_received' => [
            'json_valid' => json_last_error() === JSON_ERROR_NONE,
            'data_count' => count($data),
            'has_items' => isset($data['items']),
            'items_count' => isset($data['items']) ? count($data['items']) : 0
        ]
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage(),
        'data_received' => $data
    ]);
}
?>
