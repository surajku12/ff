<?php
require_once 'includes/db.php';
$result = $pdo->query('SHOW TABLES LIKE \'cancellations\'');
if ($result->rowCount() > 0) {
    echo 'Cancellations table exists';
} else {
    echo 'Cancellations table does not exist';
}
?>