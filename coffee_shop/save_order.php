<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "User not logged in.";
    exit();
}

$user_id = $_SESSION['user_id'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffee_shop";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['cartItems'])) {
        $cartItems = json_decode($_POST['cartItems'], true);

        $stmt = $conn->prepare("INSERT INTO new_online_order (user_id, item_id, item_name, item_price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iisd", $user_id, $item_id, $item_name, $item_price);

        foreach ($cartItems as $item) {
            $item_id = $item['id'];
            $item_name = $item['name'];
            $item_price = $item['price'];
            $stmt->execute();
        }

        $stmt->close();
        echo "Order has been saved successfully.";
    } else {
        echo "No items in cart.";
    }
}

$conn->close();
?>
