<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id'])) {
  
    header("Location: ../pages/signin.php");
    exit();
}
$user_id = $_SESSION['user_id'];

try {
    $stmt = $conn->prepare("SELECT id FROM cart WHERE user = ?");
    $stmt->execute([$user_id]);
    $cart = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cart) {
        echo "Your cart is empty.";
        exit();
    }

    $cart_id = $cart['id'];

    $stmt = $conn->prepare("SELECT books.id, books.book_name, books.price, books.coverImage 
                            FROM books 
                            INNER JOIN cart_books ON books.id = cart_books.book_id 
                            WHERE cart_books.cart_id = ?");
    $stmt->execute([$cart_id]);
    $cart_books = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $total_price = 0;
    foreach ($cart_books as $book) {
        $total_price += (float)$book['price'];
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Bay - Cart</title>
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
    #cart-books {
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
    .total-price, .purchase-btn {
        margin: 20px;
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
        <li><a href="../index.php">Home</a></li>
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
          and curated recommendations ensure a unique and enjoyable browsing experience.
        </p>
      </div>
      <video controls muted autoplay loop src="../video/video2.mp4" alt="this browser doesn't support video!"></video>
    </div>
  </header>

  <!-- Cart Books Section -->
  <h1>Your Cart</h1>
  <section id="cart-books">
    <?php
    if (count($cart_books) > 0) {
      foreach ($cart_books as $book) {
        echo '<div class="col-md-3 mb-4">';
        echo '<div class="card" style="width: 18rem;">';
        echo '<img src="data:image/jpeg;base64,' . base64_encode($book['coverImage']) . '" class="card-img-top" alt="Book Image" style="height: 200px;">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . htmlspecialchars($book['book_name']) . '</h5>';
        echo '<p class="card-text">' . htmlspecialchars($book['price']) . ' ETB</p>';
        echo '<form method="post" action="remove_from_cart.php">';
        echo '<input type="hidden" name="book_id" value="' . $book['id'] . '">';
        echo '<button type="submit" class="btn btn-danger">Remove from Cart</button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
      }
    } else {
      echo "<p>No books in your cart.</p>";
    }
    ?>
  </section>

  <div class="total-price">
    <h2>Total Price: <?php echo htmlspecialchars($total_price); ?> ETB</h2>
  </div>
 
<div class="purchase-btn">
  <a href="../pages/payment.php" class="btn btn-success">Purchase</a>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6cRzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script type="text/javascript" src="../js/script.js"></script>
</body>
</html>





