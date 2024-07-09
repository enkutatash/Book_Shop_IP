<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/signin.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_id'])) {
    $user_id = $_SESSION['user_id'];
    $book_id = $_POST['book_id'];

    try {
        $stmt = $conn->prepare("SELECT id FROM cart WHERE user = ?");
        $stmt->execute([$user_id]);
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart) {
            $cart_id = $cart['id'];
            $stmt = $conn->prepare("DELETE FROM cart_books WHERE cart_id = ? AND book_id = ?");
            $stmt->execute([$cart_id, $book_id]);

            header("Location: cartPage.php");
            exit();
        } else {
            echo "Your cart is empty.";
            exit();
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    header("Location: cartPage.php");
    exit();
}

