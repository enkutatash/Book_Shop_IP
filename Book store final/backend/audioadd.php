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
        if (isset($_FILES["audio"]) && $_FILES["audio"]["error"] == 0 && isset($_FILES["audiosample"]) && $_FILES["audiosample"]["error"] == 0) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
            }

            $target_file = $target_dir . basename($_FILES["audio"]["name"]);
            $sample_target = $target_dir . basename($_FILES["audiosample"]["name"]);
            $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $sample_type = strtolower(pathinfo($sample_target, PATHINFO_EXTENSION));
            $allowed_types = array("mp3", "wav", "ogg");

            if (!in_array($file_type, $allowed_types)) {
                echo "Sorry, only mp3, wav, ogg files are allowed.";
                exit();
            }

            if (move_uploaded_file($_FILES["audio"]["tmp_name"], $target_file) && move_uploaded_file($_FILES["audiosample"]["tmp_name"], $sample_target)) {
                // File upload success, now store information in the database
                $filename = basename($_FILES["audio"]["name"]);
                $filesize = $_FILES["audio"]["size"];
                $filetype = $_FILES["audio"]["type"];

                $samplefilename = basename($_FILES["audiosample"]["name"]);
                $samplefilesize = $_FILES["audiosample"]["size"];
                $samplefiletype = $_FILES["audiosample"]["type"];

                // Handle cover image upload
                $cover_target_file = $target_dir . basename($_FILES["coverimage"]["name"]);
                if (move_uploaded_file($coverimagetemp, $cover_target_file)) {
                    $coverimagename = basename($_FILES["coverimage"]["name"]);
                    $coversize = $_FILES["coverimage"]["size"];
                    $covertype = $_FILES["coverimage"]["type"];

                    // Insert the new audio into the database using prepared statements
                    $sql = $conn->prepare("INSERT INTO audiobook (bookname, price, coverimage, coversize, covertype, blog, filename, filesize, filetype, samplename, samplesize, sampletype) VALUES (:bookname, :price, :coverimage, :coversize, :covertype, :blog, :filename, :filesize, :filetype, :samplename, :samplesize, :sampletype)");
                    $sql->bindParam(':bookname', $name);
                    $sql->bindParam(':price', $price);
                    $sql->bindParam(':coverimage', $coverimagename);
                    $sql->bindParam(':coversize', $coversize);
                    $sql->bindParam(':covertype', $covertype);
                    $sql->bindParam(':blog', $blog);
                    $sql->bindParam(':filename', $filename);
                    $sql->bindParam(':filesize', $filesize);
                    $sql->bindParam(':filetype', $filetype);
                    $sql->bindParam(':samplename', $samplefilename);
                    $sql->bindParam(':samplesize', $samplefilesize);
                    $sql->bindParam(':sampletype', $samplefiletype);

                    $result = $sql->execute();

                    if ($result) {
                        header("Location: ../pages/admin.html");
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
                echo "Sorry, there was an error uploading your audio files.";
                exit();
            }
        } else {
            echo "No file was uploaded or there was an error with the file upload.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}
?>
