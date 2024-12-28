<?php
$servername = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'pos';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Check if data is posted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = basename($_FILES['image']['name']);
        $targetDir = 'uploads/';
        $targetFilePath = $targetDir . $imageName;

        // Create directory if not exists
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            $imagePath = $targetFilePath;

            // Insert into database
            $sql = "INSERT INTO stock (category, name, price, image_path) VALUES ('$category', '$name', '$price', '$imagePath')";

            if ($conn->query($sql) === TRUE) {
                echo "Stock item inserted successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Failed to upload the image.";
        }
    } else {
        echo "Please upload a valid image.";
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
