<?php
include "../backend/connection.php";

$id = $_GET['id'];

// Fetch the current book details
$stmt = $conn->prepare("SELECT * FROM books WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $blog = $_POST['blog'];
    $genre = $_POST['genre'];
    $author = $_POST['author'];
    $is_audio = isset($_POST['is_audio']) ? 1 : 0;
    
    $coverimage = $_FILES['coverimage']['name'] ? file_get_contents($_FILES['coverimage']['tmp_name']) : null;
    $bookfile = $_FILES['bookfile']['name'] ? file_get_contents($_FILES['bookfile']['tmp_name']) : null;
    $audiofile = $_FILES['audiofile']['name'] ? file_get_contents($_FILES['audiofile']['tmp_name']) : null;

    $error_message = array();

    if (empty($name)) {
        $error_message['name'] = "Name is required.";
    }

    if (empty($price)) {
        $error_message['price'] = "Price is required.";
    }

    if (empty($genre)) {
        $error_message['genre'] = "Genre is required.";
    }

    if (empty($author)) {
        $error_message['author'] = "Author is required.";
    }

    if (empty($error_message)) {
        try {
            $conn->beginTransaction();

            if ($is_audio && $audiofile) {
                $stmt = $conn->prepare("INSERT INTO files (file_type, file_size, file) VALUES (:file_type, :file_size, :file)");
                $stmt->bindParam(':file_type', $_FILES['audiofile']['type']);
                $stmt->bindParam(':file_size', $_FILES['audiofile']['size']);
                $stmt->bindParam(':file', $audiofile, PDO::PARAM_LOB);
                $stmt->execute();

                $file_id = $conn->lastInsertId();
            } elseif (!$is_audio && $bookfile) {

                $stmt = $conn->prepare("INSERT INTO files (file_type, file_size, file) VALUES (:file_type, :file_size, :file)");
                $stmt->bindParam(':file_type', $_FILES['bookfile']['type']);
                $stmt->bindParam(':file_size', $_FILES['bookfile']['size']);
                $stmt->bindParam(':file', $bookfile, PDO::PARAM_LOB);
                $stmt->execute();

                $file_id = $conn->lastInsertId();
            } else {
                $file_id = $row['book_file']; 
            }

  
            $prev_price = null;
            if($row['price'] != $price){
                $prev_price = $row['price'];
            }

            $sql = $conn->prepare("UPDATE books SET book_name = :bookname, price = :price, coverImage = :coverimage, genre = :genre, author = :author, book_file = :bookfile, blog = :blog, is_audio = :is_audio, prev_price = :prev_price WHERE id = :id");
            $sql->bindParam(':id', $id);
            $sql->bindParam(':bookname', $name);
            $sql->bindParam(':price', $price);
            $sql->bindParam(':coverimage', $coverimage, PDO::PARAM_LOB);
            $sql->bindParam(':genre', $genre);
            $sql->bindParam(':author', $author);
            $sql->bindParam(':bookfile', $file_id, PDO::PARAM_INT);
            $sql->bindParam(':blog', $blog);
            $sql->bindParam(':is_audio', $is_audio);
            $sql->bindParam(':prev_price', $prev_price);
            $result = $sql->execute();

            if ($result) {

                $conn->commit();
                header("Location: ../pages/admin.php?$prev_price>");
                exit();
            } else {
                echo "Error updating record.";
            }
        } catch (PDOException $e) {
            $conn->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="shortcut icon" href="../img/icon.jpg" type="image/x-icon">
    <title>Update</title>
    <style>
        * {
           margin: 0;
           padding: 0;
           box-sizing: border-box;
           font-family: 'Poppins', sans-serif;
        }
        header {
            background: #e7f0f3ac;
            width: 100%;
            height: 100%;
        }
        fieldset {
            width: 400px;
            margin: 30px auto;
            text-align: center;
            border-radius: 20px;
        }
        .form {
            max-width: 300px;
        }
        .form input, .form textarea {
            display: block;
            width: 350px;
            height: 30px;
            margin: 30px;
        }
        .form textarea {
            height: auto;
        }
        .form label {
            display: block;
            text-align: left;
            padding-left: 20px;
        }
        .form .btn {
            cursor: pointer;
            background-color: #0b910b;
            color: #ffffff;
            font-size: 20px;
            border: none;
            border-radius: 10px;
            width: auto;
            padding: 10px 20px;
        }
        .form .btn:hover {
            border: 1px solid #0b910b;
            color: #0b910b;
            background: #ffffff;
        }
        .form .message {
            color: red;
            font-size: 15px;
            text-align: center;
        }
        .form .audio-book-fields {
            display: none;
        }
        .form .regular-book-fields {
            display: none;
        }
        @media (max-width: 900px) {
            fieldset {
                width: 400px;
            }
            input, textarea {
                max-width: 250px;
            }
        }
    </style>
    <script>
        function toggleFields() {
            var isAudio = document.getElementById('is_audio').checked;
            var audioFields = document.querySelector('.audio-book-fields');
            var regularFields = document.querySelector('.regular-book-fields');
            
            if (isAudio) {
                audioFields.style.display = 'block';
                regularFields.style.display = 'none';
            } else {
                audioFields.style.display = 'none';
                regularFields.style.display = 'block';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleFields();
        });
    </script>
</head>
<body>
    <!--Header Section-->
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="../img/logo2.jpg" alt="" style="width: 40px; height: 30px;">
                <h2>Book Store</h2>
            </div>
            <div class="navmenu">
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a style="text-decoration: none; color: white;" href="./addaudio.php">Add Audio Books</a></li>
                </ul>
            </div>
        </nav>
        <fieldset class="form">
            <legend>Update Book</legend>
            <form action="" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <label>Book Name</label>
                <input type="text" value="<?php echo htmlspecialchars($row['book_name']); ?>" name="name" required>
                <?php if (isset($error_message['name'])): ?>
                    <div class="message">
                        <p><?php echo $error_message['name']; ?></p>
                    </div>
                <?php endif; ?>

                <label>Price</label>
                <input type="number" value="<?php echo htmlspecialchars($row['price']); ?>" name="price" required>
                <?php if (isset($error_message['price'])): ?>
                    <div class="message">
                        <p><?php echo $error_message['price']; ?></p>
                    </div>
                <?php endif; ?>

                <label>Genre</label>
                <input type="text" value="<?php echo htmlspecialchars($row['genre']); ?>" name="genre" required>
                <?php if (isset($error_message['genre'])): ?>
                    <div class="message">
                        <p><?php echo $error_message['genre']; ?></p>
                    </div>
                <?php endif; ?>

                <label>Author</label>
                <input type="text" value="<?php echo htmlspecialchars($row['author']); ?>" name="author" required>
                <?php if (isset($error_message['author'])): ?>
                    <div class="message">
                        <p><?php echo $error_message['author']; ?></p>
                    </div>
                <?php endif; ?>

                <label>Cover Image</label>
                <input type="file" name="coverimage" required>
                <?php if (isset($error_message['coverimage'])): ?>
                    <div class="message">
                        <p><?php echo $error_message['coverimage']; ?></p>
                    </div>
                <?php endif; ?>

                <label>Is Audio Book?</label>
                <input type="checkbox" id="is_audio" name="is_audio" onclick="toggleFields()" <?php echo $row['is_audio'] ? 'checked' : ''; ?>>

                <div class="regular-book-fields">
                    <label>Book File</label>
                    <input type="file" name="bookfile">
                    <?php if (isset($error_message['bookfile'])): ?>
                        <div class="message">
                            <p><?php echo $error_message['bookfile']; ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="audio-book-fields">
                    <label>Audio File</label>
                    <input type="file" name="audiofile">
                    <?php if (isset($error_message['audiofile'])): ?>
                        <div class="message">
                            <p><?php echo $error_message['audiofile']; ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <label>Blog</label>
                <textarea name="blog" cols="30" rows="10"><?php echo htmlspecialchars($row['blog']); ?></textarea>
                <?php if (isset($error_message['blog'])): ?>
                    <div class="message">
                        <p><?php echo $error_message['blog']; ?></p>
                    </div>
                <?php endif; ?>

                <input type="submit" value="Update Book" name="updatebook" class="btn">
            </form>
        </fieldset>
    </header>
</body>
</html>
