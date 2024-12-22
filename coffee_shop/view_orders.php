<?php
session_start();

// Check if the user is logged in, if not then redirect to the sign-in page
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.html");
    exit();
}

include 'db_config.php'; // Your database configuration file

// Retrieve user ID from session
$user_id = $_SESSION['user_id'];

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch order details for the logged-in user
$sql = "SELECT * FROM new_online_order WHERE user_id = $user_id ORDER BY order_date DESC";
$result = $conn->query($sql);

$orderDetails = [];
$totalPrice = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orderDetails[$row['order_date']][] = $row;
        if (!isset($totalPrice[$row['order_date']])) {
            $totalPrice[$row['order_date']] = 0;
        }
        $totalPrice[$row['order_date']] += $row['item_price'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- <link href="styleindex.css" rel="stylesheet"> -->
    <title>Order Details - THE GALLERY Cafe</title>
</head>
<body>
    
    <div class="container mt-5">
        <h1>Order Details</h1>

        <?php if (!empty($orderDetails)): ?>
            <?php foreach ($orderDetails as $date => $orders): ?>
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>Order Date:</strong> <?php echo $date; ?>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Item Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?php echo $order['item_name']; ?></td>
                                        <td>$<?php echo number_format($order['item_price'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <p><strong>Total Price:</strong> $<?php echo number_format($totalPrice[$date], 2); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </div>
</body>
</html>
