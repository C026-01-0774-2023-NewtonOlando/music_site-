<?php
session_start();
require 'config_db.php';

if (!isset($_SESSION['uid'])) {
    echo "Please <a href='login.php'>login</a> first.";
    exit;
}

// Fetch logged-in user
$stmt = $pdo->prepare("SELECT id, name, is_paid FROM users WHERE id = ?");
$stmt->execute([$_SESSION['uid']]);
$user = $stmt->fetch();

if (!$user) {
    echo "User not found.";
    exit;
}

// Fetch all songs
$stmt = $pdo->query("SELECT * FROM songs ORDER BY id DESC");
$songs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
<title>Songs</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f1f1f1;
    padding: 20px;
}
.song-box {
    border: 1px solid #ddd;
    padding: 15px;
    margin-bottom: 15px;
    max-width: 720px;
    background: #fff;
    border-radius: 8px;
}
audio {
    width: 100%;
}
.download-btn {
    padding: 8px 15px;
    background: #111;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
.download-btn:hover {
    background: #333;
}
.locked {
    color: #c00;
    font-weight: bold;
}
</style>
</head>

<body>

<h1>Welcome, <?php echo htmlspecialchars($user['name']); ?></h1>
<h2>Available Songs</h2>

<?php if (empty($songs)): ?>
    <p>No songs uploaded yet.</p>

<?php else: foreach ($songs as $song): ?>

    <?php
        // ✅ FINAL, CORRECT WEB PATH
        $fileURL = '/' . ltrim($song['file_path'], '/');
    ?>

    <div class="song-box">
        <div>
            <strong><?php echo htmlspecialchars($song['title']); ?></strong>
            <?php if (!empty($song['artist'])): ?>
                — <?php echo htmlspecialchars($song['artist']); ?>
            <?php endif; ?>
        </div>

        <div style="font-size:0.9em;color:#666;">
            Uploaded: <?php echo htmlspecialchars($song['created_at']); ?>
        </div>

        <br>

        <?php if ($user['is_paid'] == 1): ?>

            <!-- AUDIO PLAYER -->
            <audio controls>
                <source src="<?php echo $fileURL; ?>" type="audio/wav">
                Your browser does not support the audio element.
            </audio>

            <br><br>

            <!-- DOWNLOAD BUTTON -->
            <a href="<?php echo $fileURL; ?>" download>
                <button class="download-btn">Download WAV</button>
            </a>

        <?php else: ?>

            <p class="locked">
                Kindly pay to unlock the audio player & download.
            </p>

        <?php endif; ?>

    </div>

<?php endforeach; endif; ?>

</body>
</html>
