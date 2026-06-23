<?php
include('includes/header.html');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = trim($_POST['full_name']);
    $icnumber = trim($_POST['icnumber']);
    $pnumber = trim($_POST['pnumber']);
    $email = trim($_POST['email']);
    $Address = trim($_POST['Address']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    $errors = [];

    if (empty($full_name) || empty($icnumber) || empty($pnumber) || empty($email) || empty($Address) || empty($password) || empty($confirm_password)) {
        $errors[] = 'All fields are required.';
    }

    if ($password !== $confirm_password) {
        $errors[] = 'Passwords do not match.';
        
    }

    if (empty($errors)) {
        require ('mysqli_connect.php');

        $query = "INSERT INTO users (FullName, ICNumber, pnumber, Email, Address, password, DateRegistered, Role) 
          VALUES ('$full_name', '$icnumber', '$pnumber', '$email', '$Address', SHA1('$password'), NOW(), 'member')";
        $r = @mysqli_query ($dbc, $query    );
       
        if ($r) {
            echo "Query executed successfully.<br>";
            echo "Inserted ID: " . mysqli_insert_id($dbc) . "<br>";
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    document.getElementById("successModal").style.display = "flex";
                });
            </script>';
        } else {
            echo "Error executing query: " . mysqli_error($dbc) . "<br>";
            $errors[] = 'Error registering user: ' . mysqli_error($dbc);
        }

        mysqli_close($dbc);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
      .main-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
            height: calc(100vh - 60px);
        }

        .form-container {
            width: 100%;
            max-width: 600px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container h1 {
            font-size: 20px;
            margin-bottom: 20px;
            text-align: center;
            color: #000;
        }
      
        .form-row {
            display: flex;
            gap: 10px;
        }

        input,
        textarea {
            width: 96%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 3px;
            background-color: #e6e6e6;
        }

        textarea {
            resize: none;
        }

        #num1 {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            font-weight: bold;
            background-color: #007bff;
            border: none;
            border-radius: 3px;
            color: #ffffff;
            cursor: pointer;
        }

        #num1:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        #registerForm {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .modal-content h1 {
            margin: 0;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .modal-content p {
            margin: 10px 0;
        }

        .modal-content button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .modal-content button:hover {
            background-color: #0056b3;
        }

        /* Style for both the "No account? Register" and "Already have an account? Login" links */
        .login-box a {
            color: #555;
            text-decoration: none; /* No underline */
            font-size: 12px;
        }

        .login-box a:hover {
            text-decoration: none; /* Ensure no underline on hover */
            color: #555; /* Optional: keep the color the same on hover */
        }
    </style>
</head>
<body>
<div class="main-container">
    <div class="form-container">
        <h1>Register Form</h1>
        <form id="registerForm" method="POST" action="">
            <div class="form-group">
                <input type="text" name="full_name" placeholder="Full Name" required>
            </div>
            <div class="form-row">
                <input type="text" name="icnumber" placeholder="IC Number" required>
                <input type="text" name="pnumber" placeholder="Phone Number" required>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <textarea name="Address" placeholder="Address" rows="4" required></textarea>
            </div>
            <div class="form-row">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <input type="password" name="confirm_password" id="confirmPassword" placeholder="Confirm Password" required>
            </div>
            <div id="error-message" class="error-message">
                <?php
                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        echo '<p>' . $error . '</p>';
                    }
                }
                ?>
            </div>
            <div class="login-box">
                <div style="display: flex; justify-content: space-between; font-size: 12px; margin-top: 5px;">
                    <a href="!Login.php">Already have an account? Login</a>
                </div>
            </div>
            <div class="form-group">
                <button id="num1" type="submit">REGISTER</button>
            </div>
        </form>
    </div>
</div>

<!-- Success Modal -->
<div class="modal" id="successModal">
    <div class="modal-content">
        <h1>Registration Successful!</h1>
        <p><br>Your account has been created successfully.</p>
        <br><button id="closeModal" onclick="window.location.href='!Login.php'">Proceed to Login</button>
    </div>
</div>

<script>
    // Wait for the DOM to be fully loaded before adding event listeners
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById('registerForm');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirmPassword');
        const errorMessage = document.getElementById('error-message');

        form.addEventListener('submit', function(event) {
            if (password.value !== confirmPassword.value) {
                event.preventDefault();
                errorMessage.textContent = 'Passwords do not match.';
            }
        });
    });
</script>
</body>
</html>