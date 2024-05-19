<?php
session_start();
include "./connection.php";

function filter_input_data($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}
if (isset($_GET['q'])) {
    $query = filter_input_data($_GET['q']);

    // Build the SQL query
    $sql = "SELECT * FROM textbook WHERE bookname LIKE :query OR author LIKE :query";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':query', '%' . $query . '%');
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            echo "<h2>Search Results:</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Book Name</th><th>Author</th><th>Price</th><th>Cover Image</th></tr>";
            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['bookname'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td>" . htmlspecialchars($row['author'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td>" . htmlspecialchars($row['price'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td><img src='uploads/" . htmlspecialchars($row['coverimage'], ENT_QUOTES, 'UTF-8') . "' width='100' height='150'></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No books found matching your criteria.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    echo "No search query provided.";
}
