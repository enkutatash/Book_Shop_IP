<?php
session_start();
include "connection.php";

if(isset($_SESSION)){
    session_destroy();
}


if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pass = $_POST['password'];
     
    $passwd = password_hash($pass, PASSWORD_DEFAULT);

    try {
        $check = $conn->prepare("SELECT * FROM user WHERE email = :email");
        $check->bindParam(':email', $email);
        $check->execute();

        if ($check->rowCount() > 0) {
            echo "User already exists";
            header("Location: ../pages/signin.html");
            exit();
        } else {
            $sql = $conn->prepare("INSERT INTO user (name, email, phone_number, password) VALUES (:username, :email, :phone, :password)");
            $sql->bindParam(':username', $name);
            $sql->bindParam(':email', $email);
            $sql->bindParam(':phone', $phone);
            $sql->bindParam(':password', $passwd);

            $result = $sql->execute();

            if ($result) {
                $userId = $conn->lastInsertId();
                
                $createCartStmt = $conn->prepare("INSERT INTO cart (user, total_price) VALUES (:user_id, 0)");
                $createCartStmt->bindParam(':user_id', $userId);
                $createCartStmt->execute();
                $cartId = $conn->lastInsertId();

                $_SESSION['user_id'] = $userId;
                $_SESSION['username'] = $name;
                $_SESSION['email'] = $email;
                $_SESSION['cart_id'] = $cartId;

                header("Location: ../index.php");
                exit();
            } else {
                header("Location: ../pages/signup.php");
                exit();
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}



