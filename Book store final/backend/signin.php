<?php
session_start();

include "connection.php";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    try {
        // Prepare and execute the SQL statement
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Check if the user exists
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $password_hash = $row['userpassword'];
            
            // Verify the password
            if (password_verify($pass, $password_hash)) {
               
                $_SESSION['id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['firstname'] = $row['firstname'];
                header("Location: ../index.html");
                exit();
            } else {
                
            }
        } else {
            echo "<div class='message'>
                    <p>Wrong Email or Password</p>
                    </div><br>";
                header("Location: ../pages/signin.html");
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
