<?php
$host = '127.0.0.1';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create Database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS fashiofy");
    $pdo->exec("USE fashiofy");

    // Users Table for login tracking
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(100) UNIQUE NOT NULL,
        phone VARCHAR(15),
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        last_login TIMESTAMP NULL,
        login_count INT DEFAULT 0
    )");

    // Login Logs Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS login_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        email VARCHAR(100),
        login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        ip_address VARCHAR(45),
        user_agent TEXT,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
    )");

    // Orders Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS orders (
        id VARCHAR(20) PRIMARY KEY,
        user_id INT,
        name VARCHAR(100) NOT NULL,
        mobile VARCHAR(15) NOT NULL,
        pincode VARCHAR(10) NOT NULL,
        street VARCHAR(255) NOT NULL,
        city VARCHAR(100) NOT NULL,
        state VARCHAR(100) NOT NULL,
        payment_method VARCHAR(50) NOT NULL,
        payment_details VARCHAR(255) DEFAULT NULL,
        subtotal DECIMAL(10, 2) NOT NULL,
        tax DECIMAL(10, 2) NOT NULL,
        total DECIMAL(10, 2) NOT NULL,
        status VARCHAR(20) DEFAULT 'Placed',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
    )");
    $pdo->exec("ALTER TABLE orders ADD COLUMN IF NOT EXISTS payment_details VARCHAR(255) DEFAULT NULL");

    // Order Items Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS order_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id VARCHAR(20),
        product_name VARCHAR(100) NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        qty INT NOT NULL,
        size VARCHAR(10),
        status VARCHAR(20) DEFAULT 'Active',
        cancelled_at TIMESTAMP NULL,
        cancel_reason TEXT,
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
    )");

    // Product Cancellations Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS cancellations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        order_id VARCHAR(20),
        product_name VARCHAR(100) NOT NULL,
        quantity INT NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        size VARCHAR(10),
        cancel_reason TEXT,
        cancelled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        refund_status VARCHAR(20) DEFAULT 'Pending',
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE SET NULL
    )");

    echo "<div style='font-family:sans-serif; padding:40px; text-align:center;'>
            <h1 style='color:#2ecc71;'>✓ Success</h1>
            <p>Database and all tables created successfully!</p>
            <p style='color:#666;'>Tables created: users, login_logs, orders, order_items, cancellations</p>
            <a href='index.php' style='display:inline-block; margin-top:20px; padding:12px 24px; background:#111; color:white; text-decoration:none; border-radius:8px; font-weight:600;'>Go to Home</a>
          </div>";
} catch (PDOException $e) {
    echo "<div style='font-family:sans-serif; padding:40px; text-align:center;'>
            <h1 style='color:#e74c3c;'>✕ Error</h1>
            <p>Database setup failed: " . $e->getMessage() . "</p>
            <a href='index.php' style='display:inline-block; margin-top:20px; padding:12px 24px; background:#111; color:white; text-decoration:none; border-radius:8px; font-weight:600;'>Go to Home</a>
          </div>";
}
?>
            <p>" . $e->getMessage() . "</p>
            <p style='color:#666;'>Please make sure your XAMPP MySQL service is running.</p>
          </div>";
}
?>
