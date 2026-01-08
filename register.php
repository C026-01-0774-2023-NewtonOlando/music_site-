<?php
require 'config_db.php';
if($_POST){
  $stmt=$pdo->prepare("INSERT INTO users(name,email,password) VALUES(?,?,?)");
  $stmt->execute([$_POST['name'],$_POST['email'],password_hash($_POST['password'],PASSWORD_BCRYPT)]);
  echo "Registered. <a href='login.php'>Login</a>";
  exit;
}
?>
<form method="post">
  <input name="name" placeholder="Name"><br>
  <input name="email" placeholder="Email"><br>
  <input name="password" type="password" placeholder="Password"><br>
  <button>Register</button>
</form>
