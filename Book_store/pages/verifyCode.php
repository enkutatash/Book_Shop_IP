<?php
session_start();

if (isset($_POST['verify_code'])) {
    $entered_code = $_POST['reset_code'];
    
    if ($entered_code == $_SESSION['reset_code']) {
        echo "The reset code is correct. You can now reset your password.";
        header("Location: reset_password_form.php");
        exit();
    } else {
        $error_message = "Invalid reset code. Please try again.";
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
    <title>Verify Reset Code</title>
    
    <style>
        .message {
            color: red;
            font-size: 10px;
            text-align: left;
        }
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
            padding: 20px 20px;
        }
        .form input {
            display: block;
            width: 350px;
            height: 30px;
            margin: 40px;
        }
        .form .btn {
            cursor: pointer;
            background-color: #0b910b;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            width: 350px;
            height: 30px;
            margin: auto auto;
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
        .err {
            color: red;
            text-align: center;
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
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="./signup.php">Sign Up</a></li>
                    <li><a href="#signin.php">Sign In</a></li>
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
                <li><a href="../index.html">Home</a></li>
                <li><a href="#signup.html">Sign Up</a></li>
                <li><a href="../pages/signin.html">Sign In</a></li>
            </ul>
        </div>

        <fieldset class="form">
            <form action="" method="POST">
                <input type="text" placeholder="Enter Reset Code" name="reset_code" required>
                <?php if(isset($error_message)): ?>
                    <div class="message">
                        <p><?php echo $error_message; ?></p>
                    </div>
                <?php endif; ?>
                <input class="btn" type="submit" name="verify_code" value="Verify Code">
            </form>
        </fieldset>
    </header>
</body>
</html>
