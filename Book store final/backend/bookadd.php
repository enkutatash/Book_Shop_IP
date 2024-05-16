<?php
session_start();
include "connection.php";

if (isset($_POST['addbook'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $coverimage = $_POST['coverimage'];
    $blog = $_POST['blog'];
    
    try {
        if (isset($_FILES["book"]) && $_FILES["book"]["error"] == 0) {
            $target_dir = "uploads/"; // Change this to the desired directory for uploaded files
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
            }

            $target_file = $target_dir . basename($_FILES["book"]["name"]);
            $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowed_types = array("pdf", "doc", "docx"); // Add allowed file types
            if (!in_array($file_type, $allowed_types)) {
                echo "Sorry, only PDF, DOC, and DOCX files are allowed.";
                exit();
            }

            if (move_uploaded_file($_FILES["book"]["tmp_name"], $target_file)) {
                // File upload success, now store information in the database
                $filename = basename($_FILES["book"]["name"]);
                $filesize = $_FILES["book"]["size"];
                $filetype = $_FILES["book"]["type"];

                // Insert the new book into the database using prepared statements
                $sql = $conn->prepare("INSERT INTO textbook (bookname, price, coverimage, blog, filename, filesize, filetype) VALUES (:bookname, :price, :coverimage, :blog, :filename, :filesize, :filetype)");
                $sql->bindParam(':bookname', $name);
                $sql->bindParam(':price', $price);
                $sql->bindParam(':coverimage', $coverimage);
                $sql->bindParam(':blog', $blog);
                $sql->bindParam(':filename', $filename);
                $sql->bindParam(':filesize', $filesize);
                $sql->bindParam(':filetype', $filetype);

                $result = $sql->execute();

                if ($result) {
                    header("Location: ../pages/admin.html");
                    exit();
                    
                } else {
                    echo 'Error: Could not add the book';
                    header("Location: ../pages/admin.html");
                    exit();
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "No file was uploaded or there was an error with the file upload.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
