<?php
// Test DB Insert
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
} catch (\PDOException $e) {
    die("DB Connection Failed: " . $e->getMessage());
}

$name = 'wxpush_app_token';
$value = 'TEST_TOKEN_' . time();

// Check if exists
$stmt = $pdo->prepare("SELECT * FROM system_config WHERE name = ?");
$stmt->execute([$name]);
$exists = $stmt->fetch();

if ($exists) {
    echo "Record exists. Updating...\n";
    $stmt = $pdo->prepare("UPDATE system_config SET value = ? WHERE name = ?");
    $stmt->execute([$value, $name]);
} else {
    echo "Record does not exist. Inserting...\n";
    $stmt = $pdo->prepare("INSERT INTO system_config (name, value, title) VALUES (?, ?, ?)");
    $stmt->execute([$name, $value, 'WxPush AppToken']);
}

echo "Operation done. Verifying...\n";
$stmt = $pdo->prepare("SELECT * FROM system_config WHERE name = ?");
$stmt->execute([$name]);
$row = $stmt->fetch();
print_r($row);
