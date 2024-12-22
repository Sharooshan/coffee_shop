<?php
session_start();

// // Check if the user is logged in and is an admin
// if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
//     header("Location: signin.html");
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

// Fetch table details for editing
$tables = [];
$sql = "SELECT * FROM tables";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tables[$row['table_number']] = $row;
    }
}

// Process form submission for updating table details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_table'])) {
    $table_number = $_POST['table_number'];
    $description = $_POST['description'];

    // Handle image upload
    if (isset($_FILES['photo_url']) && $_FILES['photo_url']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo_url"]["name"]);
        move_uploaded_file($_FILES["photo_url"]["tmp_name"], $target_file);
        $photo_url = $target_file;

        $sql = "UPDATE tables SET photo_url='$photo_url', description='$description' WHERE table_number='$table_number'";
    } else {
        $sql = "UPDATE tables SET description='$description' WHERE table_number='$table_number'";
    }

    if ($conn->query($sql) === TRUE) {
        $success_message = "Table details updated successfully!";
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin Edit - THE GALLERY Cafe</title>
    <style>
       /* styles.css */

/* General Styles */
body {
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    background-color: #f4f4f4; /* Light gray background for contrast */
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 30px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    color: #000; /* Black color for the heading */
    margin-bottom: 20px;
    text-align: center;
    font-size: 2em;
    font-weight: 300;
}

/* Form Styles */
.form-label {
    font-weight: bold;
    color: #000; /* Black color for labels */
}

.form-control {
    border-radius: 5px;
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 20px;
    font-size: 1em;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #f39c12; /* Yellow border on focus */
    box-shadow: 0 0 10px rgba(243, 156, 18, 0.25);
}

.btn-primary {
    background-color: #e74c3c; /* Red background */
    border-color: #e74c3c; /* Red border */
    color: #fff; /* White text */
    font-weight: bold;
    padding: 10px 20px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #c0392b; /* Darker red on hover */
    border-color: #c0392b; /* Darker red border */
    transform: scale(1.05);
}

/* Alert Styles */
.alert {
    border-radius: 5px;
    padding: 15px;
    font-size: 1em;
    margin-bottom: 20px;
}

.alert-success {
    background-color: #f4f4f4; /* Light gray background */
    border-color: #d4edda; /* Light green border */
    color: #155724; /* Dark green text */
}

.alert-danger {
    background-color: #f8d7da; /* Light pink background */
    border-color: #f5c6cb; /* Light pink border */
    color: #721c24; /* Dark red text */
}

/* Responsive Styles */
@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    h1 {
        font-size: 1.5em;
    }

    .form-control {
        font-size: 0.9em;
    }

    .btn-primary {
        padding: 8px 15px;
    }
}

    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Admin Edit Page</h1>
        <?php
        if (isset($success_message)) {
            echo "<div class='alert alert-success'>$success_message</div>";
        } elseif (isset($error_message)) {
            echo "<div class='alert alert-danger'>$error_message</div>";
        }
        ?>
        <form action="admin_edit.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="table_number" class="form-label">Table Number</label>
                <select class="form-control" id="table_number" name="table_number" required>
                    <option value="">Select Table Number</option>
                    <?php
                    foreach ($tables as $table) {
                        echo "<option value='{$table['table_number']}'>{$table['table_number']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Table Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="photo_url" class="form-label">Table Photo</label>
                <input type="file" class="form-control" id="photo_url" name="photo_url">
            </div>
            <button type="submit" class="btn btn-primary" name="update_table">Update Table</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('table_number').addEventListener('change', function() {
            const selectedTable = this.value;
            const tables = <?php echo json_encode($tables); ?>;
            if (selectedTable && tables[selectedTable]) {
                document.getElementById('description').value = tables[selectedTable]['description'];
            }
        });
    </script>
</body>
</html>
