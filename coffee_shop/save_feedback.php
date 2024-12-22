<?php
// Database connection details
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

// Process feedback submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == 'submit_feedback') {
        $feedback = $_POST['feedback'];

        // Prepare and bind SQL statement
        $stmt = $conn->prepare("INSERT INTO feedback (feedback_text, submitted_at) VALUES (?, NOW())");
        $stmt->bind_param("s", $feedback_text);

        // Set parameters and execute
        $feedback_text = $feedback;
        if ($stmt->execute()) {
            echo json_encode(array("status" => "success", "message" => "Feedback submitted successfully"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Error submitting feedback"));
        }

        $stmt->close();
    }
}

// Retrieve all feedback entries
$sql = "SELECT id, feedback_text, submitted_at FROM feedback ORDER BY submitted_at DESC";
$result = $conn->query($sql);

$feedback_entries = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $feedback_entries[] = $row;
    }
}

$conn->close();

// Return feedback entries as JSON
echo json_encode($feedback_entries);
?>
