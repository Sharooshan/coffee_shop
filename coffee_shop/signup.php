<?php
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
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate password complexity
    if (strlen($password) < 8 || !preg_match('/[0-9!@#$%^&*]/', $password)) {
        die("Password must be at least 8 characters long and include at least one number or symbol.");
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if email already exists
    $check_email_sql = "SELECT id FROM users WHERE email = ?";
    $check_stmt = $conn->prepare($check_email_sql);
    if ($check_stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        die("Email already exists. Please use a different email.");
    }

    // Proceed with insert
    $insert_sql = "INSERT INTO users (email, password) VALUES (?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    if ($insert_stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $insert_stmt->bind_param("ss", $email, $hashed_password);
    if ($insert_stmt->execute()) {
        echo "User registered successfully";
    } else {
        echo "Error: " . $insert_stmt->error;
    }

    $insert_stmt->close();
    $check_stmt->close();
    $conn->close();
}
?>
