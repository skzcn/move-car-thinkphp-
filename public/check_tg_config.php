<?php
// Check User TG Config
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

$stmt = $pdo->prepare("SELECT username, tg_bot_token, tg_chat_id FROM users WHERE username = ?");
$stmt->execute(['123']);
$user = $stmt->fetch();

echo "User: " . $user['username'] . "\n";
echo "Bot Token: [" . $user['tg_bot_token'] . "]\n";
echo "Chat ID: [" . $user['tg_chat_id'] . "]\n";
