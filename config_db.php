<?php
$host = "dope.mysql.database.azure.com";
$db   = "musicdb";
$user = "dope__alfredo";
$pass = "Matakomatako@10";
$port = 3306;

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_SSL_CA => "/home/site/wwwroot/DigiCertGlobalRootCA.crt.pem",
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
        ]
    );

} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
