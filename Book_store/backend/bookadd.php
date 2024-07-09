<?php
session_start();
include "connection.php";

if (isset($_POST['addbook'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $genre = $_POST['genre'];
    $author = $_POST['author'];
    $blog = $_POST['blog']; 
    $is_audio = 0;

    $coverimage = $_FILES['coverimage']['name'];
    $coverimagetemp = $_FILES['coverimage']['tmp_name'];

    try {
        if (isset($_FILES["book"]) && $_FILES["book"]["error"] == 0) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $target_file = $target_dir . basename($_FILES["book"]["name"]);
            $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowed_types = array("pdf", "doc", "docx");

            if (!in_array($file_type, $allowed_types)) {
                echo "Sorry, only PDF, DOC, and DOCX files are allowed.";
                exit();
            }

            if (move_uploaded_file($_FILES["book"]["tmp_name"], $target_file)) {
                $filename = basename($_FILES["book"]["name"]);
                $filesize = $_FILES["book"]["size"];
                $filedata = file_get_contents($target_file);
                $filetype = $_FILES["book"]["type"];

                $sql = $conn->prepare("INSERT INTO files (file_name, file_type, file_size, file) VALUES (:filename, :filetype, :filesize, :filedata)");
                $sql->bindParam(':filename', $filename);
                $sql->bindParam(':filetype', $filetype);
                $sql->bindParam(':filesize', $filesize);
                $sql->bindParam(':filedata', $filedata, PDO::PARAM_LOB);
                $sql->execute();
                $file_id = $conn->lastInsertId();

    
                $cover_target_file = $target_dir . basename($_FILES["coverimage"]["name"]);
                if (move_uploaded_file($coverimagetemp, $cover_target_file)) {
                    $coverimagedata = file_get_contents($cover_target_file);

                    $current_datetime = date('Y-m-d H:i:s'); 
                    $sql = $conn->prepare("INSERT INTO books (book_name, price, coverImage, genre, author, book_file, is_audio, blog, uploaded_date) VALUES (:bookname, :price, :coverimage, :genre, :author, :bookfile, :isaudio, :blog, :uploaded_date )");
                    $sql->bindParam(':bookname', $name);
                    $sql->bindParam(':price', $price);
                    $sql->bindParam(':coverimage', $coverimagedata, PDO::PARAM_LOB);
                    $sql->bindParam(':genre', $genre);
                    $sql->bindParam(':author', $author);
                    $sql->bindParam(':bookfile', $file_id, PDO::PARAM_INT);
                    $sql->bindParam(':isaudio', $is_audio, PDO::PARAM_BOOL);
                    $sql->bindParam(':blog', $blog);
                    $sql->bindParam(':uploaded_date', $current_datetime); 
                    $result_books = $sql->execute();

                    if ($result_books) {
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

