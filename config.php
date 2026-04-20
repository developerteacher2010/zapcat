<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$db   = getenv('DB_NAME') ?: 'zap_pro';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro na conexão com o banco: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

$mp_token = getenv('MP_ACCESS_TOKEN') ?: '';
$mp_webhook_secret = getenv('MP_WEBHOOK_SECRET') ?: '';

$app_url = getenv('APP_URL') ?: 'http://localhost/zap_pro';