<?php
$servername = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'pos';

// Database connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$sql = "SELECT DISTINCT category FROM stock";
$result = $conn->query($sql);

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category'];
}

echo json_encode($categories);

$conn->close();
?>
