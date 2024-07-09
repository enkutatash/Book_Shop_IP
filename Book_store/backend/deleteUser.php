<?php
session_start();
include "../backend/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    try {

        $user_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        $delete_user = $conn->prepare("DELETE FROM user WHERE id = :id");
        $delete_user->bindParam(':id', $user_id, PDO::PARAM_INT);
        $delete_user->execute();

        if ($delete_user->rowCount() > 0) {
            $_SESSION['success'] = "User deleted successfully.";
        } else {
            $_SESSION['error'] = "User not found or already deleted.";
        }

        header("Location: ../pages/admin.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error deleting user: " . $e->getMessage();
        header("Location: ../pages/admin.php");
        exit();
    }
} else {

    $_SESSION['error'] = "Invalid request.";
    header("Location: ../pages/admin.php");
    exit();
}
