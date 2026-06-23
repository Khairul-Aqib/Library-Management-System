<?php
session_start();
require('includes/mysqli_connect.php'); // DB connection
include('includes/header.html');

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || strpos($_SESSION['role'], 'admin') !== 0) {
    echo '<script type="text/javascript">';
    echo 'alert("You do not have permission to access this page.");';
    echo 'window.location.href = "homepage.php";';
    echo '</script>';
    exit();
}

// === Get data from database ===

// Total users
$user_count = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT COUNT(*) AS total FROM users"))['total'] ?? 0;

// Total books
$book_count = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT COUNT(*) AS total FROM books"))['total'] ?? 0;

// Total books borrowed (sum of AmountBorrowed)
$books_borrowed = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT SUM(AmountBorrowed) AS total FROM books"))['total'] ?? 0;

// Active borrowings (not yet returned or return date is in the future)
$today = date('Y-m-d');
$active_borrows = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT COUNT(*) AS total FROM borrowedbooks WHERE (ReturnDate >= '$today' OR ReturnDate IS NULL) AND Status != 'Returned'"))['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
        }

        .header {
            background-color: #0056b3;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .dashboard {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .card {
            flex: 1 1 250px;
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .card h2 {
            margin: 0;
            font-size: 24px;
            color: #007bff;
        }

        .card p {
            font-size: 16px;
            color: #555;
        }

        .quick-links {
            margin-top: 40px;
            text-align: center;
        }

        .button-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }

        .quick-button {
            padding: 12px 30px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .quick-button:hover {
            background-color: #004c99;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Welcome, Admin</h1>
    <p>Library Management System Dashboard</p>
</div>

<div class="dashboard">
    <div class="card-container">
        <div class="card">
            <h2><?= $user_count ?></h2>
            <p>Total Users</p>
        </div>
        <div class="card">
            <h2><?= $books_borrowed ?></h2>
            <p>Books Borrowed</p>
        </div>
        <div class="card">
            <h2><?= $book_count ?></h2>
            <p>Total Books</p>
        </div>
        <div class="card">
            <h2><?= $active_borrows ?></h2>
            <p>Active Borrowings</p>
        </div>
    </div>

    <div class="quick-links">
        <h2>Quick Access</h2>
        <div class="button-container">
            <form action="add_book.php" method="get">
                <button class="quick-button" type="submit">Add Books</button>
            </form>
            <form action="remove_book.php" method="get">
                <button class="quick-button" type="submit">Remove Books</button>
            </form>
            <form action="return_book.php" method="get">
                <button class="quick-button" type="submit">Return Book</button>
            </form>
            <form action="book_report.php" method="get">
                <button class="quick-button" type="submit">Borrow History</button>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.html'); ?>
</body>
</html>
