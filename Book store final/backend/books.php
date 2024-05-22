<?php
session_start();
include "connection.php";
?>
<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatiable"  content="IE-edge">
  <meta name="viewport" content="width=device-width initial-scale=1.0">

  <title>Book Buy</title>

  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <link rel="shortcut icon" href="../img/icon.jpg" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/6d978107ba.js" crossorigin="anonymous"></script>
  
  <style>
    .card{
        display: inline-block;
        margin-right: 20px;
        left: 40px;
        margin-top: 20px;
      }
      #textbooks , #audiobooks{
        display: flex;
      }
     h1{
        margin-top: 60px;
        color: blueviolet;
        font-weight: 600;
        letter-spacing: 10px;
        text-align: center;
        border-style: groove;
        border-radius: 50px;
      }
      
      #audiobooks h1,#textbooks h1{
        color: blueviolet;
        font-weight: 600;
        letter-spacing: 10px;
        text-align: center;
        border-style: groove;
        border-radius: 40px;
        margin-top: 40px;
      }
      
      audio{
        width: 100%; 
        border-style: dotted; 
        border-radius: 20px;
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
                  <li><a href="../card.html">Cart</a></li>

                  <li><a href="../index.php">Home</a></li>
                  
                  
                  <li class="dropdown">
                    <a href="./books.php">Books</a>
            <ul class="dropdown-content">
              <li><a href="#textbooks">E-Book</a></li>
              <li><a href="#audiobooks">Audio Book</a></li>
              
            </ul>
          </li>
          
        </ul>
                <!-- <form action="searchRes.php" method = "get">
                <div class="search-box">        
                  <input type="search" name = "keyword" class="search" placeholder="Search by Author,name..">
                  
                  <i class='bx bx-search' type = "submit">Search</i>
                </div>
              </div>
              <div class="menuicon">
                <button class="icon" type="submit" value="Search">
                  <i class="fa fa-bars"></i>
              </button>
            </div>
            </form> -->
            <form action="searchRes.php" method="get">
              <div class="search-box"> 
                <input type="text" name="keyword" placeholder="Search by Author or Name">
                <input type="submit" value="Search">
              </div>
              
            </form>

        </nav>
        <div class="menu" id="mylinks">
                    <ul>
                      <li><a href="../index.html">Home</a></li>
                      <li><a href="#textbooks">E-Book</a></li>
                      <li><a href="#audiobooks">Audio Book</a></li>
                    </ul>
                  </div>
                  
                  <div class="main-header">
                    <div class="header">
                <h3>Smart Book Store</h3>
                <h2>Find out your favorite here......</h2>
                <p>
                  Navigate through a rich collection of genres, from classics to indie gems, 
                  celebrating stories from various cultures and backgrounds. Our user-friendly design
                  and curated recommendations ensure a unique and enjoyable browsing experience. </p>
                </div>
            <video controls muted autoplay loop src="../video/video2.mp4" alt="this browser doesn't support video!">
            </video>
            </div>

          </header>

    <!--Text books Section-->
    
        
        <?php
        try {
          
          $stmt = $conn->prepare("SELECT id, bookname, price, coverimage FROM textbook");
          $stmt->execute();
          
          // Fetch all results
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          if (count($result) > 0) {
            
            echo "<h1>E-book</h1>";
            echo"<section id='textbooks'>";
            
            foreach ($result as $row) {
              echo '<div class="col-md-3 mb-4">';
              echo '<div class="card" style="width: 18rem;">';
              echo '<img src="uploads/' . htmlspecialchars($row['coverimage']) .'" class="card-img-top" alt="Book Image" style="height: 200px;">';
              echo '<div class="card-body">';
              echo '<h5 class="card-title">' . htmlspecialchars($row['bookname']) . '</h5>';
              echo '<p class="card-text">' . htmlspecialchars($row['price']) . ' ETB</p>';
              echo '<a href="#textbooks" class="btn btn-primary">Add to cart</a>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
          }
         echo" </section>";
          
          } else {
            echo "<p>No books found.</p>";
          }
          $stmtaudio = $conn->prepare("SELECT id, bookname, price, coverimage,samplename FROM audiobook");
          $stmtaudio->execute();
          
          // Fetch all results
          $resultaudio = $stmtaudio->fetchAll(PDO::FETCH_ASSOC);


          //Audio Books Section
          if (count($resultaudio) > 0) {
           
            echo "<h1>Audio Books</h1>";
            echo " <section id='audiobooks'>";
            foreach ($resultaudio as $row) {
              echo '<div class="col-md-3 mb-4">';
              echo '<div class="card" style="width: 18rem;">';
              echo '<img src="uploads/' . htmlspecialchars($row['coverimage']) . '" class="card-img-top" alt="Book Image" style="height: 200px;">';
              echo '<div class="card-body">';
              echo '<h5 class="card-title">' . htmlspecialchars($row['bookname']) . '</h5>';
              echo ' <audio controls src="uploads/' . htmlspecialchars($row['samplename']) . '"></audio>';

              echo '<p class="card-text">' . htmlspecialchars($row['price']) . ' ETB</p>';
              echo '<a href="#textbooks" class="btn btn-primary">Add to cart</a>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
        
          }
         echo" </section>";
          
          } else {
            echo "<p>No audio-books found.</p>";
          }
        } catch (PDOException $e) {
          echo "<p>Error: " . $e->getMessage() . "</p>";
        }
        ?>
    
   
      
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
      <script type="text/javascript" src="../js/script.js"></script>

    </body>
    </html>
    