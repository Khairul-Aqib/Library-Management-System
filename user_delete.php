<?php
session_start();
include('mysqli_connect.php');

if (!isset($_SESSION['user_id'])) {
    // User not logged in
    header("Location: Login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if there are any books that the user has borrowed but not returned
$query_check_borrowed_books = "SELECT COUNT(*) AS borrowed_count FROM borrowedbooks WHERE UserID = '$user_id' AND Status = 'Borrowed'";
$result_check_borrowed_books = mysqli_query($dbc, $query_check_borrowed_books);
$row = mysqli_fetch_assoc($result_check_borrowed_books);

if ($row['borrowed_count'] > 0) {
    // The user still has books that are borrowed and not returned
    echo '<script>
        alert("You cannot delete your account while you have borrowed books. Please return them first.");
        window.location.href = "userprofile.php";
    </script>';
    exit();
}

// Proceed to delete related data in borrowedbooks and bookhistory
$query1 = "DELETE FROM borrowedbooks WHERE UserID = '$user_id'";
$result1 = mysqli_query($dbc, $query1);

if ($result1) {
    // Now delete related data in bookhistory
    $query2 = "DELETE FROM bookhistory WHERE UserID = '$user_id'";
    $result2 = mysqli_query($dbc, $query2);

    if ($result2) {
        // Now delete the user
        $query3 = "DELETE FROM users WHERE UserID = '$user_id'";
        $result3 = mysqli_query($dbc, $query3);

        if ($result3) {
            // End session after account deletion
            session_destroy();

            // Redirect to login page with success message
            echo '<script>
                alert("Account deleted successfully.");
                window.location.href = "!Login.php";
            </script>';
            exit();
        } else {
            // Failed to delete user
            echo '<script>
                alert("Failed to delete account. Please try again.");
                window.location.href = "userprofile.php";
            </script>';
        }
    } else {
        // Failed to delete related data in bookhistory
        echo '<script>
            alert("Failed to delete related data in bookhistory. Please try again.");
            window.location.href = "userprofile.php";
        </script>';
    }
} else {
    // Failed to delete related data in borrowedbooks
    echo '<script>
        alert("Failed to delete related data in borrowedbooks. Please try again.");
        window.location.href = "userprofile.php";
    </script>';
}
?>
