<?php

if(isset($_SESSION)){
    session_destroy();
}

session_start();

include "../backend/connection.php";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $pass = $_POST['password'];
    $error_message = array();

    $emailRegex = "/^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/";
    $passwordRegex = "/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/"; // Minimum 8 characters, at least one uppercase letter, one number, and one special character

    if (!preg_match($emailRegex, $email)) {
        $error_message['email'] = "Invalid email format.";
    }

    if (empty($pass)) {
        $error_message['password'] =  "Password is required.";
    }

    if (empty($error_message) && isset($email) && isset($pass)) {
        try {
            $stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $password_hash = $row['password'];

                if (password_verify($pass, $password_hash)) {
                    unset($_COOKIE);
                    
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['name'] = $row['name'];

                    $cart_stmt = $conn->prepare("SELECT * FROM cart WHERE user = :user_id");
                    $cart_stmt->bindParam(':user_id', $_SESSION['user_id']);
                    $cart_stmt->execute();

                    if ($cart_stmt->rowCount() > 0) {
                        $cart_row = $cart_stmt->fetch(PDO::FETCH_ASSOC);
                        $_SESSION['cart_id'] = $cart_row['id'];
                    } else {
                        $create_cart = $conn->prepare("INSERT INTO cart (user) VALUES (:user_id)");
                        $create_cart->bindParam(':user_id', $_SESSION['id']);
                        $create_cart->execute();

                        $_SESSION['cart_id'] = $conn->lastInsertId();
                        setcookie('expiry', time()+(7200), time() + (7200), "/");
                    }

                    if ($row['is_admin'] == 0) {
                        header("Location: ../index.php");
                    } else {
                        header("Location: ./admin.php");
                    }

                    exit();
                } else {
                    $error_message['password'] = "Wrong Password";
                }
            } else {
                $error_message['email'] = "Email Don't Exist";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
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
    <!-- <script src="https://kit.fontawesome.com/6d978107ba.js" crossorigin="anonymous"></script> -->
    
    <title>Book Bay</title>
    
    <style>
        .message{
            color: red;
            font-size: 10px;
            text-align: left;
        }
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        fieldset{
            width: 400px;
            margin: 30px auto;
            text-align: center;
            border-radius: 20px;
        }
        .form {
            padding: 20px 20px;
        }
        .form input{
            display: block;
            width: 350px;
            height: 30px;
            margin: 40px;
            
        }
        #login{
            font-size: 20px;
        }
        .form .btn{
            cursor: pointer;
            background-color: #0b910b;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            width: 350px;
            height: 30px;
            margin: auto auto;
        }
        
        .form .btn:hover{
            border: 1px solid #0b910b;
            color: #0b910b;
            background: #ffffff;
        }
        .form .message{
            color: red;
            font-size: 15px;
            text-align: center;
        }
        @media(max-width:900px)
        {
            fieldset{
                width :400px;
            }
            input{
                max-width: 250px;
                
            }
    
        }
        .err{
            color :red;
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
            


        </nav>

        <fieldset class="form">
            <form action="" method = 'POST'>

                <input type="email" placeholder="Email" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                <?php if(isset($error_message['email'])): ?>
                    <div class="message">
                        <p ><?php echo $error_message['email']; ?></p>
                    </div>
                <?php endif; ?>
                <input type="password" id="password" placeholder="Password" name="password">
                <?php if(isset($error_message['password'])): ?>
                    <div class="message">
                        <p ><?php echo $error_message['password']; ?></p>
                    </div>
                <?php endif; ?>
                <input class="btn" type="submit" name="login" value="Log In">
            </form>
            <span>Don't have an account? <a href="./signup.php">Sign Up</a>  </span>
            <span>Forgot password? <a href="forgot_password.php">Reset here</a></span>

        </fieldset>

        <?php
            if (isset($_GET['message'])){
                echo "<span> <h2 class = \"err\">". htmlspecialchars($_GET['message']) ."</h2></span>";
            }
        ?>
    </header>
    <!-- <script type="text/javascript" src="../js/script.js"></script>
    <script type="text/javascript" src="../js/signin.js"></script></body> -->

    
</body>
</html>
