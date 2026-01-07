<?php
$host = "dopemusic-server.mysql.database.azure.com";
$db   = "dopemusic_db";
$user = "tjedshpbot@dopemusic-server";
$pass = "YOUR_PASSWORD";
$port = 3306;

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;port=$port;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_SSL_CA => "/home/site/wwwroot/DigiCertGlobalRootCA.crt.pem"
        ]
    );
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
