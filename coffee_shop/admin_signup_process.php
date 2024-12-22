<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database credentials
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

// Validate form submission method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $category = $_POST['category'];

    // Validate input
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    // Password validation: at least 8 characters and includes at least one number or symbol
    if (strlen($password) < 8 || !preg_match("/[0-9!@#$%^&*]/", $password)) {
        die("Password must be at least 8 characters long and include at least one number or symbol");
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM ad_staff WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email already exists
        echo "Email address already registered. Please use a different email.";
    } else {
        // Email does not exist, proceed with signup
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password

        // Insert new user into database
        $stmt = $conn->prepare("INSERT INTO ad_staff (email, password, category) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $hashed_password, $category);
        
        if ($stmt->execute()) {
            // Redirect to success page or login page
            //header("Location: .html");
            echo "Registration successfull " ;
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }

    $stmt->close();
    $conn->close();
}


?>
