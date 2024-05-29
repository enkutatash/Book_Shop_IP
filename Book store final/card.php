<?php
session_start();
include 'db.php';

if (!isset($_SESSION['session_id'])) {
    echo "Your cart is empty.";
    exit();
}

$session_id = $_SESSION['session_id'];

$stmt = $conn->prepare("SELECT books.id, books.title, books.author, books.price, cart.quantity FROM cart JOIN books ON cart.book_id = books.id WHERE cart.session_id = :session_id");
$stmt->execute(['session_id' => $session_id]);
$cart_items = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatiable"  content="IE-edge">
  <meta name="viewport" content="width=device-width initial-scale=1.0">

  <title>Cart</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <script src="https://kit.fontawesome.com/6d978107ba.js" crossorigin="anonymous"></script>
  <link rel="shortcut icon" href="img/icon.jpg" type="image/x-icon">
  <script type="text/javascript" src="./js/script.js"></script>
<style>
    #cardContainer{
        padding: 20px;
        display: flex;
        flex-wrap: wrap;


    }
</style>

 </head>

 <body>

    <!--Header Section-->

    <header>
        <nav class="navbar">
            <div class="logo">
                <div></div>
                <img src="img/logo2.jpg" alt="" style="width: 40px; height: 30px;"> 
                <h2>Book Buy</h2>
            </div>

            <div class="navmenu" >
                <ul >
                    <li><a href="#home">Home</a></li>
                    <li><a href="#blog">Blog</a></li>
                    <li><a href="./backend/books.php">Books</a></li>
                    <li><a href="./pages/payment.html">Payment</a></li>
                    <li><a href="#about">About</a></li>
                </ul>
                
                <div class="search-box">
                    <input type="search" class="search" placeholder="search here....">
                    <i class='bx bx-search'></i>
                </div>
            </div>
                
        <div class="menuicon">
            <button onclick="myFunction()" class="icon">
<i class="fa fa-bars"></i>
            </button>
            
        </div>
         
  
        </nav>
 <div class="menu" id="mylinks">
                    <ul>
                        <li><a href="#home">Home</a></li>
                    <li><a href="#blog">Blog</a></li>
                    <li><a href="./backend/books.php">Books</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="./backend/signup.php">Sign Up</a></li>
                    <li><a href="#contactus">Contact </a> </li>
                    </ul>
                    
                </div> 
        
                <div id="cardContainer">

                <ul>
                <?php foreach ($cart_items as $item): ?>
                 <li>
                <h2><?php echo htmlspecialchars($item['title']); ?></h2>
                <p><?php echo htmlspecialchars($item['author']); ?></p>
                <p>$<?php echo htmlspecialchars($item['price']); ?></p>
                <p>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
                <p>Total: $<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></p>
            </li>
        <?php endforeach; ?>
                </div>
    </header>
<hr>

<script type="text/javascript" src="./js/cart.js"></script>
<footer class="footer">
        <p>&copy; 2023 All rights Reserved!</p>
    </footer>
<br> <br> 
<script>
 function myFunction() {
    var x = document.getElementById("mylinks");
    if (x.style.display === "block") {
        x.style.display = "none";
    } else {
        x.style.display = "block";
    }
}</script>
 </body>

 </html> 