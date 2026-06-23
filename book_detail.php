<?php
session_start();
include('includes/header.html');
require('includes/mysqli_connect.php');

// Check for Book ID
if (!isset($_GET['id'])) {
    echo "<p>Book ID not specified.</p>";
    exit;
}

$book_id = (int)$_GET['id'];

// Add to borrow cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
    if (!isset($_SESSION['borrow_cart'])) {
        $_SESSION['borrow_cart'] = [];
    }
    if (!in_array($_POST['book_id'], $_SESSION['borrow_cart'])) {
        $_SESSION['borrow_cart'][] = $_POST['book_id'];
    }
    header("Location: borrow_book.php");
    exit;
}

// Get book details
$query = "SELECT * FROM books WHERE BookID = $book_id";
$result = mysqli_query($dbc, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "<p>Book not found.</p>";
    exit;
}

$book = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($book['Title']) ?> - Book Details</title>
    <link rel="stylesheet" href="includes/style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .detail-container {
            max-width: 1100px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 40px;
            display: flex;
            gap: 30px;
            align-items: flex-start;
        }

        .detail-container img {
            width: 280px;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
        }

        .book-info {
            flex: 1;
        }

        .book-info h1 {
            margin-bottom: 20px;
        }

        .book-info p {
            margin: 5px 0;
            font-size: 16px;
        }

        .actions {
            margin-top: 25px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .action-btn {
            width: 260px;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            transition: 0.3s ease;
            box-sizing: border-box;
        }

        .add-btn {
            background-color: #407bff;
            color: white;
            border: none;
        }

        .add-btn:hover {
            background-color: #2a62d0;
        }

        .back-btn {
            background-color: #555;
            color: white;
            border: none;
        }

        .back-btn:hover {
            background-color: #333;
        }
    </style>
</head>
<body>

<div class="detail-container">
    <img src="uploads/<?= htmlspecialchars($book['Image']) ?>" alt="Cover"
         onerror="this.onerror=null;this.src='uploads/default.jpg';">

    <div class="book-info">
        <h1><?= htmlspecialchars($book['Title']) ?></h1>
        <p><strong>Author:</strong> <?= htmlspecialchars($book['Author']) ?></p>
        <p><strong>Genre:</strong> <?= htmlspecialchars($book['Genre']) ?></p>
        <p><strong>Shelf:</strong> <?= htmlspecialchars($book['ShelfLocation']) ?></p>
        <p><strong>ISBN:</strong> <?= htmlspecialchars($book['ISBN']) ?></p>
        <p><strong>Publisher:</strong> <?= htmlspecialchars($book['Publisher']) ?></p>
        <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($book['Description'])) ?></p>
        <p><strong>Available:</strong> <?= (int)$book['Quantity'] ?></p>

        <div class="actions">
            <form method="POST">
                <input type="hidden" name="book_id" value="<?= $book['BookID'] ?>">
                <button type="submit" class="action-btn add-btn">Add to Borrow List</button>
            </form>
            <a href="borrow_book.php" class="action-btn back-btn">← Back to Book List</a>
        </div>
    </div>
</div>

<?php include('includes/footer.html'); ?>
</body>
</html>
