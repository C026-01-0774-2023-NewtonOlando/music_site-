<?php
session_start();
require 'config_db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $email && $password) {
        try {
            $hash = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $pdo->prepare(
                "INSERT INTO users (username, email, password) VALUES (?, ?, ?)"
            );
            $stmt->execute([$username, $email, $hash]);

            header("Location: login.php");
            exit;

        } catch (PDOException $e) {
            die("Registration failed: " . $e->getMessage());
        }
    } else {
        $error = 'Please fill all fields.';
    }
}
?>
