<?php
echo "USER=" . getenv('DB_USER') . "<br>";
echo "HOST=" . getenv('DB_HOST') . "<br>";
echo "DB=" . getenv('DB_NAME') . "<br>";
echo "PORT=" . getenv('DB_PORT') . "<br>";
echo "PASS_LEN=" . strlen(getenv('DB_PASS'));
