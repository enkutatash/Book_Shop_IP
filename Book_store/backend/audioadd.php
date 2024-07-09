<?php
session_start();
include "connection.php"; 

if (isset($_POST['addbook'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $genre = $_POST['genre']; 
    $author = $_POST['author'];
    $blog = $_POST['blog']; 
    $is_audio = 1; 

    if (empty($name) || empty($price) || empty($genre) || empty($author) || empty($blog)) {
        echo "All fields are required.";
        exit();
    }

    $coverimage = $_FILES['coverimage']['name'];
    $coverimagetemp = $_FILES['coverimage']['tmp_name'];

    try {
        if (isset($_FILES["audio"]) && $_FILES["audio"]["error"] == 0 && isset($_FILES["audiosample"]) && $_FILES["audiosample"]["error"] == 0) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true); 
            }

            $allowed_audio_types = array("mp3", "wav", "ogg");

            $audio_target_file = $target_dir . basename($_FILES["audio"]["name"]);
            $audio_type = strtolower(pathinfo($audio_target_file, PATHINFO_EXTENSION));
            if (!in_array($audio_type, $allowed_audio_types)) {
                echo "Sorry, only mp3, wav, ogg files are allowed.";
                exit();
            }
            $sample_target_file = $target_dir . basename($_FILES["audiosample"]["name"]);
            $sample_type = strtolower(pathinfo($sample_target_file, PATHINFO_EXTENSION));
            if (!in_array($sample_type, $allowed_audio_types)) {
                echo "Sorry, only mp3, wav, ogg files are allowed for audio sample.";
                exit();
            }

            if (move_uploaded_file($_FILES["audio"]["tmp_name"], $audio_target_file) && move_uploaded_file($_FILES["audiosample"]["tmp_name"], $sample_target_file)) {
                $audio_file_data = file_get_contents($audio_target_file);
                $sample_file_data = file_get_contents($sample_target_file);
                $cover_target_file = $target_dir . basename($_FILES["coverimage"]["name"]);
                if (move_uploaded_file($coverimagetemp, $cover_target_file)) {
                    $cover_image_data = file_get_contents($cover_target_file);
                    
                    $audio_file_name = $_FILES["audio"]["name"];
                    $sample_file_name = $_FILES["audiosample"]["name"];

  
                    $sql = $conn->prepare("INSERT INTO files (file_name, file_type, file_size, file) VALUES (:filename, :filetype, :filesize, :filedata)");
                    $sql->bindParam(':filename', $audio_file_name);
                    $sql->bindParam(':filetype', $_FILES["audio"]["type"]);
                    $sql->bindParam(':filesize', $_FILES["audio"]["size"]);
                    $sql->bindParam(':filedata', $audio_file_data, PDO::PARAM_LOB);
                    $sql->execute();
                    $audio_file_id = $conn->lastInsertId();


                    $sql = $conn->prepare("INSERT INTO files (file_name, file_type, file_size, file) VALUES (:samplefilename, :sampletype, :samplesize, :sampledata)");
                    $sql->bindParam(':samplefilename', $sample_file_name);
                    $sql->bindParam(':sampletype', $_FILES["audiosample"]["type"]);
                    $sql->bindParam(':samplesize', $_FILES["audiosample"]["size"]);
                    $sql->bindParam(':sampledata', $sample_file_data, PDO::PARAM_LOB);
                    $sql->execute();
                    $sample_file_id = $conn->lastInsertId();

                    $current_datetime = date('Y-m-d H:i:s'); 
                    $sql = $conn->prepare("INSERT INTO books (book_name, price, coverImage, genre, author, book_file, is_audio, blog, uploaded_date , audio_sample) VALUES (:bookname, :price, :coverimage, :genre, :author, :bookfile, :isaudio, :blog, :uploaded_date, :audio_sample)");
                    $sql->bindParam(':bookname', $name);
                    $sql->bindParam(':price', $price);
                    $sql->bindParam(':coverimage', $cover_image_data, PDO::PARAM_LOB);
                    $sql->bindParam(':genre', $genre);
                    $sql->bindParam(':author', $author);
                    $sql->bindParam(':bookfile', $audio_file_id, PDO::PARAM_INT);
                    $sql->bindParam(':isaudio', $is_audio, PDO::PARAM_BOOL);
                    $sql->bindParam(':blog', $blog);
                    $sql->bindParam(':uploaded_date', $current_datetime); 
                    $sql->bindParam(':audio_sample', $sample_file_data); 
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
                echo "Sorry, there was an error uploading your audio files.";
                exit();
            }
        } else {
            echo "No audio file or audio sample file was uploaded or there was an error with the file upload.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}

