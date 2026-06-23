<?php
session_start();
include('includes/header.html');

// Permission check for admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['email']) || strtolower(trim($_SESSION['role'])) !== 'admin') {
    echo '<script>alert("You do not have permission to access this page."); window.location.href = "homepage.php";</script>';
    exit();
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('mysqli_connect.php');

    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $isbn = trim($_POST['isbn']);
    $publisher = trim($_POST['publisher']);
    $publication_date = $_POST['publication_date'];
    $description = trim($_POST['description']);
    $quantity = (int) $_POST['quantity'];
    $genre = trim($_POST['genre']);
    $shelf_location = trim($_POST['shelf_location']);

    $image_path = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $filename = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $filename;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $filename;
        } else {
            $errors[] = "Failed to upload image.";
        }
    }

    if (empty($title) || empty($author) || empty($isbn) || empty($publisher)) {
        $errors[] = 'Please fill in all required fields.';
    }

    if (empty($errors)) {
        $stmt = $dbc->prepare("INSERT INTO Books (Title, Author, ISBN, Publisher, PublicationDate, Description, Quantity, Genre, ShelfLocation, Image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssisss", $title, $author, $isbn, $publisher, $publication_date, $description, $quantity, $genre, $shelf_location, $image_path);

        if ($stmt->execute()) {
            $success = true;
        } else {
            $errors[] = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }

    $dbc->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add Book</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f2f5;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .main-container {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 20px;
    }

    .form-container {
      width: 100%;
      max-width: 700px;
      padding: 30px;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      color: #333;
      margin-bottom: 25px;
    }

    input, textarea, select {
      width: 100%;
      padding: 10px;
      font-size: 14px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      background: #f9f9f9;
    }

    textarea {
      resize: none;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #007bff;
      border: none;
      color: white;
      font-size: 16px;
      font-weight: bold;
      border-radius: 4px;
      cursor: pointer;
    }

    button:hover {
      background-color: #0056b3;
    }

    .error-message {
      color: red;
      font-size: 13px;
      margin-bottom: 10px;
    }

    .modal {
      display: <?= $success ? 'flex' : 'none' ?>;
      position: fixed;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      justify-content: center;
      align-items: center;
      background-color: rgba(0,0,0,0.5);
      z-index: 1000;
    }

    .modal-content {
      background: white;
      padding: 30px;
      text-align: center;
      border-radius: 8px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .modal-content h1 {
      margin: 0;
      font-size: 24px;
    }

    .modal-content p {
      margin: 10px 0;
    }

    .modal-content button {
      margin-top: 10px;
      padding: 10px 20px;
    }

    footer {
      background: #222;
      color: white;
      text-align: center;
      padding: 15px;
      font-size: 14px;
    }
  </style>
</head>
<body>
<div class="main-container">
  <div class="form-container">
    <h1>📚 Add Book</h1>
    <form method="POST" enctype="multipart/form-data">
      <input type="text" name="title" placeholder="Title" required />
      <input type="text" name="author" placeholder="Author" required />
      <input type="text" name="isbn" placeholder="ISBN" required />
      <input type="text" name="publisher" placeholder="Publisher" required />
      <input type="date" name="publication_date" placeholder="Publication Date" />
      <textarea name="description" rows="4" placeholder="Description"></textarea>
      <input type="number" name="quantity" placeholder="Quantity" min="1" />
      <input type="text" name="genre" placeholder="Genre" />
      <input type="text" name="shelf_location" placeholder="Shelf Location" />
      <input type="file" name="image" accept="image/*" />
      
      <?php if (!empty($errors)): ?>
        <div class="error-message">
          <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <button type="submit">Add Book</button>
    </form>

    <!-- Back to Dashboard Button -->
    <a href="adminDashboard.php">
      <button class="back-button">Back to Dashboard</button>
    </a>
  </div>
</div>

<!-- Success Modal -->
<div class="modal" id="successModal">
  <div class="modal-content">
    <h1>Book Added Successfully!</h1>
    <p>Your book has been added to the database.</p>
    <button onclick="window.location.href='add_book.php'">Add Another</button>
  </div>
</div>

<?php include('includes/footer.html'); ?>
</body>
</html>