<?php 
session_start();
include('mysqli_connect.php');
include('includes/header.html');

if (!isset($_SESSION['user_id'])) {
    echo '<script type="text/javascript">';
    echo 'alert("You need to log in to view your profile.");';
    echo 'window.location.href = "!Login.php";';
    echo '</script>';
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE UserID = '$user_id'";
$result = mysqli_query($dbc, $query);
$user = mysqli_fetch_assoc($result);

$query = "
    SELECT b.title, br.BorrowDate, br.ReturnDate 
    FROM borrowedbooks br
    JOIN books b ON br.BookID = b.BookID
    WHERE br.UserID = '$user_id' AND br.Status = 'Borrowed'
";

$borrowed_books_result = mysqli_query($dbc, $query);

$history_query = "
    SELECT b.Title, bh.BorrowDate, bh.ReturnDate, bh.FinePaid, bh.DateReturned
    FROM bookhistory bh
    JOIN books b ON bh.BookID = b.BookID
    WHERE bh.UserID = '$user_id'
    ORDER BY bh.BorrowDate DESC
";


$history_result = mysqli_query($dbc, $history_query);

?>

 
<html>

<head>
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

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container h1, .form-container h2 {
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
    <div class="form-container">
        <h1>User Profile</h1>
        <?php if ($user) { ?>
            <p><strong>Name:</strong> <?php echo $user['FullName']; ?></p>
<p><strong>Email:</strong> <?php echo $user['Email']; ?></p>
<p><strong>Joined:</strong> <?php echo $user['DateRegistered']; ?></p>

        <?php } else { ?>
            <p>User details not found.</p>
        <?php } ?>


        <h2>Update Password</h2>
        <form action="user_update.php" method="POST">
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button class="button" type="submit">Update Password</button>
        </form>

        <h2>Delete Account</h2>
        <form action="user_delete.php" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
            <button class="button" type="submit">Delete Account</button>
        </form>
    </div>
    <div class="borrowed-books">
            <h2>Borrowed Books</h2>
            <?php if (mysqli_num_rows($borrowed_books_result) > 0) { ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Borrow Date</th>
                            <th>Return Date</th>
                            <th>Date Returned</th>
                            <th>Fine Paid (RM)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($book = mysqli_fetch_assoc($borrowed_books_result)) { ?>
                            <tr>
                                <td><?php echo $book['title']; ?></td>
                                <td><?php echo date("d M Y", strtotime($book['BorrowDate'])); ?></td>
<td><?php echo date("d M Y", strtotime($book['ReturnDate'])); ?></td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p>No borrowed books found.</p>
            <?php } ?>
        </div>
<div class="borrowed-books">
    <h2>Book History</h2>
    <?php if (mysqli_num_rows($history_result) > 0) { ?>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Borrow Date</th>
                    <th>Return Date</th>
                    <th>Date & Time Returned</th>
                    <th>Fine Paid (RM)</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($history = mysqli_fetch_assoc($history_result)) { ?>
                    <tr>
                        <td><?php echo $history['Title']; ?></td>
                        <td><?php echo $history['BorrowDate']; ?></td>
                        <td><?php echo $history['ReturnDate']; ?></td>
                        <td><?php echo $history['DateReturned']; ?></td>
                        <td><?php echo number_format($history['FinePaid'], 2); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No book history found.</p>
    <?php } ?>
</div>

    <?php include('includes/footer.html'); ?>
</body>
</html>