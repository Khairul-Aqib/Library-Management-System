<?php
session_start();
include('mysqli_connect.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo '<script>alert("Passwords do not match."); window.location.href = "userprofile.php";</script>';
        exit();
    }

    // Hash the password using SHA1
    $hashed_password = sha1($new_password);

    // Update password in the database
    $query = "UPDATE users SET Password = '$hashed_password' WHERE UserID = '$user_id'";
    $result = mysqli_query($dbc, $query);

    if ($result) {
        echo '<script>alert("Password updated successfully."); window.location.href = "userprofile.php";</script>';
    } else {
        echo '<script>alert("Failed to update password."); window.location.href = "userprofile.php";</script>';
    }
}
?>
