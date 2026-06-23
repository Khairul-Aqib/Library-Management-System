<?php
session_start();
include('includes/mysqli_connect.php');
include('includes/header.html');

// Permission check for admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['email']) || strpos($_SESSION['role'], 'admin') !== 0) {
    echo '<script>alert("You do not have permission to access this page."); window.location.href = "homepage.php";</script>';
    exit();
}

// Handle book deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
    $book_id = mysqli_real_escape_string($dbc, trim($_POST['book_id']));
    
    // Soft delete: set IsActive = 0 instead of deleting
    $query = "UPDATE books SET IsActive = 0 WHERE BookID = '$book_id'";
    $result = mysqli_query($dbc, $query);

    if ($result) {
        echo '<script>alert("Book hidden successfully."); window.location.href = "remove_book.php";</script>';
    } else {
        echo '<script>alert("Error hiding the book: ' . mysqli_error($dbc) . '");</script>';
    }
}

// Fetch all books
$query = "SELECT * FROM books WHERE IsActive = 1 ORDER BY Title";
$result = mysqli_query($dbc, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Remove Book</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .main-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
            min-height: 100vh;
        }

        .form-container {
            width: 100%;
            max-width: 900px;
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px 12px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background-color: #f2f2f2;
        }

         /* General img styling for book covers */
        img {
            width: 60px; /* Book cover size */
            height: 90px;
            object-fit: cover;
            border-radius: 4px;
        }

        /* Specific styling for the header logo */
        .header-logo {
            width: 180px; /* Header logo size */
            height: auto;
            object-fit: contain; /* Maintains the aspect ratio of the logo */
        }

        .delete-btn {
            background-color: #d9534f;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: #c9302c;
        }

        .back-button {
            padding: 6px 12px;
            background-color: #007bff;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        .header-container {
            width: 100%;
            display: flex;
            justify-content: space-between; /* Pushes elements to both sides */
            align-items: center;
            margin-bottom: 20px;
        }

        h1 {
            flex-grow: 1; /* Ensures the h1 takes up the available space */
            text-align: center;
        }
    </style>
</head>
<body>
<div class="main-container">
    <div class="form-container">
        <div class="header-container">
            <h1>Remove a Book</h1>
            <a href="adminDashboard.php" class="back-button">Back to Dashboard</a>
        </div>
        
        <table>
            <tr>
                <th>Cover</th>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Delete</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td>
                        <img src="uploads/<?= htmlspecialchars($row['Image']) ?>" alt="Cover"
                            onerror="this.onerror=null;this.src='uploads/default.jpg';">
                    </td>
                    <td><?= htmlspecialchars($row['Title']) ?></td>
                    <td><?= htmlspecialchars($row['Author']) ?></td>
                    <td><?= htmlspecialchars($row['ISBN']) ?></td> 
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="book_id" value="<?= $row['BookID'] ?>">
                            <button type="submit" class="delete-btn"
                                    onclick="return confirm('Are you sure you want to delete this book?');">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<?php include('includes/footer.html'); ?>
</body>
</html>
