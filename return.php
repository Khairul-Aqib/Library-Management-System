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

// Initialize variables
$book_details = null;
$borrow_details = null;
$fine = 0.00;
$days_late = 0;

if (isset($_POST['borrow_id']) && isset($_POST['book_id'])) {
    $borrow_id = mysqli_real_escape_string($dbc, $_POST['borrow_id']);
    $book_id = mysqli_real_escape_string($dbc, $_POST['book_id']);

    // Fetch book details
    $book_query = "SELECT * FROM books WHERE BookID = '$book_id'";
    $book_result = mysqli_query($dbc, $book_query);
    if ($book_result && mysqli_num_rows($book_result) > 0) {
        $book_details = mysqli_fetch_assoc($book_result);
    }

    // Fetch borrow details
    $borrow_query = "SELECT bb.BorrowID, bb.BorrowDate, bb.ReturnDate FROM borrowedbooks bb WHERE bb.BorrowID = '$borrow_id'";
    $borrow_result = mysqli_query($dbc, $borrow_query);
    if ($borrow_result && mysqli_num_rows($borrow_result) > 0) {
        $borrow_details = mysqli_fetch_assoc($borrow_result);

        // Fine calculation
        $return_due = $borrow_details['ReturnDate'];
        $today = date('Y-m-d');
        $days_late = floor((strtotime($today) - strtotime($return_due)) / (60 * 60 * 24));
        $fine = $days_late > 0 ? $days_late * 1.00 : 0.00;
    }

} else {
    echo '<script type="text/javascript">';
    echo 'alert("Invalid request. POST data: ' . json_encode($_POST) . '");';
    echo 'window.location.href = "return_book.php";';
    echo '</script>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Return Book Details</title>
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
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .form-container h1 { text-align: center; }
        .book-details, .borrow-details, .return-details {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th { background-color: #f2f2f2; }
        .book-image {
            width: 300px;
            height: auto;
            margin-top: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <br><br>
    <div class="form-container">
        <h1>Return Book Details</h1>

        <?php if ($book_details && $borrow_details) { ?>
            <!-- Book Image -->
            <img src="uploads/<?php echo htmlspecialchars($book_details['Image']); ?>" alt="Book Image" class="book-image"
                 onerror="this.onerror=null;this.src='uploads/default.jpg';">

            <!-- Book Info -->
            <div class="book-details">
                <h2>Book Information</h2>
                <table>
                    <tr>
                        <th>Book ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Publication Date</th>
                    </tr>
                    <tr>
                        <td><?php echo $book_details['BookID']; ?></td>
                        <td><?php echo $book_details['Title']; ?></td>
                        <td><?php echo $book_details['Author']; ?></td>
                        <td><?php echo $book_details['Publisher']; ?></td>
                        <td><?php echo $book_details['PublicationDate']; ?></td>
                    </tr>
                </table>
            </div>

            <!-- Borrow Info -->
            <div class="borrow-details">
                <h2>Borrow Information</h2>
                <table>
                    <tr>
                        <th>Borrow ID</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                    </tr>
                    <tr>
                        <td><?php echo $borrow_details['BorrowID']; ?></td>
                        <td><?php echo $borrow_details['BorrowDate']; ?></td>
                        <td><?php echo $borrow_details['ReturnDate']; ?></td>
                    </tr>
                </table>
            </div>

            <!-- Return Form -->
            <div class="return-details">
                <h2>Return Book Details</h2>
                <form method="POST" action="process_return.php">
                    <input type="hidden" name="borrow_id" value="<?php echo $borrow_details['BorrowID']; ?>">
                    <input type="hidden" name="book_id" value="<?php echo $book_details['BookID']; ?>">

                    <!-- Book Condition -->
                    <label for="book_condition">Book Condition:</label>
                    <select name="book_condition" id="book_condition" required>
                        <option value="Good">Good</option>
                        <option value="Damaged">Damaged</option>
                        <option value="Lost">Lost</option>
                    </select><br><br>

                    <!-- Fine Calculation Info -->
                    <?php if ($fine > 0): ?>
                        <p style="color: red;">Book is <strong><?php echo $days_late; ?></strong> day(s) late.
                        A fine of <strong>RM <?php echo number_format($fine, 2); ?></strong> is applied.</p>
                    <?php else: ?>
                        <p style="color: green;">Book is returned on time. No fine applied.</p>
                    <?php endif; ?>

                    <!-- Fines Paid -->
                    <label for="fines_paid">Fines Paid (RM):</label>
                    <input type="number" id="fines_paid" name="fines_paid" min="0" step="0.01"
                           value="<?php echo number_format($fine, 2); ?>" required><br><br>

                    <button class="button" type="submit">Return Book</button>
                </form>
            </div>
        <?php } else { ?>
            <p>Unable to fetch details for the provided Book ID or Borrow ID.</p>
        <?php } ?>
    </div>
    <br><br><br><br>
    <?php include('includes/footer.html'); ?>
</body>
</html>
