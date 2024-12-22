<?php
session_start();

// // Check if the user is logged in and is an admin, if not then redirect to the sign-in page
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: admin_login.html");
//     exit();
// }

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

// Count the number of accepted reservations
$count_sql = "SELECT COUNT(*) as count FROM reservations WHERE status = 'accept'";
$count_result = $conn->query($count_sql);
$count_row = $count_result->fetch_assoc();
$accepted_count = $count_row['count'];

// If there are less than 20 accepted reservations, accept all pending reservations
if ($accepted_count < 20 && isset($_POST['accept_pending'])) {
    $remaining_tables = 20 - $accepted_count;
    $update_sql = "UPDATE reservations SET status = 'accept' WHERE status = 'pending' LIMIT $remaining_tables";

    if ($conn->query($update_sql) === TRUE) {
        echo "All pending reservations accepted successfully";
    } else {
        echo "Error updating reservations: " . $conn->error;
    }
}

// Redirect back to admin_reservations.php
header("Location: admin_reservations.php");
exit();
?>
