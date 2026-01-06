<?php
// config_db.php

// Azure MySQL database connection details
$host = "dopemusic-server.mysql.database.azure.com"; // Must be your Azure host
$db   = "dopemusic_db";                             // Your Azure database name
$user = "tjedshpbot@dopemusic-server";             // Include @servername
$pass = "Matakomatako@10";                       // Your Azure MySQL password
$port = 3306;                                      // Default MySQL port

try {
    // Create PDO instance with proper charset and error mode
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
    // Optional: Uncomment to debug successful connection
    // echo "DB CONNECTED SUCCESSFULLY";
} catch (PDOException $e) {
    // Connection failed
    die("DB Connection failed: " . $e->getMessage());
}
?>
