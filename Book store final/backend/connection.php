<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookstore";

try {
    $conn = new PDO("mysql:host= $servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// $dbname   = 'bookstore';
// $username = 'myuser';
// $password = '';
// try {
//     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
// } catch (Exception $e) {
//     print $e->getMessage() . "\n";
// }
print "OK\n";
?>