<?php


// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffee_shop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect data
$id = intval($_GET['id']);
$status = $_GET['status'];

if (!in_array($status, ['accepted', 'rejected'])) {
    die("Invalid status");
}


// Update status
$stmt = $conn->prepare("UPDATE delivery_orders SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    header("Location: admin_orders.php"); // Redirect back to orders page
    exit();
} else {
    echo "Error updating order status: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
