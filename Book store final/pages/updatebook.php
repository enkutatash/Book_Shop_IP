<?php
include "../backend/connection.php";

$id = $_GET['id']; 
$stmt = $conn->prepare("SELECT * FROM textbook WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();

// Fetch the result
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $coverimage = $_FILES['coverimage']['name'];
    $blog = $_POST['blog'];
    $book = $_FILES['book']['name'];

    $error_message = array();
    $imageUrlRegex = "/\.(jpg|jpeg|png|gif)$/i";

    if (empty($name)) {
        $error_message['name'] = "Name is required.";
    }

    if (empty($price)) {      
        $error_message['price'] = "Price is required.";
    }

    if (empty($coverimage)) {
        $error_message['coverimage'] = "Cover image is required.";
    }

    if (empty($book)) {
        $error_message['book'] = "Book is required.";
    }

    // If no validation errors, proceed with the update
    if (empty($error_message)) {
        try {
            $sql = $conn->prepare("UPDATE textbook SET bookname = :bookname, price = :price, coverimage = :coverimage, coversize = :coversize, covertype = :covertype, blog = :blog, filename = :filename, filesize = :filesize, filetype = :filetype WHERE id = :id");
            $sql->bindParam(':id', $id);
            $sql->bindParam(':bookname', $name);
            $sql->bindParam(':price', $price);
            $sql->bindParam(':coverimage', $coverimage);
            $sql->bindParam(':coversize', $_FILES['coverimage']['size']);
            $sql->bindParam(':covertype', $_FILES['coverimage']['type']);
            $sql->bindParam(':blog', $blog);
            $sql->bindParam(':filename', $book);
            $sql->bindParam(':filesize', $_FILES['book']['size']);
            $sql->bindParam(':filetype', $_FILES['book']['type']);
            $result = $sql->execute();

            if ($result) {
                header("Location: ../pages/admin.php");
                exit();
            } else {
                echo "Error updating record.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}



?>


<!DOCTYPE php>
<php lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="shortcut icon" href="../img/icon.jpg" type="image/x-icon">
    <title>Update</title>
    <style>
        *{
           margin: 0;
           padding: 0;
           box-sizing: border-box;
           font-family: 'Poppins', sans-serif;
         }
         header{
            background: #e7f0f3ac;
            width: 100%;
            height: 100%;
         }
        fieldset{
            width: 400px;
            margin: 30px auto;
            text-align: center;
            border-radius: 20px;
           
        }
        .form {
            
            max-width: 300px;
        }
        .form input{
            display: block;
            width: 350px;
            height: 30px;
            margin: 30px;
           
        }
        .form label{
            display: block;
            text-align: left;
            padding-left: 20px;
        }
        .form .btn{
         cursor: pointer;
         background-color: #0b910b;
         color: #ffffff;
         font-size: 20px;
         border: none;
         border-radius: 10px;
        }

        .form .btn:hover{
        border: 1px solid #0b910b;
        color: #0b910b;
        background: #ffffff;
        }
        .form .message{
            color: red;
            font-size: 15px;
            text-align: center;
        }
        @media(max-width:900px)
{
    fieldset{
        width :400px;
    }
    input{
        max-width: 250px;
      
    }
    
}
    </style>
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
            <legend>Text Book</legend>
            <form action="" enctype="multipart/form-data" method="POST">
                <!-- Hidden input to store the ID -->
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                
                <label>Book Name</label>
                <input type="text" value="<?php echo htmlspecialchars($row['bookname']); ?>" name="name" required>
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

                <label>Cover Image</label>
                <input type="file" name="coverimage" required>
                <?php if (isset($error_message['coverimage'])): ?>
                    <div class="message">
                        <p><?php echo $error_message['coverimage']; ?></p>
                    </div>
                <?php endif; ?>

                <label>Book</label>
                <input type="file" name="book" required>
                <?php if (isset($error_message['book'])): ?>
                    <div class="message">
                        <p><?php echo $error_message['book']; ?></p>
                    </div>
                <?php endif; ?>

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
</php>
