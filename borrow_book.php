<?php
session_start();
include('includes/header.html');
require('includes/mysqli_connect.php');

// Search & filter logic
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$filter_sql = '';

if (!empty($search)) {
    $s = mysqli_real_escape_string($dbc, $search);
    $filter_sql .= " AND (Title LIKE '%$s%' OR Author LIKE '%$s%')";
}
if (!empty($category)) {
    $c = mysqli_real_escape_string($dbc, $category);
    $filter_sql .= " AND Genre = '$c'";
}

$query = "SELECT * FROM books WHERE Quantity > 0 AND IsActive = 1 $filter_sql ORDER BY Title ASC";
$result = mysqli_query($dbc, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Borrow Books</title>
    <link rel="stylesheet" href="includes/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f5f5f5;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            padding: 25px 30px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            gap: 10px;
        }

        .top-bar form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .top-bar input, .top-bar select, .top-bar button {
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .top-bar button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .top-bar button:hover {
            background-color: #0056b3;
        }

        .cart-icon {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
        }

        .cart-icon img {
            width: 32px;
            height: 32px;
            filter: brightness(0) invert(1);
        }

        .book-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 30px;
        }

        .book-card {
            width: 250px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .book-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 6px;
        }

        .book-card h3 {
            margin-top: 10px;
            font-size: 18px;
        }

        .book-card p {
            margin: 5px 0;
            font-size: 14px;
        }

        .book-card a.button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #407bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }

        .book-card a.button:hover {
            background-color: #2a62d0;
        }

        .no-results {
            text-align: center;
            font-size: 18px;
            color: #555;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<!-- Top Bar -->
<div class="top-bar">
    <form method="GET">
        <input type="text" name="search" placeholder="Search..." value="<?= htmlspecialchars($search) ?>">
        <select name="category">
            <option value="">All Categories</option>
            <option value="Fantasy" <?= $category == 'Fantasy' ? 'selected' : '' ?>>Fantasy</option>
            <option value="Autobiography" <?= $category == 'Autobiography' ? 'selected' : '' ?>>Autobiography</option>
            <option value="Historical Fiction" <?= $category == 'Historical Fiction' ? 'selected' : '' ?>>Historical Fiction</option>
        </select>
        <button type="submit">Search</button>
    </form>

    <!-- Book Basket Icon -->
    <a href="checkout.php" class="cart-icon">
        <img src="assets/basket.png" alt="Basket">
        <?= isset($_SESSION['borrow_cart']) ? count($_SESSION['borrow_cart']) : 0 ?>
    </a>
</div>

<!-- Book Cards -->
<div class="book-grid">
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="book-card">
                <img src="uploads/<?= htmlspecialchars($row['Image']) ?>" alt="Cover"
                     onerror="this.onerror=null;this.src='uploads/default.jpg';">
                <h3><?= htmlspecialchars($row['Title']) ?></h3>
                <p><strong>Author:</strong> <?= htmlspecialchars($row['Author']) ?></p>
                <p><strong>Genre:</strong> <?= htmlspecialchars($row['Genre']) ?></p>
                <p><strong>Available:</strong> <?= (int)$row['Quantity'] ?></p>
                <a class="button" href="book_detail.php?id=<?= $row['BookID'] ?>">View Book</a>
            </div>
        <?php } ?>
    <?php else: ?>
        <p class="no-results">No books found.</p>
    <?php endif; ?>
</div>

<?php include('includes/footer.html'); ?>
</body>
</html>
