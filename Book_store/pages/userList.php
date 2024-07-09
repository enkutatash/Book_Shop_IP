<?php
session_start();
include "../backend/connection.php";
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
    .btn {
      cursor: pointer;
      background-color: #0b910b;
      color: #ffffff;
      font-size: 20px;
      border: none;
      border-radius: 10px;
      padding: 10px 20px;
    }

    .btn-remove {
      background-color: red;
      margin-left: 10px; /* Space between buttons */
    }

    .btn-promote {
      background-color: #ffc107;
      color: #000000;
      margin-left: 10px; /* Space between buttons */
    }

    .table {
      width: 80%;
      margin: auto;
      margin-top: 50px;
      text-align: center;
    }

    .table th,
    .table td {
      padding: 10px;
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
        <a href="./addbook.php">
          <i class="bx bxs-book-add"></i>
          <span class="nav-item">Add Books</span>
        </a>
        <span class="tooltip">Add Books</span>
      </li>

      <li>
        <a href="./addaudio.php">
          <i class="bx bxs-book-add"></i>
          <span class="nav-item">Add Audio Books</span>
        </a>
        <span class="tooltip">Add Audio Books</span>
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
            <li><a href="../index.php">Home</a></li>
            <li><a href="../pages/signin.php">Sign Out</a></li>
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
          <li><a href="../index.php">Home</a></li>
          <li><a href="../pages/signin.php">Sign Out</a></li>
        </ul>
      </div>
    </div>
    <!-- Table Section -->
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2 class="text-center mt-5 mb-3">List of Users</h2>
          <table class="table table-bordered table-striped">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone Number</th>
                <th scope="col">Is Admin</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              try {
                $stmt = $conn->prepare("SELECT * FROM user");
                $stmt->execute();
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($users) > 0) {
                  foreach ($users as $user) {
                    echo "<tr>";
                    echo "<th scope='row'>" . htmlspecialchars($user["id"]) . "</th>";
                    echo "<td>" . htmlspecialchars($user["name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($user["email"]) . "</td>";
                    echo "<td>" . htmlspecialchars($user["phone_number"]) . "</td>";
                    echo "<td>" . ($user["is_admin"] ? 'Yes' : 'No') . "</td>";
                    echo "<td>";
                           
                    if (!$user["is_admin"]) {
                      echo "<a href='../backend/promote.php?id=" . htmlspecialchars($user["id"]) . "' class='btn btn-promote'>Promote to Admin</a>";
                    }

                    echo "<a href='../backend/deleteUser.php?id=" . htmlspecialchars($user["id"]) . "' class='btn btn-danger'>Delete</a>
                          </td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='7'>No users found.</td></tr>";
                }
              } catch (PDOException $e) {
                echo "<tr><td colspan='7'>Error: " . $e->getMessage() . "</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
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
