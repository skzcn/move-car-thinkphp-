<?php
// DB Migration: Add wxpush_app_token to users
header('Content-Type: text/plain; charset=utf-8');

$host = '127.0.0.1';
$db   = 'dd';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // Check if column exists
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll();
    $exists = false;
    foreach ($columns as $col) {
        if ($col['Field'] === 'wxpush_app_token') {
            $exists = true;
            break;
        }
    }
    
    if (!$exists) {
        $pdo->exec("ALTER TABLE users ADD COLUMN wxpush_app_token VARCHAR(255) DEFAULT NULL AFTER wxpush_uid");
        echo "Column wxpush_app_token added successfully.\n";
    } else {
        echo "Column wxpush_app_token already exists.\n";
    }
    
    print_r($columns);
} catch (\Exception $e) {
    die("Error: " . $e->getMessage());
}
