<?php
// // admin_orders.php
// session_start();

// if (!isset($_SESSION['user_id']) || !isset($_SESSION['admin'])) {
//     header("Location: signin.html");
//     exit();
// }

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffee_shop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch orders
$sql = "SELECT * FROM delivery_orders";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="styles.css"> 
</head>

<body>

<style>
/* General Styles */
body {
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    background-color: #f8f9fa; /* Light gray background */
    margin: 0;
    padding: 0;
}

.container {
    max-width: 1200px;
    margin: 30px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    background-color: #fff; /* White background */
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

h1 {
    color: #dc3545; /* Red */
    margin-bottom: 20px;
    text-align: center;
    font-size: 2em;
    font-weight: 300;
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    background-color: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

table, th, td {
    border: 1px solid #ddd; /* Light gray border */
}

th, td {
    padding: 15px;
    text-align: left;
    vertical-align: middle;
    font-size: 0.95em;
}

th {
    background-color: #dc3545; /* Red background for header */
    color: #fff; /* White text */
    font-weight: 500;
}

tr:nth-child(even) {
    background-color: #f2f2f2; /* Light gray for even rows */
}

tr:hover {
    background-color: #e9ecef; /* Light gray background on hover */
}

/* Link Styles */
a {
    color: #dc3545; /* Red for links */
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s ease-in-out;
}

a:hover {
    color: #c82333; /* Darker red */
    text-decoration: underline;
}

/* Button Styles */
.btn {
    border: none;
    border-radius: 4px;
    padding: 8px 12px;
    font-size: 14px;
    font-weight: 500;
    text-transform: uppercase;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out, transform 0.3s ease-in-out;
    margin: 2px;
    display: inline-block;
    color: #fff; /* White text */
}

.btn-accept {
    background-color: #28a745; /* Green */
}

.btn-accept:hover {
    background-color: #218838; /* Darker green */
    transform: scale(1.05);
}

.btn-reject {
    background-color: #dc3545; /* Red */
}

.btn-reject:hover {
    background-color: #c82333; /* Darker red */
    transform: scale(1.05);
}

.btn-warning {
    background-color: #ffc107; /* Yellow */
    color: #000; /* Black text */
}

.btn-warning:hover {
    background-color: #e0a800; /* Darker yellow */
    border-color: #d39e00;
    transform: scale(1.05);
}

/* Responsive Styles */
@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    table, th, td {
        font-size: 0.9em;
    }

    th, td {
        padding: 10px;
    }

    .btn {
        padding: 6px 10px;
        font-size: 12px;
    }
}


</style>
    <h1>Manage Orders</h1>
    <?php
    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Order ID</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Address</th>
                    <th>Payment Method</th>
                    <th>Feedback</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["name"] . "</td>
                    <td>" . $row["mobile"] . "</td>
                    <td>" . $row["address"] . "</td>
                    <td>" . $row["payment_method"] . "</td>
                    <td>" . $row["feedback"] . "</td>
                    <td>" . $row["status"] . "</td>
                    <td>
                        <a href='update_order_status.php?id=" . $row["id"] . "&status=accepted'>Accept</a> |
                        <a href='update_order_status.php?id=" . $row["id"] . "&status=rejected'>Reject</a>
                    </td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No orders found";
    }

    $conn->close();
    ?>
</body>
</html>
