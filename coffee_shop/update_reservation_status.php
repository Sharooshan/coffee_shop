<?php
session_start();

// // Check if the user is logged in and is an admin, if not then redirect to the sign-in page
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: admin_login.html");
//     exit();
// }

// Check if the reservation ID and status are set
if (isset($_POST['reservation_id']) && isset($_POST['status'])) {
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

    $reservation_id = $conn->real_escape_string($_POST['reservation_id']);
    $status = $conn->real_escape_string($_POST['status']);

    // Update the reservation status
    $sql = "UPDATE reservations SET status = '$status' WHERE id = '$reservation_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Reservation status updated successfully";
    } else {
        echo "Error updating reservation status: " . $conn->error;
    }

    $conn->close();

    // Redirect back to admin_reservations.php
    header("Location: admin_reservations.php");
    exit();
} else {
    echo "No reservation ID or status specified";
    exit();
}
?>
