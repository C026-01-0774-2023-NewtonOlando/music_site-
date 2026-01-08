<?php
session_start();
require 'config_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $u = $stmt->fetch();

    if ($u && password_verify($password, $u['password'])) {
        $_SESSION['uid'] = $u['id'];
        header('Location: songs.php');
        exit;
    } else {
        $error = 'Invalid credentials.';
    }
}
?>
<!doctype html>
<html><head>
<link rel="stylesheet" href="style.css">
<title>Login</title></head><body>
<h2>Login</h2>
<?php if(!empty($error)) echo "<p style='color:red;'>".htmlspecialchars($error)."</p>"; ?>
<form method="post">
  <input name="email" type="email" placeholder="Email" required><br><br>
  <input name="password" type="password" placeholder="Password" required><br><br>
  <button type="submit">Login</button>
  <p style="text-align:center; margin-top:15px;">
    <a href="forgot_password.php" style="text-decoration:none; font-weight:bold;">
        Forgot your password?
    </a>
</p>

</form>
</body></html>
