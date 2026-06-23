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

$borrowed_books_result = null;
$user_email = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $user_email = mysqli_real_escape_string($dbc, trim($_POST['email']));

    // Ensure email is not empty
    if (empty($user_email)) {
        echo '<script type="text/javascript">';
        echo 'alert("Please enter a valid email.");';
        echo '</script>';
        exit();
    }

    // Fetch user details by email
    $query = "SELECT UserID FROM users WHERE Email = '$user_email'";
    $result = mysqli_query($dbc, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        $user_id = $user['UserID'];

        // Fetch borrowed books details, excluding the returned ones
        $query = "
            SELECT b.BookID, b.Title, b.Image, bb.BorrowDate, bb.ReturnDate, bb.BorrowID
            FROM borrowedbooks bb
            JOIN books b ON bb.BookID = b.BookID
            WHERE bb.UserID = '$user_id' AND bb.Status != 'Returned'
        ";
        $borrowed_books_result = mysqli_query($dbc, $query);
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("No user found with the provided email.");';
        echo '</script>';
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['borrow_id'])) {
    // Redirect to return.php without performing any further operations
    header("Location: return.php?borrow_id=" . $_POST['borrow_id']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Book</title>
    <style>
        .button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .form-container h1 {
            text-align: center;
        }

        .borrowed-books {
            margin-top: 20px;
        }

        .borrowed-books table {
            width: 100%;
            border-collapse: collapse;
        }

        .borrowed-books th, .borrowed-books td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .borrowed-books th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <br><br><br><br><br><br><br><br><div class="form-container">
        <h1>Return Book</h1>
        <form method="POST" action="return_book.php">
            <div class="form-group">
                <label for="email">User Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $user_email; ?>" required>
            </div>
            <br><button class="button" type="submit">Fetch Borrowed Books</button>
        </form>

        <?php if ($borrowed_books_result && mysqli_num_rows($borrowed_books_result) > 0) { ?>
            <div class="borrowed-books">
                <h2>Borrowed Books</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Borrow ID</th>
                            <th>Book Image</th> <!-- New column for image -->
                            <th>Title</th>
                            <th>Borrow Date</th>
                            <th>Return Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($book = mysqli_fetch_assoc($borrowed_books_result)) { ?>
                            <tr>
                                <td><?php echo $book['BorrowID']; ?></td> 
                                <td><img src="uploads/<?php echo htmlspecialchars($book['Image']); ?>" alt="Book Image" width="50" height="auto" onerror="this.onerror=null;this.src='uploads/default.jpg';"></td> <!-- Display image -->
                                <td><?php echo $book['Title']; ?></td>
                                <td><?php echo $book['BorrowDate']; ?></td>
                                <td><?php echo $book['ReturnDate']; ?></td>
                                
                                <td>
                                    <form method="POST" action="return.php">
                                        <input type="hidden" name="borrow_id" value="<?php echo $book['BorrowID']; ?>">
                                        <input type="hidden" name="book_id" value="<?php echo $book['BookID']; ?>">
                                        <button class="button" type="submit">Return</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } elseif ($user_email) { ?>
            <p>No borrowed books found for the provided email.</p>
        <?php } ?>

        <!-- Back Button -->
        <a href="adminDashboard.php">
            <button class="button">Back to Dashboard</button>
        </a>
    </div><br><br><br><br>

    <?php include('includes/footer.html'); ?>
</body>
</html>
