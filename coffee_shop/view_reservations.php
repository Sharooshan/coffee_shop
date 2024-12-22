<?php
session_start();

// Check if the user is logged in, if not then redirect to the sign-in page
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.html");
    exit();
}

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

// Fetch the user's reservations with table details
$user_id = $_SESSION['user_id'];
$sql = "SELECT reservations.*, tables.photo_url, tables.description 
        FROM reservations 
        LEFT JOIN tables ON reservations.table_number = tables.table_number 
        WHERE reservations.user_id = '$user_id'";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="styleindex.css" rel="stylesheet"> -->
    
    <title>My Reservations - THE GALLERY Cafe</title>
    <style>
        .container {
            margin-top: 30px;
        }
        .table-photo {
            width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>My Reservations</h1>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Contact Number</th>
                    <th>Reservation Date</th>
                    <th>Reservation Time</th>
                    <th>Number of Guests</th>
                    <th>Table Number</th>
                    <th>Parking Space</th>
                    <th>Status</th>
                    <th>Table Photo</th>
                    <th>Table Description</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['customer_name'] . "</td>";
                        echo "<td>" . $row['contact_number'] . "</td>";
                        echo "<td>" . $row['reservation_date'] . "</td>";
                        echo "<td>" . $row['reservation_time'] . "</td>";
                        echo "<td>" . $row['num_guests'] . "</td>";
                        echo "<td>" . $row['table_number'] . "</td>";
                        echo "<td>" . ($row['parking_space'] == 'Yes' ? 'Yes' : 'No') . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        
                        // Display table photo if available
                        if (!empty($row['photo_url'])) {
                            echo "<td><img src='" . $row['photo_url'] . "' class='table-photo' alt='Table Photo'></td>";
                        } else {
                            echo "<td>No Photo Available</td>";
                        }
                        
                        echo "<td>" . $row['description'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No reservations found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="reservation.php" class="btn btn-primary">Make a New Reservation</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
