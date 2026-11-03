<?php
$host = '127.0.0.1';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create Database
$sql = "CREATE DATABASE IF NOT EXISTS fashiofy";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error . "\n";
}

$conn->select_db('fashiofy');

// Users Table for login tracking
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15),
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    login_count INT DEFAULT 0
)";

if ($conn->query($sql) === TRUE) {
    echo "Table users created successfully\n";
} else {
    echo "Error creating table users: " . $conn->error . "\n";
}

// Login Logs Table
$sql = "CREATE TABLE IF NOT EXISTS login_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    email VARCHAR(100),
    login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45),
    user_agent TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table login_logs created successfully\n";
} else {
    echo "Error creating table login_logs: " . $conn->error . "\n";
}

// Orders Table
$sql = "CREATE TABLE IF NOT EXISTS orders (
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
)";

if ($conn->query($sql) === TRUE) {
    echo "Table orders created successfully\n";
} else {
    echo "Error creating table orders: " . $conn->error . "\n";
}

$sql = "ALTER TABLE orders ADD COLUMN IF NOT EXISTS payment_details VARCHAR(255) DEFAULT NULL";
if ($conn->query($sql) === TRUE) {
    echo "Order payment_details column ensured\n";
} else {
    echo "Error ensuring payment_details column: " . $conn->error . "\n";
}

// Order Items Table
$sql = "CREATE TABLE IF NOT EXISTS order_items (
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
)";

if ($conn->query($sql) === TRUE) {
    echo "Table order_items created successfully\n";
} else {
    echo "Error creating table order_items: " . $conn->error . "\n";
}

// Product Cancellations Table
$sql = "CREATE TABLE IF NOT EXISTS cancellations (
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
)";

if ($conn->query($sql) === TRUE) {
    echo "Table cancellations created successfully\n";
} else {
    echo "Error creating table cancellations: " . $conn->error . "\n";
}

$conn->close();
echo "All tables created successfully!\n";
?>

$conn->close();
?>
