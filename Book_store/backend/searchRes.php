<?php
session_start();
include "connection.php";
?>
<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatiable" content="IE-edge">
  <meta name="viewport" content="width=device-width initial-scale=1.0">

  <title>Book Bay</title>

  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <link rel="shortcut icon" href="../img/icon.jpg" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/6d978107ba.js" crossorigin="anonymous"></script>
  
  <style>
    .card {
        display: inline-block;
        margin-right: 20px;
        left: 40px;
        margin-top: 20px;
    }
    #textbooks, #audiobooks {
        display: flex;
        flex-wrap: wrap;
    }
    h1 {
        margin-top: 60px;
        color: blueviolet;
        font-weight: 600;
        letter-spacing: 10px;
        text-align: center;
        border-style: groove;
        border-radius: 50px;
    }
    #audiobooks h1, #textbooks h1 {
        color: blueviolet;
        font-weight: 600;
        letter-spacing: 10px;
        text-align: center;
        border-style: groove;
        border-radius: 40px;
        margin-top: 40px;
    }
    audio {
        width: 100%;
        border-style: dotted;
        border-radius: 20px;
    }
    #filter-section {
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 10px;
        margin: 20px;
    }
    #filter-section .form-control {
        margin-bottom: 10px;
    }
    #filter-section label {
        font-weight: bold;
        color: #343a40;
    }
  </style>
 </head>
 
 <body>
   <!-- Header Section -->
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
        <form action="searchRes.php" method="get" class="d-flex align-items-center">
          <div class="input-group">
              <input type="text" name="keyword" class="form-control" placeholder="Search by Author or Name">
              <button type="submit" class="btn btn-success">Search</button>
          </div>
    </form>
      </div>
    </nav>
    <div class="menu" id="mylinks">
      <ul>
        <li><a href="../index.html">Home</a></li>
        <li><a href="#textbooks">E-Book</a></li>
        <li><a href="#audiobooks">Audio Book</a></li>
      </ul>
    </div>
    
    <!-- Filter Section -->
    <section id="filter-section" class="container">
      <form method="GET" action="">
        <div class="row">
          <div class="col-md-4">
            <label for="genre">Genre:</label>
            <select name="genre" id="genre" class="form-control">
              <option value="">All Genres</option>
              <option value="Fiction" <?php if (isset($_GET['genre']) && $_GET['genre'] == 'Fiction') echo 'selected'; ?>>Fiction</option>
              <option value="Non-Fiction" <?php if (isset($_GET['genre']) && $_GET['genre'] == 'Non-Fiction') echo 'selected'; ?>>Non-Fiction</option>
              <option value="Science" <?php if (isset($_GET['genre']) && $_GET['genre'] == 'Science') echo 'selected'; ?>>Science</option>
              <option value="History" <?php if (isset($_GET['genre']) && $_GET['genre'] == 'History') echo 'selected'; ?>>History</option>
              <option value="Romance" <?php if (isset($_GET['genre']) && $_GET['genre'] == 'Science') echo 'selected'; ?>>Romance</option>
              <option value="Fantasy" <?php if (isset($_GET['genre']) && $_GET['genre'] == 'Science') echo 'selected'; ?>>Fantasy</option>
            </select>
          </div>
          <div class="col-md-4">
            <label for="sort">Sort by:</label>
            <select name="sort" id="sort" class="form-control">
              <option value="latest" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'latest') echo 'selected'; ?>>Latest</option>
              <option value="price_asc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') echo 'selected'; ?>>Price: Low to High</option>
              <option value="price_desc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') echo 'selected'; ?>>Price: High to Low</option>
              
            </select>
          </div>
          <div class="col-md-4">
            <label>&nbsp;</label>
            <input type="submit" class="btn btn-primary form-control" value="Apply Filter">
          </div>
        </div>
      </form>
    </section>
    
    <!-- Search and Filter Results -->
    <div class="container">
      <?php
      try {
        $keyWord = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $filterGenre = isset($_GET['genre']) ? $_GET['genre'] : '';
        $filterSort = isset($_GET['sort']) ? $_GET['sort'] : '';

        $query = "SELECT * FROM books WHERE (book_name LIKE :keyword OR author LIKE :keyword) AND is_audio = 0";
        if ($filterGenre) {
          $query .= " AND genre = :genre";
        }
        if ($filterSort) {
          if ($filterSort == 'price_asc') {
            $query .= " ORDER BY price ASC";
          } elseif ($filterSort == 'price_desc') {
            $query .= " ORDER BY price DESC";
          } else {
            $query .= " ORDER BY uploaded_date DESC";
          }
        }

        $stmt = $conn->prepare($query);
        $stmt->bindValue(':keyword', '%' . $keyWord . '%');
        if ($filterGenre) {
          $stmt->bindValue(':genre', $filterGenre);
        }
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
          echo "<h1>E-books</h1>";
          echo "<section id='textbooks'>";
          foreach ($result as $row) {
            echo '<div class="col-md-3 mb-4">';
            echo '<div class="card" style="width: 18rem;">';
            echo '<img src="data:image/jpeg;base64,' . base64_encode($row['coverImage']) . '" class="card-img-top" alt="Book Image" style="height: 200px;">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['book_name']) . '</h5>';
            echo '<p class="card-text">' . htmlspecialchars($row['price']) . ' ETB</p>';
            echo '<a href="#textbooks" class="btn btn-primary">Add to cart</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
          echo "</section>";
        } else {
          echo "<p>No books found.</p>";
        }

        $queryAudio = "SELECT * FROM books WHERE (book_name LIKE :keyword OR author LIKE :keyword) AND is_audio = 1";
        if ($filterGenre) {
          $queryAudio .= " AND genre = :genre";
        }
        if ($filterSort) {
          if ($filterSort == 'price_asc') {
            $queryAudio .= " ORDER BY price ASC";
          } elseif ($filterSort == 'price_desc') {
            $queryAudio .= " ORDER BY price DESC";
          } else {
            $queryAudio .= " ORDER BY uploaded_date DESC";
          }
        }

        $stmtaudio = $conn->prepare($queryAudio);
        $stmtaudio->bindValue(':keyword', '%' . $keyWord . '%');
        if ($filterGenre) {
          $stmtaudio->bindValue(':genre', $filterGenre);
        }
        $stmtaudio->execute();
        $resultaudio = $stmtaudio->fetchAll(PDO::FETCH_ASSOC);

        if (count($resultaudio) > 0) {
          echo "<h1>Audio Books</h1>";
          echo "<section id='audiobooks'>";
          foreach ($resultaudio as $row) {
            echo '<div class="col-md-3 mb-4">';
            echo '<div class="card" style="width: 18rem;">';
            echo '<img src="data:image/jpeg;base64,' . base64_encode($row['coverImage']) . '" class="card-img-top" alt="Book Image" style="height: 200px;">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['book_name']) . '</h5>';

            if (!empty($row['audio_sample'])) {

              echo '<audio controls>';
              echo '<source src="data:audio/mp3;base64, '.base64_encode($row['audio_sample']).' " type="audio/mp3">';
              echo 'Your browser does not support the audio element.';
              echo '</audio>';
            } else {
              echo '<p>Audio sample not available.</p>';
            }

            echo '<p class="card-text">' . htmlspecialchars($row['price']) . ' ETB</p>';
            echo '<a href="#audiobooks" class="btn btn-primary">Add to cart</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
          echo "</section>";
        } else {
          echo "<p>No audio books found.</p>";
        }
      } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
      }
      ?>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../js/script.js"></script>

 </body>
</html>
