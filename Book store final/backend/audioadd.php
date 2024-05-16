<?php
session_start();
include "connection.php";

if (isset($_POST['addbook'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $coverimage = $_POST['coverimage'];
    $blog = $_POST['blog'];
    
    try {
        if (isset($_FILES["audio"]) && $_FILES["audio"]["error"] == 0 && isset($_FILES["audiosample"]) && $_FILES["audiosample"]["error"] == 0 ) {
            $target_dir = "uploads/"; // Change this to the desired directory for uploaded files
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

            if (move_uploaded_file($_FILES["audio"]["tmp_name"], $target_file) && move_uploaded_file($_FILES["audiosample"]["tmp_name"], $sample_target) ) {
                // File upload success, now store information in the database
                $filename = basename($_FILES["audio"]["name"]);
                $filesize = $_FILES["audio"]["size"];
                $filetype = $_FILES["audio"]["type"];

                $samplefilename = basename($_FILES["audiosample"]["name"]);
                $samplefilesize = $_FILES["audiosample"]["size"];
                $samplefiletype = $_FILES["audiosample"]["type"];

                // Insert the new audio into the database using prepared statements
                $sql = $conn->prepare("INSERT INTO audiobook (bookname, price, coverimage, blog, filename, filesize, filetype,samplename,samplesize,sampletype) VALUES (:bookname, :price, :coverimage, :blog, :filename, :filesize, :filetype,:samplename,:samplesize,:sampletype)");
                $sql->bindParam(':bookname', $name);
                $sql->bindParam(':price', $price);
                $sql->bindParam(':coverimage', $coverimage);
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
