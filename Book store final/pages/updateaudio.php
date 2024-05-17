<?php
include "../backend/connection.php";

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM audiobook WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $blog = $_POST['blog'];
    
    $coverimage = $_FILES['coverimage']['name'];
    $coverimagetemp = $_FILES['coverimage']['tmp_name'];
    
    $target_dir = "../uploads/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $cover_target_file = $target_dir . basename($coverimage);
    $audio_target_file = $target_dir . basename($_FILES['audio']['name']);
    $sample_target_file = $target_dir . basename($_FILES['audiosample']['name']);

    if (move_uploaded_file($coverimagetemp, $cover_target_file) &&
        move_uploaded_file($_FILES['audio']['tmp_name'], $audio_target_file) &&
        move_uploaded_file($_FILES['audiosample']['tmp_name'], $sample_target_file)) {

        $coverimagename = basename($coverimage);
        $coversize = $_FILES['coverimage']['size'];
        $covertype = $_FILES['coverimage']['type'];

        $filename = basename($_FILES['audio']['name']);
        $filesize = $_FILES['audio']['size'];
        $filetype = $_FILES['audio']['type'];

        $samplefilename = basename($_FILES['audiosample']['name']);
        $samplefilesize = $_FILES['audiosample']['size'];
        $samplefiletype = $_FILES['audiosample']['type'];

        $sql = $conn->prepare("UPDATE audiobook SET bookname = :bookname, price = :price, coverimage = :coverimage, coversize = :coversize, covertype = :covertype, blog = :blog, filename = :filename, filesize = :filesize, filetype = :filetype, samplename = :samplename, samplesize = :samplesize, sampletype = :sampletype WHERE id = :id");
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
        $sql->bindParam(':id', $id);

        if ($sql->execute()) {
            header("Location: ../pages/admin.php");
            exit();
        } else {
            echo "Error: Could not update the book";
        }
    } else {
        echo "Sorry, there was an error uploading your files.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    html
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="shortcut icon" href="../img/icon.jpg" type="image/x-icon">
    <title>Update Book</title>
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
        }
        .form .btn:hover {
            border: 1px solid #0b910b;
            color: #0b910b;
            background: #ffffff;
        }
        @media(max-width:900px) {
            fieldset {
                width: 400px;
            }
            input {
                max-width: 250px;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="../img/logo2.jpg" alt="" style="width: 40px; height: 30px;">
                <h2>Book Store</h2>
            </div>
            <div class="navmenu">
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="./updatebook.php">Edit Books</a></li>
                </ul>
            </div>
        </nav>

        <fieldset class="form">
            <legend>Update Book</legend>
            <form action="" enctype="multipart/form-data" method="POST">
                <label>Book Name</label>
                <input type="text" name="name" required value="<?php echo htmlspecialchars($row['bookname']); ?>">
                <label>Price</label>
                <input type="number" name="price" required value="<?php echo htmlspecialchars($row['price']); ?>">
                <label>Cover Image</label>
                <input type="file" name="coverimage">
                <label>Audio Sample</label>
                <input type="file" accept="audio/*" name="audiosample">
                <label>Audio</label>
                <input type="file" accept="audio/*" name="audio">
                <label>Blog</label>
                <textarea name="blog" cols="30" rows="10"><?php echo htmlspecialchars($row['blog']); ?></textarea>
                <input type="submit" value="Update Book" class="btn">
            </form>
        </fieldset>
    </header>
</body>
</html>
