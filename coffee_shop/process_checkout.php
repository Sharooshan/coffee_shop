<?php
// process_checkout.php
session_start();

// Check if the user is logged in, if not then redirect to the sign-in page
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.html");
    exit();
}

$delivery_option = $_POST['delivery_option'];

if ($delivery_option == 'delivery') {
    header("Location: delivery_form.php");
} elseif ($delivery_option == 'reservation') {
    header("Location: reservation.php");
} else {
    // Handle unexpected cases
    echo "Invalid delivery option.";
}
exit();
?>
