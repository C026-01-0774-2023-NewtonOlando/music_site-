<?php
session_start();
require 'config_db.php';

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

            // SUCCESS → redirect
            header("Location: login.php");
            exit;

        } catch (PDOException $e) {

            // Email already exists
            if ($e->getCode() == 23000) {
                $error = "Email already registered.";
            } else {
                $error = "Registration failed.";
            }
        }

    } else {
        $error = "Please fill all fields.";
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
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
