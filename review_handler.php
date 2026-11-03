<?php
session_start();
header('Content-Type: application/json');
include 'includes/db.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
    
    if ($product_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
        exit;
    }

    $stmt = $conn->prepare("SELECT id, user_name, rating, comment, created_at FROM reviews WHERE product_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $reviews = [];
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
    
    echo json_encode(['success' => true, 'reviews' => $reviews]);
} 
elseif ($method === 'POST') {
    if (!isset($_SESSION['user_email'])) {
        echo json_encode(['success' => false, 'message' => 'Please login to post a review']);
        exit;
    }

    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 5;
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
    $user_name = $_SESSION['user_name'] ?? 'Anonymous';
    $user_id = $_SESSION['user_id'] ?? null;

    if ($product_id <= 0 || empty($comment)) {
        echo json_encode(['success' => false, 'message' => 'Invalid data provided']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO reviews (product_id, user_id, user_name, rating, comment) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiis s", $product_id, $user_id, $user_name, $rating, $comment);
    
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true, 
            'message' => 'Review posted successfully',
            'review' => [
                'user_name' => $user_name,
                'rating' => $rating,
                'comment' => $comment,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    }
}

$conn->close();
?>
