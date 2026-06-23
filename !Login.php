<?php
include('includes/header.html');
include('mysqli_connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Interface</title>
</head>

<style>
        /*LOGIN*/
      .main-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 60px);
        }

        .login-box {
            width: 350px;
            padding: 20px;
            background-color: #e6e6e6;
            border-radius: 10px;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-box input {
            width: 100%;
            padding: 10px;
            margin: 10px -10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-box a {
            color: #555;
            text-decoration: none;
            font-size: 12px;
        }

        .login-box .btn {
            width: 100%;
            padding: 10px;
            background-color: #0056b3;
            color: rgb(255, 255, 255);
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .login-box .btn:hover {
          background-color: #0056b3;
      }

 
</style>

<body>
  <div class="main-container">
    <div class="login-box">
        <h2>Login</h2>
        <form id="loginForm" method="POST" action="new2.php">
        <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
               
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 12px; margin-top: 5px;">
                <!-- <a href="resetpassword.php">Forgot password?</a> -->
                <a href="!Registerform.php">No account? Register</a>
            </div>
             <button id="loginButton" class="btn" type="submit">LOGIN</button>
        </form>
        <div class="error-message">
            <?php
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo '<p>' . $error . '</p>';
                }
            }
            ?>
        </div>
    </div>
</div>

</body>

<?php
include('includes/footer.html');
?>
