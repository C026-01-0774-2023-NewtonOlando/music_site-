<?php
session_start();
require 'config_db.php';
if (!isset($_SESSION['uid'])) { echo 'Login required.'; exit; }

// OPTIONAL: If you want only admin to upload, add an is_admin check here.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $artist = trim($_POST['artist'] ?? '');

    if (empty($title) || !isset($_FILES['wavfile'])) {
        $error = 'Missing title or file.';
    } else {
        $file = $_FILES['wavfile'];
        if ($file['error'] !== UPLOAD_ERR_OK) $error = 'Upload error.';
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if ($ext !== 'wav') $error = 'Only WAV allowed.';
        if (empty($error)) {
            $uploadsDir = __DIR__ . '/uploads/songs';
            if (!is_dir($uploadsDir)) mkdir($uploadsDir, 0755, true);
            $safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/','_', $file['name']);
            $dest = $uploadsDir . '/' . $safeName;
            if (move_uploaded_file($file['tmp_name'], $dest)) {
                $publicPath = 'uploads/songs/' . $safeName;
                $stmt = $pdo->prepare('INSERT INTO songs (title, artist, file_name, file_path, created_at) VALUES (?, ?, ?, ?, NOW())');
                $stmt->execute([$title, $artist, $safeName, $publicPath]);
                $success = 'Uploaded successfully.';
            } else $error = 'Failed to move file.';
        }
    }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Upload Song</title></head><body>
<h2>Upload WAV</h2>
<?php if(!empty($error)) echo "<p style='color:red;'>".htmlspecialchars($error)."</p>"; ?>
<?php if(!empty($success)) echo "<p style='color:green;'>".htmlspecialchars($success)."</p>"; ?>
<form method="post" enctype="multipart/form-data">
  <label>Title</label><br><input name="title" required><br><br>
  <label>Artist</label><br><input name="artist"><br><br>
  <label>WAV file</label><br><input type="file" name="wavfile" accept='.wav' required><br><br>
  <button type="submit">Upload</button>
</form>
</body></html>
