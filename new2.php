<?php 
session_start();
include('mysqli_connect.php');

function check_login($dbc, $email = '', $password = '') {
    $errors = array();

    // Validate email
    if (empty($email)) {
        $errors[] = 'You forgot to enter your email address.';
    } else {
        $e = mysqli_real_escape_string($dbc, trim($email));
    }

    // Validate password
    if (empty($password)) {
        $errors[] = 'You forgot to enter your password.';
    } else {
        $p = mysqli_real_escape_string($dbc, trim($password)); 
    }

    if (empty($errors)) {
        $q = "SELECT UserID, FullName, Email, Role FROM Users WHERE Email='$e' AND Password=SHA1('$p')";
        $r = @mysqli_query($dbc, $q);

        if (mysqli_num_rows($r) == 1) {
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
            return array(true, $row); // Login successful
        } else {
            $errors[] = 'Incorrect email or password.';
            echo "<script>
                alert('Incorrect email or password.');
                window.location.href = '!Login.php';
            </script>";
            exit();
        }
    }

    return array(false, $errors);
}

//
function redirect_user($role, $default_page = 'homepage.php') {
    $page = ($role === 'admin') ? 'adminDashboard.php' : $default_page;
    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    $url = rtrim($url, '/\\') . '/' . $page;
    header("Location: $url");
    exit();
}

// Login processing
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('mysqli_connect.php');

    list($check, $data) = check_login($dbc, $_POST['email'], $_POST['password']);

    if ($check) {
        $_SESSION['user_id'] = $data['UserID'];
        $_SESSION['full_name'] = $data['FullName'];
        $_SESSION['email'] = $data['Email'];
        $_SESSION['role'] = $data['Role']; 

        redirect_user($data['Role']);
    } else {
        $errors = $data;
    }

    mysqli_close($dbc);
}
?>
