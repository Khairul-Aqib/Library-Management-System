<?php

// ──────────────────────────────────────────────────────────────
// Example database connection file.
// Copy this file to "mysqli_connect.php" and fill in your own
// database credentials. Do NOT commit the real mysqli_connect.php.
// ──────────────────────────────────────────────────────────────

if (!defined('DB_USER'))     define('DB_USER', 'your_db_user');
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', 'your_db_password');
if (!defined('DB_HOST'))     define('DB_HOST', 'localhost');
if (!defined('DB_NAME'))     define('DB_NAME', 'library_management');

// Make the connection:
$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    or die('Could not connect to MySQL: ' . mysqli_connect_error());

// Set the encoding...
mysqli_set_charset($dbc, 'utf8');
?>
