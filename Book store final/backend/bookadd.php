<?php
session_start();
include "connection.php";

if (isset($_POST['addbook'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $blog = $_POST['blog'];

    $coverimage = $_FILES['coverimage']['name'];
    $coverimagetemp = $_FILES['coverimage']['tmp_name'];
    
    try {
        // Validate and handle book file upload
        if (isset($_FILES["book"]) && $_FILES["book"]["error"] == 0) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
            }

            $target_file = $target_dir . basename($_FILES["book"]["name"]);
            $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowed_types = array("pdf", "doc", "docx"); // Allowed file types

            if (!in_array($file_type, $allowed_types)) {
                echo "Sorry, only PDF, DOC, and DOCX files are allowed.";
                exit();
            }

            if (move_uploaded_file($_FILES["book"]["tmp_name"], $target_file)) {
                // File upload success, now store information in the database
                $filename = basename($_FILES["book"]["name"]);
                $filesize = $_FILES["book"]["size"];
                $filetype = $_FILES["book"]["type"];

                // Validate and handle cover image upload
                $cover_target_file = $target_dir . basename($_FILES["coverimage"]["name"]);
                if (move_uploaded_file($coverimagetemp, $cover_target_file)) {
                    $coverimagename = basename($_FILES["coverimage"]["name"]);
                    $coversize = $_FILES["coverimage"]["size"];
                    $covertype = $_FILES["coverimage"]["type"];

                    // Insert the new book into the database using prepared statements
                    $sql = $conn->prepare("INSERT INTO textbook (bookname, price, coverimage, coversize, covertype, blog, filename, filesize, filetype) VALUES (:bookname, :price, :coverimage, :coversize, :covertype, :blog, :filename, :filesize, :filetype)");
                    $sql->bindParam(':bookname', $name);
                    $sql->bindParam(':price', $price);
                    $sql->bindParam(':coverimage', $coverimagename);
                    $sql->bindParam(':coversize', $coversize);
                    $sql->bindParam(':covertype', $covertype);
                    $sql->bindParam(':blog', $blog);
                    $sql->bindParam(':filename', $filename);
                    $sql->bindParam(':filesize', $filesize);
                    $sql->bindParam(':filetype', $filetype);
                    $result = $sql->execute();

                    if ($result) {
                        header("Location: ../pages/admin.php");
                        exit();
                    } else {
                        echo 'Error: Could not add the book';
                        exit();
                    }
                } else {
                    echo "Sorry, there was an error uploading your cover image.";
                    exit();
                }
            } else {
                echo "Sorry, there was an error uploading your book file.";
                exit();
            }
        } else {
            echo "No book file was uploaded or there was an error with the file upload.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}
?>
