<?php
session_start();
include('includes/header.html');
require('includes/mysqli_connect.php');

// Set timezone to Kuala Lumpur
date_default_timezone_set('Asia/Kuala_Lumpur');

// Handle removal from cart
if (isset($_GET['remove'])) {
    $remove_id = (int)$_GET['remove'];
    if (isset($_SESSION['borrow_cart'])) {
        $_SESSION['borrow_cart'] = array_filter($_SESSION['borrow_cart'], fn($id) => $id != $remove_id);
    }
    header("Location: checkout.php");
    exit;
}

// Fetch book details
$cart = $_SESSION['borrow_cart'] ?? [];
$books = [];

if (!empty($cart)) {
    $ids = implode(",", array_map('intval', $cart));
    $query = "SELECT * FROM books WHERE BookID IN ($ids)";
    $result = mysqli_query($dbc, $query);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $books[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f8f8;
            margin: 0;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
        }

        .back-button {
            margin-bottom: 20px;
        }

        .back-button a {
            text-decoration: none;
        }

        .back-button button {
            background-color: #555;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
        }

        .back-button button:hover {
            background-color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .book-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }

        .book-row img {
            width: 70px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }

        .book-info {
            flex-grow: 1;
            margin-left: 20px;
        }

        .book-info p {
            margin: 3px 0;
        }

        .remove-btn {
            background-color: #d9534f;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .remove-btn:hover {
            background-color: #c9302c;
        }

        .form-section {
            text-align: center;
            margin-top: 40px;
        }

        .form-section input {
            padding: 10px;
            font-size: 15px;
            margin: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-section button {
            margin-top: 20px;
            background-color: #407bff;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        .form-section button:hover {
            background-color: #2a62d0;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Back Button -->
    <div class="back-button">
        <a href="borrow_book.php">
            <button>← Back to Book List</button>
        </a>
    </div>

    <h2>Confirm Your Borrowing</h2>

    <?php if (empty($books)): ?>
        <p style="text-align:center;">Your borrow cart is empty.</p>
    <?php else: ?>
        <?php foreach ($books as $book): ?>
            <div class="book-row">
                <img src="uploads/<?= htmlspecialchars($book['Image']) ?>" alt="Book Cover"
                     onerror="this.onerror=null;this.src='uploads/default.jpg';">
                <div class="book-info">
                    <strong><?= htmlspecialchars($book['Title']) ?></strong>
                    <p><strong>Author:</strong> <?= htmlspecialchars($book['Author']) ?></p>
                </div>
                <a href="checkout.php?remove=<?= $book['BookID'] ?>"
                   onclick="return confirm('Are you sure you want to remove this book?');">
                    <button class="remove-btn">Remove</button>
                </a>
            </div>
        <?php endforeach; ?>

        <!-- Borrow Form -->
        <form method="POST" action="borrow_process.php" class="form-section">
            <label>Borrow Date:<br>
                <input type="date" name="borrow_date" value="<?= date('Y-m-d') ?>" required>
            </label><br>
            <label>Return Date (max 6 weeks):<br>
                <input type="date" name="return_date"
                       min="<?= date('Y-m-d') ?>"
                       max="<?= date('Y-m-d', strtotime('+6 weeks')) ?>"
                       required>
            </label><br>
            <button type="submit">Confirm Borrow</button>
        </form>
    <?php endif; ?>
</div>

<?php include('includes/footer.html'); ?>
</body>
</html>
