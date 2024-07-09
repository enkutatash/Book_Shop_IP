<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatiable" content="IE-edge" />
    <meta name="viewport" content="width=device-width initial-scale=1.0" />

    <title>Cart</title>

    <link rel="stylesheet" href="../css/style.css" />
    <link
      rel="stylesheet"
      href="https://unpkg.com/boxicons@latest/css/boxicons.min.css"
    />
    <script
      src="https://kit.fontawesome.com/6d978107ba.js"
      crossorigin="anonymous"
    ></script>
    <link rel="shortcut icon" href="img/icon.jpg" type="image/x-icon" />
    <script type="text/javascript" src="./js/script.js"></script>
    <style>
      #cardContainer {
        padding: 20px;
        display: flex;
        flex-wrap: wrap;
      }
      .col{
        padding-right: 10vh;
      }
    </style>
  </head>

  <body>
    <!--Header Section-->

    <header>
      <nav class="navbar">
        <div class="logo">
          <div></div>
          <img src="../img/logo2.jpg" alt="" style="width: 40px; height: 30px" />
          <h2>Book Bay</h2>
        </div>

        <div class="navmenu">
          <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="../backend/books.php">Books</a></li>
          </ul>

        
        </div>

        <div class="menuicon">
          <button onclick="myFunction()" class="icon">
            <i class="fa fa-bars"></i>
          </button>
        </div>
      </nav>
      <div class="menu" id="mylinks">
        <ul>
          <li><a href="../index.php">Home</a></li>
          <li><a href="../backend/books.php">Books</a></li>
        </ul>
      </div>
      <div class="contact-row">
        <div class="col">
          <img src="../img/image14.jpg" alt="book pic" />
        </div>
        <div class="col">
          <h2>Enter your payment details</h2>

          <form action=" ../backend/download.php">
            <input type="text" name="name" id="name" placeholder="Name" />
            <br /><br />
            <label for="ccn">Credit Card Number:</label>
            <input
              id="ccn"
              type="tel"
              inputmode="numeric"
              pattern="[0-9\s]{13,19}"
              autocomplete="cc-number"
              maxlength="19"
              placeholder="xxxx xxxx xxxx xxxx"
              required
            />
            <br /><br />
            <input type="text" name="City" id="city" placeholder="City" />
            <br /><br />
            <div class="country-input">
              <select name="country_code" class="form-control">
                <option value="">Select Country</option>
                <option value="USA">USA</option>
                <option value="ETH">Ethiopia</option>
                <option value="KOR">Korea</option>
                <option value="JPN">Japan</option>
                <option value="IND">India</option>
               
              </select>
            </div>
            <a href = "../backend/download.php"><input type="submit" value="Send" /></a>
          </form>
        </div>
      </div>
    </header>
    <hr />

    <script type="text/javascript" src="./js/cart.js"></script>
    <footer class="footer">
      <p>&copy; 2024 AASTU/SWEG/SEC/GROUP ONEAll rights Reserved!</p>
    </footer>
    <br />
    <br />
  </body>
</html>