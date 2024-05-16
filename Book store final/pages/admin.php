<?php
session_start();
// include "connection.php"; // Ensure this file establishes a valid PDO connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
  <link rel="stylesheet" href="../css/adminstyle.css" />
  <link rel="shortcut icon" href="../img/icon.jpg" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <title>Book Store</title>
  <style>
    .btn{
         cursor: pointer;
         background-color: #0b910b;
         color: #ffffff;
         font-size: 20px;
         border: none;
         border-radius: 10px;
        }

  </style>
</head>
<body>
  <div class="side-bar">
    <div class="top">
      <div class="logo">
        <h2><i class="bx bx-user"></i> Admin</h2>
      </div>
      <i class="bx bx-menu" id="btn" style="color: #47143a;"></i>
    </div>
    <ul>
      <li>
        <a href="#">
          <i class="bx bxs-dashboard"></i>
          <span class="nav-item">Dashboard</span>
        </a>
        <span class="tooltip">Dashboard</span>
      </li>
      <li>
        <a href=".\addbook.html">
          <i class="bx bxs-book-add"></i>
          <span class="nav-item">Add Books</span>
        </a>
        <span class="tooltip">Add Books</span>
      </li>
      <li>
        <a href="../pages/editbook.html">
          <i class="bx bxs-edit-alt"></i>
          <span class="nav-item">Edit Books</span>
        </a>
        <span class="tooltip">Edit Books</span>
      </li>
      <li>
        <a href="#">
          <i class="bx bxl-blogger"></i>
          <span class="nav-item">Delete</span>
        </a>
        <span class="tooltip">Delete</span>
      </li>
      <li>
        <a href="#">
          <i class="bx bxs-cog"></i>
          <span class="nav-item">Setting</span>
        </a>
        <span class="tooltip">Setting</span>
      </li>
      <li>
        <a href="#">
          <i class="bx bxs-log-out"></i>
          <span class="nav-item">Log out</span>
        </a>
        <span class="tooltip">Log out</span>
      </li>
    </ul>
  </div>
  <div class="main-content">
    <div class="head">
      <nav class="navbar" style="background: lightskyblue;">
        <div class="logo">
          <img src="../img/logo2.jpg" alt="Logo" style="width: 40px; height: 30px;" />
          <h2>Book Store</h2>
        </div>
        <div class="navmenu" style="padding-left: 65%;">
          <ul>
            <li><a href="../index.html">Home</a></li>
            <li><a href="../pages/signin.html">Sign Out</a></li>
          </ul>
        </div>
        <div class="menuicon">
          <button onclick="myFunction()" class="icon">
            <i class="bx bx-menu" style="color: #47143a;"></i>
          </button>
        </div>
      </nav>
      <div class="menu" id="mylinks">
        <ul>
          <li><a href="../index.html">Home</a></li>
          <li><a href="../pages/signin.html">Sign Out</a></li>
        </ul>
      </div>
    </div>
    <!--Table Section-->
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Book Name</th>
          <th scope="col">Price</th>
          <th scope="col">delete</th>
          <th scope="col">update</th>
          

        </tr>
      </thead>
      <tbody>
        <?php
        
        try {
          $servername = "localhost";
          $username = "root";
          $password = "";
          $dbname = "bookstore";
          
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          // set the PDO error mode to exception
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT id, bookname, price FROM textbook");
          $stmt->execute();
          
          // Fetch all results
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

          if (count($result) > 0) {
          
            foreach ($result as $row) {
              echo "<tr>";
echo "<th scope='row'>" . htmlspecialchars($row["id"]) . "</th>";
echo "<td>" . htmlspecialchars($row['bookname']) . "</td>";
echo "<td>" . htmlspecialchars($row['price']) . "</td>";
echo "<td style='
    cursor: pointer;
    background-color: #0b910b;
    color: #ffffff;
    font-size: 20px;
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
'>
    <button style='
        background-color: inherit;
        border: none;
        color: inherit;
        cursor: pointer;
        font-size: inherit;
        width:30px;
    '>Update</button>
</td>";
echo "<td style='
    cursor: pointer;
    background-color: red;
    color: #ffffff;
    font-size: 20px;
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
'>
    <button style='
        background-color: inherit;
        border: none;
        color: inherit;
        cursor: pointer;
        font-size: inherit;
        width:30px;
    '>Remove</button>
</td>";
echo "</tr>";

            }
          } else {
            echo "<tr><td colspan='3'>No books found.</td></tr>";
          }
        } catch (PDOException $e) {
          echo "<tr><td colspan='3'>Error: " . $e->getMessage() . "</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
  <script>
    let btn = document.querySelector('#btn');
    let sidebar = document.querySelector('.side-bar');
    btn.onclick = function() {
      sidebar.classList.toggle('active');
    };
    function myFunction() {
      var x = document.getElementById("mylinks");
      if (x.style.display === "block") {
        x.style.display = "none";
      } else {
        x.style.display = "block";
      }
    }
  </script>
</body>
</html>
