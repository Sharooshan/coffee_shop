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
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input
    if (!empty($email) && !empty($password)) {
        // Prepare SQL statement to select user based on email
        $sql = "SELECT * FROM ad_staff WHERE email = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        // Bind parameters and execute SQL statement
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_category'] = $user['category'];

                // Redirect to the appropriate dashboard based on category
                if ($user['category'] == 'admin') {
                    header("Location: ad_dashboard.html");
                } elseif ($user['category'] == 'staff') {
                    header("Location: staff_dashboard.html");
                }
                exit();
            } else {
                echo "Incorrect email or password";
            }
        } else {
            echo "Incorrect email or password";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Please enter email and password";
    }
}

// Close connection
$conn->close();
?>
