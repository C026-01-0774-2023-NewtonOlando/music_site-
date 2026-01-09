<?php
// 🔴 SHOW ERRORS (IMPORTANT FOR AZURE DEBUGGING)
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'config_db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name && $email && $password) {
        try {
            // 🔍 Check if email already exists
            $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $check->execute([$email]);

            if ($check->fetch()) {
                $error = "Email already registered. Please login.";
            } else {
                // 🔐 Hash password
                $hash = password_hash($password, PASSWORD_BCRYPT);

                // 💾 Insert user
                $stmt = $pdo->prepare(
                    "INSERT INTO users (name, email, password) VALUES (?, ?, ?)"
                );
                $stmt->execute([$name, $email, $hash]);

                // ✅ Redirect to login
                header("Location: login.php");
                exit;
            }

        } catch (PDOException $e) {
            // ❌ Database error
            $error = "Registration failed: " . $e->getMessage();
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

<p style="margin-top:15px;">
    Already have an account? <a href="login.php">Login</a>
</p>

</body>
</html>
