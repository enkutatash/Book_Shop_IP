<?php
// Include Composer's autoload file
require '../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

if(isset($_POST['email'])){
        $email = $_POST['email'];

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $random_number = mt_rand(100000, 999999);
        
        $_SESSION['reset_code'] = $random_number;
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'ermiayele74@gmail.com'; 
            $mail->Password   = 'purp uvlm ypji lcng'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Recipients
            $mail->setFrom('no-reply@bookstore.org', 'Book Store');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "Your password reset code is $random_number.";

            $mail->send();
            echo 'A password reset code has been sent to your email.';
            header("Location: verifyCode.php");
            exit(); // Ensure the script stops after header redirect
        } catch (Exception $e) {
            echo "Failed to send reset code. Please try again. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Invalid email address.";
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
            <form action="forgot_password.php" method="POST">
                <input type="text" placeholder="Enter Email" name="email" required>
                <?php if(isset($error_message)): ?>
                    <div class="message">
                        <p><?php echo $error_message; ?></p>
                    </div>
                <?php endif; ?>
                <input class="btn" type="submit" name="emailSub" value="Submit">
            </form>
        </fieldset>
    </header>
</body>
</html>
