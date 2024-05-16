<?php
session_start();
include "connection.php";

if (isset($_POST['register'])) {
  echo "send";
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];

    $passwd = password_hash($pass, PASSWORD_DEFAULT);

    try {
        // Check if the email already exists
        $check = $conn->prepare("SELECT * FROM user WHERE email = :email");
        $check->bindParam(':email', $email);
        $check->execute();

        if ($check->rowCount() > 0) {
            echo "<div class='message'>
                  <p>This email is used, Try another One Please!</p>
                  </div><br>";

            echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
        } else {
            if ($pass === $cpass) {
                // Insert the new user into the database
                $sql = $conn->prepare("INSERT INTO user (firstname, email, phonenumber, userpassword) VALUES (:username, :email, :phone, :password)");
                $sql->bindParam(':username', $name);
                $sql->bindParam(':email', $email);
                $sql->bindParam(':phone', $phone);
                $sql->bindParam(':password', $passwd);

                $result = $sql->execute();

                if ($result) {
                  header("Location: ../index.html");
                  exit();
                } else {
                    echo "<div class='message'>
                          <p>Registration failed, please try again.</p>
                          </div><br>";

                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
                }
            } else {
                echo "<div class='message'>
                      <p>Password does not match.</p>
                      </div><br>";

                echo "<a href='signup.php'><button class='btn'>Go Back</button></a>";
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  echo "post";
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  echo "get";
}
?>
