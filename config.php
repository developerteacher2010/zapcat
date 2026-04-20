<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = getenv('MYSQLHOST') ?: (getenv('DB_HOST') ?: 'localhost');
$user = getenv('MYSQLUSER') ?: (getenv('DB_USER') ?: 'root');
$pass = getenv('MYSQLPASSWORD') ?: (getenv('DB_PASS') ?: '');
$db   = getenv('MYSQLDATABASE') ?: (getenv('DB_NAME') ?: 'zap_pro');
$port = getenv('MYSQLPORT') ?: '3306';

$conn = new mysqli($host, $user, $pass, $db, (int)$port);

if ($conn->connect_error) {
    die("Erro na conexão com o banco: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

$app_url = getenv('APP_URL') ?: 'http://localhost/zap_pro';