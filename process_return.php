<?php
session_start();
include('mysqli_connect.php');
include('includes/header.html');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || strpos($_SESSION['role'], 'admin') !== 0) {
    echo '<script type="text/javascript">';
    echo 'alert("You do not have permission to access this page.");';
    echo 'window.location.href = "homepage.php";';
    echo '</script>';
    exit();
}

// Check if the necessary POST data is set
if (isset($_POST['borrow_id']) && isset($_POST['book_id']) && isset($_POST['book_condition']) && isset($_POST['fines_paid'])) {
    $borrow_id = mysqli_real_escape_string($dbc, $_POST['borrow_id']);
    $book_id = mysqli_real_escape_string($dbc, $_POST['book_id']);
    $book_condition = mysqli_real_escape_string($dbc, $_POST['book_condition']);
    $fines_paid = mysqli_real_escape_string($dbc, $_POST['fines_paid']);
    $current_date = date('Y-m-d');

    // Step 1: Fetch the borrow details and dates from the borrowedbooks table
    $borrow_query = "
        SELECT BorrowDate, ReturnDate FROM borrowedbooks WHERE BorrowID = '$borrow_id'
    ";
    $borrow_result = mysqli_query($dbc, $borrow_query);
    if ($borrow_result && mysqli_num_rows($borrow_result) > 0) {
        $borrow_details = mysqli_fetch_assoc($borrow_result);
        $borrow_date = $borrow_details['BorrowDate'];
        $original_return_date = $borrow_details['ReturnDate'];

        // Step 2: Check if the book is returned late
        $is_late = (strtotime($current_date) > strtotime($original_return_date)) ? 1 : 0;
        $fine = 0.00;

        if ($is_late) {
            // Calculate fine (e.g., $1 per day late)
            $days_late = (strtotime($current_date) - strtotime($original_return_date)) / (60 * 60 * 24);
            $fine = $days_late * 1.00;  // Assuming $1 fine per day
        }

        // Step 3: Update the borrowedbooks table with the late status and fine
        $update_borrowedbooks_query = "
            UPDATE borrowedbooks 
            SET IsLate = '$is_late', Fine = '$fine', Status = 'Returned' 
            WHERE BorrowID = '$borrow_id'
        ";
        $update_result = mysqli_query($dbc, $update_borrowedbooks_query);

        // Step 4: If successful, update the books table to increment the available quantity
        if ($update_result) {
            $update_books_query = "
                UPDATE books 
                SET Quantity = Quantity + 1 
                WHERE BookID = '$book_id'
            ";
            $update_books_result = mysqli_query($dbc, $update_books_query);

            // Step 5: Insert record into bookhistory with the correct BorrowDate and DateReturned (current date)
            $insert_history_query = "
                INSERT INTO bookhistory (BookID, UserID, BorrowDate, ReturnDate, FinePaid, DateReturned, BookCondition)
                VALUES ('$book_id', (SELECT UserID FROM borrowedbooks WHERE BorrowID = '$borrow_id'), '$borrow_date', '$original_return_date', '$fines_paid', NOW(), '$book_condition')
            ";
            $insert_result = mysqli_query($dbc, $insert_history_query);

            if ($insert_result && $update_books_result) {
                echo '<script type="text/javascript">';
                echo 'alert("Book returned successfully and record updated!");';
                echo 'window.location.href = "return_book.php";';
                echo '</script>';
            } else {
                echo '<script type="text/javascript">';
                echo 'alert("Error updating book history.");';
                echo 'window.location.href = "return_book.php";';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("Error updating borrowed books.");';
            echo 'window.location.href = "return_book.php";';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Borrow record not found.");';
        echo 'window.location.href = "return_book.php";';
        echo '</script>';
    }
} else {
    echo '<script type="text/javascript">';
    echo 'alert("Invalid request. Missing borrow_id or book_id or condition.");';
    echo 'window.location.href = "return_book.php";';
    echo '</script>';
}
?>
