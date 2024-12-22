<?php
session_start();

// Check if user is logged in and is a staff member
if (!isset($_SESSION['user_id']) || $_SESSION['user_category'] != 'staff') {
    header("Location: admin_login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
</head>
<body>
    <h1>Welcome, Staff Member</h1>
    <p>This is the staff dashboard.</p>
</body>
</html>
