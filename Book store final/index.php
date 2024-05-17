<?php
session_start();
include "../backend/connection.php";


?>

<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatiable"  content="IE-edge">
  <meta name="viewport" content="width=device-width initial-scale=1.0">

  <title>Book Buy</title>

  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <script src="https://kit.fontawesome.com/6d978107ba.js" crossorigin="anonymous"></script>
  <link rel="shortcut icon" href="img/icon.jpg" type="image/x-icon">
  <script type="text/javascript" src="../js/script.js"></script>
  
 </head>

 <body>
    <!--Header Section-->

    <header>
        <nav class="navbar">
            <div class="logo">
                <div></div>
                <img src="img/logo2.jpg" alt="" style="width: 40px; height: 30px;"> 
                <h2>Book Bay</h2>
            </div>

            <div class="navmenu" >
                <ul >
                    <li><a href="#home">Home</a></li>
                    <li><a href="#blog">Blog</a></li>
                    <li><a href="backend/books.php">Books</a></li>
                    <li><a href="#about">About</a></li>                    
                    <li><a href="#contactus">Contact </a> </li>
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
                    <li><a href="backend/books.php">Books</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contactus">Contact </a> </li>
                    </ul>
                    
                </div> 
        <div class="main-header">
            <div class="header">
                <h3>Smart Book Store</h3>
                <h2>Embark on your journey through the pages of a book....</h2>
                <p>
                    Welcome to Book Bay, an online bookstore that's as diverse as your taste in literature.
                     Discover a literary haven that embraces diversity  – where every book tells a different story, just like its readers. </p>
            </div>
            <video controls muted autoplay loop src="video/video1.mp4" alt="this browser doesn't support video!" class="videoevent">
           </video>
           </div>
        
    </header>
<hr>

    <!--Blog Section-->

     <section id="blog">
        <h2 class="blog-header">Blogs.....</h2>
        <div class="set-row">
        <?php
        try {

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "bookstore";


            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
          
          $stmt = $conn->prepare("SELECT id, bookname, coverimage ,blog FROM textbook LIMIT 5");
          $stmt->execute();
          
        

          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          if (count($result) > 0) {
            foreach ($result as $row) {
                echo '<div class="col">';
                echo '<img src="backend/uploads/' . htmlspecialchars($row['coverimage']) .'" alt="Book Image" class="card-img-top">';

                echo '<p>'.$row['blog'].'</p>';
                echo '</div>';

            }
          }}catch(PDOException $e){
            echo "<p>Error: " . $e->getMessage() . "</p>";
          }
            ?>
        
        

        

        
        </div>
    </section>
<hr>
    
    <!--About Us Section-->
<section id="about">
         <div class="set-rowa">
          <img src="img/image1.jpg" alt="">
                    
            <div class="about-content">
              <h2>About Our Bookstore</h2>
              <p>The local bookstore is a welcoming space for both authors and readers, 
                 a spot for like-minded people to gather and exchange ideas.
                 Bookstores often host events such as book clubs, author readings, 
                and signings, bringing together community members who love reading.</p>
                    
          <a href="#" class="btn2">Read More</a>
     </div>
    </div>
</section>

    <!--Contact Section-->

    <section id="contactus">
        <div class="contact-row">
            <div class="col">
                <h2>Contact Us</h2>

                <form action="">
                    <input type="text" name="name" id="name" placeholder="Name">
                    <br>
                    <input type="email" name="email" id="email" placeholder="Email">
                    <br>
                    <div class="phone-input">
                      <select id="phoneCode" name="phoneCode">
                        <option value="+1">+1 (US)</option>
                        <option value="+44">+44 (UK)</option>
                        <option value="+33">+33 (FRA)</option>
                        <option value="+81">+81 (JPN)</option>
                        <option value="+49">+49 (GER)</option>
                        <option value="+91">+91 (IND)</option>
                        <option value="+251">+251(ETH)</option>
                        <!-- Add more options for different country codes -->
                      </select>
                      <input type="tel" maxlength="10" name="phoneNumber" id="phoneNumber" placeholder="Phone Number">
                    </div>
                    <br>
                    <textarea cols="20" rows="5" name="message" id="message" placeholder="Message"></textarea>
                    <br>
                    <input type="submit" value="Send">
                  </form>
                  
            </div>

            <div class="col">
                <img src="img/image14.jpg" alt="book pic">
            </div>
        </div>
    </section>

    <!--Footer Section-->
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