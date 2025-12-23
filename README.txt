Instructions:

1. Extract this folder into XAMPP htdocs, for example:
   C:\xampp\htdocs\music_site_corrected

2. Start Apache and MySQL in XAMPP.

3. Import 'schema.sql' into phpMyAdmin (http://localhost/phpmyadmin) or run the SQL via CLI.

4. Edit config_db.php if your MySQL username/password are different.

5. Open http://localhost/music_site_corrected/index.html

6. Register a user, then in phpMyAdmin set users.is_paid = 1 for that user to unlock player & download.

7. Upload WAV files via the Upload Song page (login required). Files are stored at uploads/songs/.

