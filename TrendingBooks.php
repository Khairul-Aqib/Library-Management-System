<?php
session_start();
include('includes/mysqli_connect.php');
include('includes/header.html');

$query = "SELECT * FROM books WHERE IsActive = 1 ORDER BY AmountBorrowed DESC";
$result = mysqli_query($dbc, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trending Books</title>
    <link rel="stylesheet" href="includes/style.css">
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

        h1 {
            text-align: center;
            margin-bottom: 20px;
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

        img {
            width: 60px;
            height: 90px;
            object-fit: cover;
            border-radius: 4px;
        }

        .header-logo {
            width: 180px; /* Set width for the logo */
            height: auto;
            object-fit: contain; /* Ensures the logo maintains its aspect ratio */
        }
    </style>
</head>
<body>
<div class="main-container">
    <div class="form-container">
        <h1>Trending Books</h1>
        <table>
            <tr>
                <th>Cover</th>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Times Borrowed</th>
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
                    <td><?= (int)$row['AmountBorrowed'] ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<?php include('includes/footer.html'); ?>
</body>
</html>
