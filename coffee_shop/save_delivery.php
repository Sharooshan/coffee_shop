<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.html");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffee_shop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect and sanitize data
$name = $conn->real_escape_string($_POST['name']);
$mobile = $conn->real_escape_string($_POST['mobile']);
$address = $conn->real_escape_string($_POST['address']);
$payment_method = $conn->real_escape_string($_POST['payment_method']);
$feedback = $conn->real_escape_string($_POST['feedback']);
$user_id = $_SESSION['user_id'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO delivery_orders (user_id, name, mobile, address, payment_method, feedback) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssss", $user_id, $name, $mobile, $address, $payment_method, $feedback);

if ($stmt->execute()) {
    echo "Order saved successfully";
} else {
    echo "Error saving order: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
