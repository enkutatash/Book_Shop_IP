<?php
session_start();

include "../backend/connection.php";

function sanitize($input) {
    global $conn; 
    return htmlspecialchars(trim($input));
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); 
    exit();
}

$user_id = $_SESSION['user_id'];



try {
    
    $sql = "SELECT b.id AS book_id, b.book_name, b.is_audio, f.file_name, f.file_type, f.file_size, f.file
            FROM cart_books cb
            JOIN books b ON cb.book_id = b.id
            JOIN files f ON b.book_file = f.id
            WHERE cb.cart_id IN (SELECT c.id FROM cart c WHERE c.user = :user_id)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

    try {
        $zip = new ZipArchive();
        $temp_file = tempnam(sys_get_temp_dir(), 'cart_files');
    
        if ($zip->open($temp_file, ZipArchive::CREATE) !== true) {
            throw new Exception('Cannot create ZIP archive');
        }
    
        foreach ($books as $book) {
            $file_name = $book['file_name'];
            $file_content = $book['file'];
            $zip->addFromString($file_name, $file_content);
        }
    
        $zip->close();
    } catch (Exception $e) {
        $e->getMessage();
    }



    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="books_cart.zip"');
    header('Content-Length: ' . filesize($temp_file));

    readfile($temp_file);

    unlink($temp_file);
} catch (PDOException $e) {
    echo "<div>Database Error: " . $e->getMessage() . "</div>";
} catch (Exception $e) {
    echo "<div>Error: " . $e->getMessage() . "</div>";
}

