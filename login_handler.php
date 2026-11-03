<?php
session_start();
header('Content-Type: application/json');
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$phone = trim($_POST['phone'] ?? '');

if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Email and password are required']);
    exit;
}

// For demo purposes, we'll create a simple user if they don't exist
// In production, you'd have proper registration and password hashing
try {
    // Check if user exists
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        // Create new user (demo only - in production, use proper registration)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (email, phone, password) VALUES (?, ?, ?)");
        $stmt->execute([$email, $phone, $hashedPassword]);
        $userId = $pdo->lastInsertId();
    } else {
        // Verify password
        if (!password_verify($password, $user['password'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
            exit;
        }
        $userId = $user['id'];
    }

    // Update last login and increment count
    $stmt = $pdo->prepare("UPDATE users SET last_login = NOW(), login_count = login_count + 1 WHERE id = ?");
    $stmt->execute([$userId]);

    // Log the login
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    $stmt = $pdo->prepare("INSERT INTO login_logs (user_id, email, ip_address, user_agent) VALUES (?, ?, ?, ?)");
    $stmt->execute([$userId, $email, $ip, $userAgent]);

    // Get user details
    $stmt = $pdo->prepare("SELECT email, phone, created_at, last_login, login_count FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $userData = $stmt->fetch();

    // Set session variables
    $_SESSION['user_id'] = $userId;
    $_SESSION['user_email'] = $userData['email'];

    echo json_encode([
        'success' => true,
        'message' => 'Login successful',
        'user' => [
            'id' => $userId,
            'email' => $userData['email'],
            'phone' => $userData['phone'],
            'created_at' => $userData['created_at'],
            'last_login' => $userData['last_login'],
            'login_count' => $userData['login_count']
        ]
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>