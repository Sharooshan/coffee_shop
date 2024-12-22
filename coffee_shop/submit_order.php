<?php
session_start();

// Check if the user is logged in, if not then redirect to the sign-in page
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.html");
    exit();
}

// Database connection
$servername = "localhost"; // Change to your server name
$username = "root"; // Change to your database username
$password = ""; // Change to your database password
$dbname = "coffee_shop"; // Change to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$coffee_name = $_POST['coffee_name'];
$quantity = intval($_POST['quantity']);
$customer_name = $_POST['customer_name'];
$contact_number = $_POST['contact_number'];

// Example array of coffee varieties (to get the price)
$coffeeVarieties = array(
    array(
        'name' => 'Kandy Special Coffee',
        'type' => 'Sri Lankan',
        'description' => 'A special coffee blend from Kandy.',
        'image' => 'kandy_coffee.jpg',
        'price' => 4.50
    ),
    array(
        'name' => 'Masala Special Coffee',
        'type' => 'Indian',
        'description' => 'A special coffee blend with Indian spices.',
        'image' => 'masala_coffee.jpg',
        'price' => 5.00
    ),
    array(
        'name' => 'Zung Special Coffee',
        'type' => 'Chinese',
        'description' => 'A special coffee blend from Zung province.',
        'image' => 'zung_coffee.jpg',
        'price' => 4.75
    )
);

// Function to find coffee price by name in the array
function findCoffeePriceByName($coffeeVarieties, $name) {
    foreach ($coffeeVarieties as $coffee) {
        if ($coffee['name'] === $name) {
            return $coffee['price'];
        }
    }
    return null; // Return null if coffee is not found
}

$price = findCoffeePriceByName($coffeeVarieties, $coffee_name);
if ($price === null) {
    die("Coffee not found");
}

$total = $price * $quantity;

// Retrieve user ID and email from session
$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['user_email'];

// Save to database
$sql = "INSERT INTO orders (user_id, user_email, coffee_name, quantity, customer_name, contact_number, price, total)
        VALUES ($user_id, '$user_email', '$coffee_name', $quantity, '$customer_name', '$contact_number', $price, $total)";

if ($conn->query($sql) === TRUE) {
    $order_id = $conn->insert_id;
    header("Location: order_summary.php?order_id=$order_id");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
