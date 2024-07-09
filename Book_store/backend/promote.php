<?php
session_start();
include "../backend/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    try {
        $user_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        $stmt = $conn->prepare("UPDATE user SET is_admin = 1 WHERE id = :id");
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION['success'] = "User promoted to admin successfully.";
        header("Location: ../pages/admin.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error promoting user: " . $e->getMessage();
        header("Location: ../pages/admin.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ../pages/admin.php");
    exit();
}
?>
