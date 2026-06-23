<?php
session_start();
include('includes/header.html');
require('mysqli_connect.php');

// Permission check for admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['email']) || strpos($_SESSION['role'], 'admin') !== 0) {
    echo '<script>alert("You do not have permission to access this page."); window.location.href = "homepage.php";</script>';
    exit();
}

// Query tarik data buku yang sudah dipulangkan
$query = "SELECT 
            books.Image,
            books.Title,
            books.ISBN,
            users.FullName AS BorrowerName,
            borrowedbooks.IsLate,
            borrowedbooks.Fine,
            bookhistory.DateReturned
          FROM borrowedbooks
          JOIN books ON borrowedbooks.BookID = books.BookID
          JOIN users ON borrowedbooks.UserID = users.UserID
          JOIN bookhistory ON bookhistory.BookID = books.BookID
          WHERE borrowedbooks.Status = 'Returned'
          ORDER BY bookhistory.DateReturned DESC"; // Automatically sorts by DateReturned in ascending order

$result = mysqli_query($dbc, $query);

// Check error SQL
if (!$result) {
    die('Query Error: ' . mysqli_error($dbc));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Book Borrowing History</title>
  <link rel="stylesheet" href="includes/style.css" type="text/css" />
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    .report-container {
      padding: 20px;
      margin: 40px auto;
      width: 90%;
      max-width: 1000px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .header-container {
      width: 100%;
      display: flex;
      justify-content: space-between; /* Pushes elements to both sides */
      align-items: center;
      margin-bottom: 30px;
    }


    h1 {
      flex-grow: 1; /* Ensures the h1 takes up the available space */
      text-align: center;
      margin: 0;
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

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 16px;
    }

    th, td {
      padding: 12px 15px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #007bff;
      color: white;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    img.cover {
      width: 60px;
      height: auto;
      border-radius: 4px;
    }

    .no-data {
      text-align: center;
      font-size: 18px;
      color: #666;
      padding: 20px;
    }

    footer {
      text-align: center;
      padding: 20px;
      margin-top: 40px;
      background-color: #222;
      color: #fff;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="report-container">
    <!-- Header container with Back button on the right -->
    <div class="header-container">
      <h1>📘 Book Borrowing Report</h1>
      <a href="adminDashboard.php" class="back-button">Back to Dashboard</a>
    </div>

    <?php if (mysqli_num_rows($result) > 0): ?>
      <table>
        <tr>
          <th>Cover</th>
          <th>Title</th>
          <th>Borrowed By</th>
          <th>ISBN</th>
          <th>Date Returned</th>
          <th>Fine Status</th>
          <th>Fine (RM)</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><img class="cover" src="uploads/<?= htmlspecialchars($row['Image'] ?: 'default.jpg') ?>" alt="Cover"></td>
            <td><?= htmlspecialchars($row['Title']) ?></td>
            <td><?= htmlspecialchars($row['BorrowerName']) ?></td>
            <td><?= htmlspecialchars($row['ISBN']) ?></td>
            <td><?= htmlspecialchars($row['DateReturned']) ?></td>
            <td><?= $row['IsLate'] ? 'Late' : 'On Time' ?></td>
            <td><?= number_format($row['Fine'], 2) ?></td>
          </tr>
        <?php endwhile; ?>
      </table>
    <?php else: ?>
      <div class="no-data">No returned book records found.</div>
    <?php endif; ?>
  </div>

  <?php include('includes/footer.html'); ?>
</body>
</html>

<?php mysqli_close($dbc); ?>