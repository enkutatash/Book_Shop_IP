
<?php 
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];
    // Regular expressions for validation
    $error_message = array();
    $emailRegex = "/^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/";
    $phoneRegex = "/^[0-9]{10}$/"; // Example: 10-digit phone number
    $passwordRegex = "/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/"; // Minimum 8 characters, at least one uppercase letter, one number, and one special character

    if (empty($name)) {
      $error_message['name'] = "Name is required.";
  }else{
    

  }


    // Validate email
    if (!preg_match($emailRegex, $email)) {
      $error_message['email'] = "Invalid email format.";
    }

    // Validate phone number
    if (!preg_match($phoneRegex, $phone)) {
      $error_message['phone'] = "Invalid phone number format. It should be 10 digits.";

    }

    // Validate password
    if (!preg_match($passwordRegex, $pass)) {
      $error_message['password'] = "Password must be at least 8 characters long, contain at least one uppercase letter, one number, and one special character.";

    }

    // Check if passwords match
    if ($pass !== $cpass) {
      $error_message['cpassword'] = "Passwords do not match.";

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
    <script type="text/javascript" src="../js/script.js"></script>
    <title>Book Bay</title>

    <style>
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
            
            max-width: 300px;
        }
        .form input{
            display: block;
            width: 350px;
            height: 30px;
            margin: 30px;
           
        }
      
        .form .btn{
         cursor: pointer;
         background-color: #0b910b;
         color: #ffffff;
         font-size: 20px;
         border: none;
         border-radius: 10px;
        }
        .form .message{
            color: red;
            font-size: 15px;
            text-align: center;
        }

        .form .btn:hover{
        border: 1px solid #0b910b;
        color: #0b910b;
        background: #ffffff;
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
  
    <!--Header Section-->
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="../img/logo2.jpg" alt="" style="width: 40px; height: 30px;"> 
                <h2>Book Bay</h2>
            </div>

            <div class="navmenu">
                <ul>
                    <li><a href="../">Home</a></li>
                    <li><a href="#signup.html">Sign Up</a></li>
                    <li><a href="../pages/signin.html">Sign In</a></li>
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
            <legend>Sign Up</legend>
            <form action="<?php echo (empty($error_message) && isset($name) && isset($email) && isset($phone) && isset($pass) && isset($cpass)) ? '../backend/signup.php' : ''; ?>" method = 'POST'>
                <h1>Create Account</h1>
                <input type="text" placeholder="Name" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>">

                
                <?php if(isset($error_message['name'])): ?>
                    <div class="message">
                        <p ><?php echo $error_message['name']; ?></p>
                    </div>
                <?php endif; ?>
                <input type="email" placeholder="Email" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">

                <?php if(isset($error_message['email'])): ?>
                    <div class="message">
                        <p ><?php echo $error_message['email']; ?></p>
                    </div>
                <?php endif; ?>
                <input type="number" placeholder="Phone" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>">

                <?php if(isset($error_message['phone'])): ?>
                    <div class="message">
                        <p ><?php echo $error_message['phone']; ?></p>
                    </div>
                <?php endif; ?>
                <input type="password" minlength="8" maxlength="32" placeholder="Password" id="password" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>">
                <?php if(isset($error_message['password'])): ?>
                    <div class="message">
                        <p ><?php echo $error_message['password']; ?></p>
                    </div>
                <?php endif; ?>
                <input type="password"  minlength="8" maxlength="32"  placeholder="Retype Password" id="cpassword" name="cpassword" value="<?php echo isset($_POST['cpassword']) ? $_POST['cpassword'] : ''; ?>">
                <?php if(isset($error_message['cpassword'])): ?>
                    <div class="message">
                        <p ><?php echo $error_message['cpassword']; ?></p>
                    </div>
                <?php endif; ?>
                <input class="btn" type="submit" name="register" value="Sign Up">
            </form>

            <span class="span">Already have an account? <a href="signin.html">Sign In</a> </span>
            
        </fieldset>
        
    </header>

    <!-- <script type="text/javascript" src="../js/signup.js"></script></body> -->
</html>

