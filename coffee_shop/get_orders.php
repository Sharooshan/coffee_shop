<?php
// Connect to your MySQL database (Assuming you have already established a connection)
include_once('db_connect.php'); // Update with your database connection file

// SQL query to fetch orders (example query)
$query = "SELECT * FROM orders";

// Perform query
$result = mysqli_query($conn, $query);

// Check for errors
if (!$result) {
    die('Error: ' . mysqli_error($conn));
}

// Fetch data and format as JSON
$orders = array();
while ($row = mysqli_fetch_assoc($result)) {
    $order_id = $row['order_id'];
    $status = $row['status'];
    // Example: Fetch items related to each order from another table
    $items_query = "SELECT * FROM order_items WHERE order_id = $order_id";
    $items_result = mysqli_query($conn, $items_query);
    $items = array();
    while ($item_row = mysqli_fetch_assoc($items_result)) {
        $items[] = array(
            'name' => $item_row['item_name'],
            'price' => floatval($item_row['item_price'])
        );
    }
    $orders[] = array(
        'order_id' => $order_id,
        'status' => $status,
        'items' => $items
    );
}

// Output JSON response
header('Content-Type: application/json');
echo json_encode($orders);

// Close connection
mysqli_close($conn);
?>
