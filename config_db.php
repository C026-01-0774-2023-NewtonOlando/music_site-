<?php
$host = "dopemusic-server.mysql.database.azure.com";
$db   = "dopemusic_db";
$user = "tjedshpbot@dopemusic-server";
$pass = "Matakomatako@10";
$port = 3306;

try {
    $dsn = "mysql:host=$host;dbname=$db;port=$port;charset=utf8mb4;sslmode=required";
    
    $pdo = new PDO(
        $dsn,
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
