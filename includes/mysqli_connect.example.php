<?php

// ──────────────────────────────────────────────────────────────
// Example database connection file.
// Copy this file to "mysqli_connect.php" and fill in your own
// database credentials. Do NOT commit the real mysqli_connect.php.
// ──────────────────────────────────────────────────────────────

define('DB_HOST', 'localhost');
define('DB_USER', 'your_db_user');
define('DB_PASSWORD', 'your_db_password');
define('DB_NAME', 'library_management');

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$dbc) {
    die('Database connection failed: ' . mysqli_connect_error());
}
?>
