<?php
include('includes/header.html');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Home</title>
    <style>
        .hero-section {
            background-image: url('assets/background.png'); /* Updated background path */
            background-size: cover;
            background-position: center;
            height: calc(100vh - 200px);
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            padding: 20px;
        }

        .hero-section h1 {
            font-size: 48px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 6px rgba(0,0,0,0.5);
        }

        .hero-section p {
            font-size: 20px;
            margin-bottom: 30px;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.4);
        }

        .home-button {
            padding: 12px 25px;
            font-size: 18px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .home-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div>
            <h1>Welcome to Cyberia Community Library</h1>
            <p>Explore and Discover Your Favorite Books</p>
            <a href="borrow_book.php" class="home-button">Browse Books</a>
        </div>
    </div>

<?php
include('includes/footer.html');
?>
</body>
</html>
