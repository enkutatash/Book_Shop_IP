<?php
session_start();
include "connection.php";


if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pass = $_POST['password'];
    


    // Validate email
 
    $passwd = password_hash($pass, PASSWORD_DEFAULT);

    try {
        // Check if the email already exists
        $check = $conn->prepare("SELECT * FROM user WHERE email = :email");
        $check->bindParam(':email', $email);
        $check->execute();

        if ($check->rowCount() > 0) {
            header("Location: ../pages/signin.html");
            exit();
        } else {
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
              
              header("Location: ../pages/signup.html");
              exit();
                
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}



