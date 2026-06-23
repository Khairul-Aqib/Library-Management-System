<?php
session_start();
require('includes/mysqli_connect.php');

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id || empty($_SESSION['borrow_cart'])) {
    header("Location: borrow_book.php");
    exit;
}

$borrow_date = $_POST['borrow_date'] ?? '';
$return_date = $_POST['return_date'] ?? '';
$today = date('Y-m-d');
$max_return = date('Y-m-d', strtotime('+6 weeks'));

if ($return_date > $max_return || $return_date < $borrow_date) {
    echo "<script>alert('Invalid return date. Max allowed is 6 weeks from today.'); history.back();</script>";
    exit;
}

$cart = $_SESSION['borrow_cart'];
$errors = [];
$successes = [];

foreach ($cart as $book_id) {
    $book_id = (int)$book_id;

    // Check availability
    $check_query = "SELECT Quantity FROM books WHERE BookID = $book_id";
    $check_result = mysqli_query($dbc, $check_query);
    $book = mysqli_fetch_assoc($check_result);

    if (!$book || $book['Quantity'] <= 0) {
        $errors[] = "Book ID $book_id is no longer available.";
        continue;
    }

    // Insert into BorrowedBooks table
    $insert = "INSERT INTO BorrowedBooks (BookID, UserID, BorrowDate, ReturnDate, IsLate, Fine)
               VALUES ($book_id, $user_id, '$borrow_date', '$return_date', 0, 0.00)";
    mysqli_query($dbc, $insert);

    // Update stock and popularity
    $update = "UPDATE books 
               SET Quantity = Quantity - 1, AmountBorrowed = AmountBorrowed + 1 
               WHERE BookID = $book_id";
    mysqli_query($dbc, $update);

    $successes[] = $book_id;
}

// Clear the cart
$_SESSION['borrow_cart'] = [];

if (!empty($successes)) {
   echo "<script>alert('Books successfully borrowed.'); window.location.href='userprofile.php';</script>";

} else {
    echo "<script>alert('No books were borrowed.'); window.location.href='borrow_book.php';</script>";
}
?>
