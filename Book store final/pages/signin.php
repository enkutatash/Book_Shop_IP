<?php
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

if((empty($error_message)  && isset($email) && isset($pass) )){

    try {
        // Prepare and execute the SQL statement
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Check if the user exists
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $password_hash = $row['userpassword'];
            
            // Verify the password
            if (password_verify($pass, $password_hash)) {
               
                $_SESSION['id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['firstname'] = $row['firstname'];
                header("Location: ../index.html");
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
    <!-- Include your CSS stylesheets and other dependencies here -->
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
                    <li><a href="../pages/signup.php">Sign Up</a></li>
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
            <form action="" method = 'POST'>

                <!-- Your form fields (e.g., username, password) go here -->
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
            <span>Don't have an account? <a href="signup.html">Sign Up</a>  </span>
        </fieldset>
    </header>
    <!-- Include your other HTML elements here -->
    <!-- <script type="text/javascript" src="../js/script.js"></script>
    <script type="text/javascript" src="../js/signin.js"></script></body> -->

    
</body>
</html>
