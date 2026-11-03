<?php
$passwords = ['', 'root', 'admin', 'password'];
foreach ($passwords as $p) {
    try {
        $pdo = new PDO('mysql:host=127.0.0.1', 'root', $p);
        die("SUCCESS:password=$p");
    } catch (PDOException $e) {
        echo "Fail with '$p': " . $e->getMessage() . "\n";
    }
}
?>
