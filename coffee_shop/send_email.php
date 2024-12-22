<?php
// send_email.php
function sendOrderStatusEmail($customerEmail, $orderId, $status) {
    $subject = "Order Status Update";
    $message = "Dear Customer,\n\nYour order with ID $orderId has been $status.\n\nThank you for shopping with us.";
    $headers = "From: no-reply@yourdomain.com";

    mail($customerEmail, $subject, $message, $headers);
}
?>
