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

// Fetch all reservations
$sql = "SELECT * FROM reservations";
$result = $conn->query($sql);

// Count the accepted reservations
$count_sql = "SELECT COUNT(*) as count FROM reservations WHERE status = 'accept'";
$count_result = $conn->query($count_sql);
$count_row = $count_result->fetch_assoc();
$accepted_count = $count_row['count'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Reservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
       /* General Styles */
body {
    background-color: #f8f9fa;
    font-family: Arial, sans-serif;
}

.container {
    max-width: 1200px;
    margin: 30px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    color: #333;
    margin-bottom: 20px;
    text-align: center;
}

/* Table Styles */
.table {
    width: 100%;
    margin-bottom: 1rem;
    color: #212529;
}

.table-bordered {
    border: 1px solid #dee2e6;
}

.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
    background-color: #343a40;
    color: #fff;
    text-align: center;
}

.table tbody td {
    vertical-align: middle;
    text-align: center;
}

.table tbody tr:hover {
    background-color: #f1f1f1;
}

/* Button Styles */
.btn {
    border-radius: 4px;
    padding: 6px 12px;
    font-size: 14px;
    font-weight: 500;
    text-transform: uppercase;
    transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out, transform 0.3s ease-in-out;
}

.btn-primary {
    background-color: #dc3545; /* Red */
    border-color: #dc3545;
    color: #fff;
}

.btn-primary:hover {
    background-color: #c82333; /* Darker red */
    border-color: #bd2130;
    transform: scale(1.05);
}

.btn-danger {
    background-color: #000; /* Black */
    border-color: #000;
    color: #fff;
}

.btn-danger:hover {
    background-color: #333;
    border-color: #333;
    transform: scale(1.05);
}

.btn-success {
    background-color: #ffc107; /* Yellow */
    border-color: #ffc107;
    color: #000;
}

.btn-success:hover {
    background-color: #e0a800;
    border-color: #d39e00;
    transform: scale(1.05);
}

.btn-warning {
    background-color: #ffeb3b; /* Light Yellow */
    border-color: #ffeb3b;
    color: #000;
}

.btn-warning:hover {
    background-color: #fbc02d;
    border-color: #fbc02d;
    transform: scale(1.05);
}

/* Form Styles */
form {
    display: inline-block;
}

p {
    font-size: 18px;
    color: #333;
    text-align: center;
}

    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Manage Reservations</h1>

        <form action="update_reservations.php" method="POST">
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>User Email</th>
                        <th>Customer Name</th>
                        <th>Contact Number</th>
                        <th>Reservation Date</th>
                        <th>Reservation Time</th>
                        <th>Number of Guests</th>
                        <th>Created At</th>
                        <th>Table Number</th>
                        <th>Parking Space</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="reservation-table-body">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['user_id'] . "</td>";
                            echo "<td>" . $row['user_email'] . "</td>";
                            echo "<td>" . $row['customer_name'] . "</td>";
                            echo "<td>" . $row['contact_number'] . "</td>";
                            echo "<td>" . $row['reservation_date'] . "</td>";
                            echo "<td>" . $row['reservation_time'] . "</td>";
                            echo "<td>" . $row['num_guests'] . "</td>";
                            echo "<td>" . $row['created_at'] . "</td>";
                            echo "<td>" . $row['table_number'] . "</td>";
                            echo "<td>" . ($row['parking_space'] == 'Yes' ? 'Yes' : 'No') . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td>
                                    <form action='delete_reservation.php' method='POST' style='display:inline-block;'>
                                        <input type='hidden' name='reservation_id' value='" . $row['id'] . "'>
                                        <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                    </form>
                                    <form action='update_reservation_status.php' method='POST' style='display:inline-block;'>
                                        <input type='hidden' name='reservation_id' value='" . $row['id'] . "'>
                                        <input type='hidden' name='status' value='accept'>
                                        <button type='submit' class='btn btn-success btn-sm'>Accept</button>
                                    </form>
                                    <form action='update_reservation_status.php' method='POST' style='display:inline-block;'>
                                        <input type='hidden' name='reservation_id' value='" . $row['id'] . "'>
                                        <input type='hidden' name='status' value='cancel'>
                                        <button type='submit' class='btn btn-warning btn-sm'>Cancel</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='13'>No reservations found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary" name="accept_pending">Accept All Pending</button>
        </form>
        <p>Accepted Reservations: <?php echo $accepted_count; ?>/20</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
