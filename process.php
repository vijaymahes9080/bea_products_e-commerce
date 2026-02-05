<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "signin_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$number = $_POST['number'];

if (!empty($name) && !empty($email) && !empty($number)) {
    $stmt = $conn->prepare("INSERT INTO users (name, email, phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $number);
    
    if ($stmt->execute()) {
        echo "Sign-in successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "All fields are required!";
}

$conn->close();
?>
