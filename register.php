<?php
session_start();
require 'config_db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name && $email && $password) {
        try {
            $hash = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $pdo->prepare(
                "INSERT INTO users (name, email, password) VALUES (?, ?, ?)"
            );
            $stmt->execute([$name, $email, $hash]);

            // redirect after successful registration
            header("Location: login.php");
            exit;

        } catch (PDOException $e) {
            // 🔴 TEMP DEBUG — DO NOT REMOVE YET
            die("Registration failed: " . $e->getMessage());
        }
    } else {
        $error = 'Please fill all fields.';
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
</head>
<body>

<h2>Register</h2>

<?php if (!empty($error)): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="post" action="register.php">
    <input name="name" placeholder="Name" required><br><br>
    <input name="email" type="email" placeholder="Email" required><br><br>
    <input name="password" type="password" placeholder="Password" required><br><br>
    <button type="submit">Register</button>
</form>

</body>
</html>
