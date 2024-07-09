<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    echo "You need to be logged in to add books to your cart.";
    exit();
}

$user_id = $_SESSION['user_id'];
    
if (!isset($_GET['book_id'])) {
    echo "Book ID is required.";
    exit();
}

$book_id = intval($_GET['book_id']);

try {

    $sql = "SELECT id FROM cart WHERE user = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    
    $cart_id = null;

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $cart_id = $row['id'];
    } else {
        
        $sql = "INSERT INTO cart (user, total_price) VALUES (:user_id, 0)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $cart_id = $conn->lastInsertId();
        } else {
            echo "Error creating cart.";
            exit();
        }
    }

    $sql = "INSERT INTO cart_books (book_id, cart_id) VALUES (:book_id, :cart_id)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        
        header("Location: books.php");
        echo "Book added to cart successfully.";
    } else {
        echo "Error adding book to cart.";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


