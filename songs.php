<?php
session_start();
require 'config_db.php';

if (!isset($_SESSION['uid'])) {
    echo "Please <a href='login.php'>login</a> first."; 
    exit;
}

// Fetch user
$stmt = $pdo->prepare("SELECT id, name, is_paid FROM users WHERE id = ?");
$stmt->execute([$_SESSION['uid']]);
$user = $stmt->fetch();
if (!$user) { 
    echo "User not found."; 
    exit; 
}

// Fetch songs
$stmt = $pdo->query("SELECT * FROM songs ORDER BY id DESC");
$songs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Songs</title>
<style>
body{font-family:Arial;padding:20px;}
.song-box{border:1px solid #ddd;padding:12px;margin-bottom:12px;max-width:720px;background:#fff;}
audio{width:100%;}
</style>
</head>
<body>

<h1>Welcome, <?php echo htmlspecialchars($user['name']); ?></h1>
<h2>Available Songs</h2>

<?php if (empty($songs)): ?>
  <p>No songs uploaded yet.</p>

<?php else: foreach ($songs as $song): 

    // FIXED ✔ Convert database path -> WEB URL path
    // If file_path contains ONLY filename:
    $filePath = $song['file_path'];

    // Normalize path (remove Windows path if mistakenly stored)
    $filePath = str_replace("C:\\Users\\Admin\\Downloads\\xammp\\htdocs\\music_site\\", "", $filePath);
    $filePath = str_replace("C:\\xampp\\htdocs\\music_site\\", "", $filePath);
    $filePath = str_replace("\\", "/", $filePath);

    // Final URL the browser can use
    $fileURL = "/music_site/" . $filePath;

?>
  <div class="song-box">
    <div><strong><?php echo htmlspecialchars($song['title']); ?></strong> — 
    <?php echo htmlspecialchars($song['artist'] ?? ''); ?></div>

    <div style="font-size:0.9em;color:#666;">
        Uploaded: <?php echo htmlspecialchars($song['created_at'] ?? ''); ?>
    </div>
    <br>

    <?php if ($user['is_paid'] == 1): ?>
      
      <!-- AUDIO PLAYER FIXED -->
      <audio controls>
        <source src="<?php echo $fileURL; ?>" type="audio/wav">
        Your browser does not support the audio element.
      </audio>

      <br><br>

      <!-- DOWNLOAD BUTTON FIXED -->
      <a href="<?php echo $fileURL; ?>" download>
        <button>Download WAV</button>
      </a>

    <?php else: ?>
      <p style="color:#c00;">Kindly Pay to unlock audio player & download.</p>
    <?php endif; ?>

  </div>

<?php endforeach; endif; ?>

</body>
</html>
