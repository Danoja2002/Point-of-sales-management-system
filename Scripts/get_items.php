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

$category = isset($_GET['category']) ? $_GET['category'] : '';
$sql = "SELECT * FROM stock";
if (!empty($category)) {
    $sql .= " WHERE category = ?";
}

$stmt = $conn->prepare($sql);
if (!empty($category)) {
    $stmt->bind_param('s', $category);
}
$stmt->execute();
$result = $stmt->get_result();

$items = [];
while ($row = $result->fetch_assoc()) {
    $row['price'] = (float)$row['price']; 
    $items[] = $row;
}

echo json_encode($items);

$conn->close();
?>
