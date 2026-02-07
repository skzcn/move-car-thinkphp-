<?php
// Standalone WxPush Debug Script
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

// Get AppToken
$stmt = $pdo->prepare("SELECT value FROM system_config WHERE name = ?");
$stmt->execute(['wxpush_app_token']);
$appToken = $stmt->fetchColumn();

// Hardcoded UID from log
$uid = 'UID_itsAzgZmXwwRJWrg16S0iGbuxBG2';

echo "AppToken: " . ($appToken ?: 'NULL') . "\n";
echo "UID: $uid\n";

if (!$appToken) {
    die("Error: AppToken not found in database.\n");
}

$url = "https://wxpusher.zjiecode.com/api/send/message";
$data = [
    'appToken' => $appToken,
    'content' => "Standalone Debug Message " . date('Y-m-d H:i:s'),
    'summary' => 'Debug',
    'contentType' => 1,
    'uids' => [$uid],
    'url' => 'http://example.com'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_VERBOSE, true);

$response = curl_exec($ch);
$error = curl_error($ch);
$info = curl_getinfo($ch);
curl_close($ch);

echo "Curl Error: $error\n";
echo "Response: $response\n";
echo "HTTP Code: " . $info['http_code'] . "\n";
