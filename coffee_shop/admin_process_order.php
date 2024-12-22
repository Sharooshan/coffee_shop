<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_category'] != 'admin') {
    header("Location: admin_login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffee_shop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['accept_order'])) {
        $order_id = $_POST['order_id'];
        $sql = "UPDATE orders SET status = 'accepted' WHERE id = $order_id";

        if ($conn->query($sql) === TRUE) {
            echo "Order accepted successfully.";
        } else {
            echo "Error accepting order: " . $conn->error;
        }
    } elseif (isset($_POST['cancel_order'])) {
        $order_id = $_POST['order_id'];
        $sql = "UPDATE orders SET status = 'cancelled' WHERE id = $order_id";

        if ($conn->query($sql) === TRUE) {
            echo "Order cancelled successfully.";
        } else {
            echo "Error cancelling order: " . $conn->error;
        }
    }
}

$conn->close();
?>
