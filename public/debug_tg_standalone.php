<?php
// Standalone Telegram Debug Script
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

// Get User 123's TG config
$stmt = $pdo->prepare("SELECT tg_bot_token, tg_chat_id FROM users WHERE username = ?");
$stmt->execute(['123']);
$userConfig = $stmt->fetch();

if (!$userConfig) {
    die("User '123' not found.\n");
}

// Try combining them if they look split
$token = $userConfig['tg_bot_token'] . ":" . $userConfig['tg_chat_id'];
$chatId = $userConfig['tg_bot_token']; // Maybe this is the chat ID?

echo "Combined Token: $token\n";
echo "Assumed Chat ID: $chatId\n";

$url = "https://api.telegram.org/bot{$token}/sendMessage";
$data = [
    'chat_id' => $chatId,
    'text' => "Telegram Combined Debug Message " . date('Y-m-d H:i:s'),
    'parse_mode' => 'Markdown'
];

echo "Sending to: $url\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_VERBOSE, true);

$response = curl_exec($ch);
$error = curl_error($ch);
$info = curl_getinfo($ch);
curl_close($ch);

echo "Curl Error: $error\n";
echo "Response: $response\n";
echo "HTTP Code: " . $info['http_code'] . "\n";

if ($info['http_code'] == 0) {
    echo "\nPossible Network Issue: Could not connect to Telegram API. This is common in mainland China if no proxy is used.\n";
}
