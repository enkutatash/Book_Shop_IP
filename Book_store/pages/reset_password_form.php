<?php
session_start();

include "../backend/connection.php";

if (!isset($_SESSION['email'])) {
    header("Location: forgot_password.php");
    exit();
}

$email = $_SESSION['email'];
$error_message = [];

if (isset($_POST['update_password'])) {
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    $passwordRegex = "/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/"; 

    if (!preg_match($passwordRegex, $new_pass)) {
        $error_message['new_password'] = "Password must be at least 8 characters long, contain at least one uppercase letter, one number, and one special character.";
    }

    if ($new_pass !== $confirm_pass) {
        $error_message['confirm_password'] = "Passwords do not match.";
    }

    if (empty($error_message)) {

        $hashed_password = password_hash($new_pass, PASSWORD_BCRYPT);

        try {
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("UPDATE user SET password = :password WHERE email = :email");
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':email', $email);

            if ($stmt->execute()) {
                unset($_SESSION['email']);
                echo "Password has been updated successfully.";
                header("Location: signin.php");
                exit();
            } else {
                $error_message['database'] = "Failed to update password. Please try again.";
            }
        } catch (PDOException $e) {
            $error_message['database'] = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="shortcut icon" href="../img/icon.jpg" type="image/x-icon">
    <title>Update Password</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        fieldset {
            width: 400px;
            margin: 30px auto;
            text-align: center;
            border-radius: 20px;
        }
        .form {
            max-width: 300px;
        }
        .form input {
            display: block;
            width: 350px;
            height: 30px;
            margin: 30px;
        }
        .form .btn {
            cursor: pointer;
            background-color: #0b910b;
            color: #ffffff;
            font-size: 20px;
            border: none;
            border-radius: 10px;
        }
        .form .btn:hover {
            border: 1px solid #0b910b;
            color: #0b910b;
            background: #ffffff;
        }
        .form .message {
            color: red;
            font-size: 15px;
            text-align: center;
        }
        @media(max-width: 900px) {
            fieldset {
                width: 400px;
            }
            input {
                max-width: 250px;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="../img/logo2.jpg" alt="" style="width: 40px; height: 30px;">
                <h2>Book Bay</h2>
            </div>
            <div class="navmenu">
                <ul>
                    <li><a href="../">Home</a></li>
                    <li><a href="./signup.php">Sign Up</a></li>
                    <li><a href="../pages/signin.php">Sign In</a></li>
                </ul>
            </div>
            <div class="menuicon">
                <button class="icon" onclick="myFunction()">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
        </nav>
        <div class="menu" id="mylinks">
            <ul>
                <li><a href="../">Home</a></li>
                <li><a href="#signup.html">Sign Up</a></li>
                <li><a href="../pages/signin.html">Sign In</a></li>
            </ul>
        </div>
        <fieldset class="form">
            <legend>Update Password</legend>
            <form action="" method="POST">
                <h1>Set New Password</h1>
                <input type="password" minlength="8" maxlength="32" placeholder="New Password" name="new_password" required>
                <?php if(isset($error_message['new_password'])): ?>
                    <div class="message">
                        <p><?php echo $error_message['new_password']; ?></p>
                    </div>
                <?php endif; ?>
                <input type="password" minlength="8" maxlength="32" placeholder="Confirm Password" name="confirm_password" required>
                <?php if(isset($error_message['confirm_password'])): ?>
                    <div class="message">
                        <p><?php echo $error_message['confirm_password']; ?></p>
                    </div>
                <?php endif; ?>
                <input class="btn" type="submit" name="update_password" value="Update Password">
            </form>
        </fieldset>
    </header>
</body>
</html>
