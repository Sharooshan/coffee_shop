<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffee_shop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define the directory to save the uploaded images
$target_dir = "uploads/";

// Update product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $country = $_POST['country'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    if ($_FILES['image']['name']) {
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image = $target_file;
    } else {
        $image = $_POST['existing_image'];
    }

    $sql = "UPDATE products SET name='$name', country='$country', category='$category', price='$price', image='$image' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        $message = "Product updated successfully";
    } else {
        $message = "Error updating product: " . $conn->error;
    }
}

// Add new product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $name = $_POST['name'];
    $country = $_POST['country'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    $image = $target_file;

    $sql = "INSERT INTO products (name, country, category, price, image) VALUES ('$name', '$country', '$category', '$price', '$image')";

    if ($conn->query($sql) === TRUE) {
        $message = "Product added successfully";
    } else {
        $message = "Error adding product: " . $conn->error;
    }
}

// Delete product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM products WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        $message = "Product deleted successfully";
    } else {
        $message = "Error deleting product: " . $conn->error;
    }
}

// Fetch all items
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Items</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
 /* General Styles */
body {
    background-color: #f8f9fa; /* Light gray background */
    font-family: Arial, sans-serif;
}

.container {
    max-width: 1200px;
    margin: 30px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #fff; /* White background */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    color: #dc3545; /* Red for heading */
    margin-bottom: 20px;
    text-align: center;
}

/* Table Styles */
.table {
    width: 100%;
    margin-bottom: 1rem;
    color: #212529; /* Dark text color */
}

.table-bordered {
    border: 1px solid #dee2e6; /* Light gray border */
}

.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6; /* Light gray border */
    background-color: #dc3545; /* Red background */
    color: #fff; /* White text */
    text-align: center;
}

.table tbody td {
    vertical-align: middle;
    text-align: center;
}

.table tbody tr:nth-child(even) {
    background-color: #f9f9f9; /* Light gray for alternate rows */
}

.table tbody tr:hover {
    background-color: #e2e2e2; /* Slightly darker gray background on hover */
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
    color: #fff; /* White text */
}

.btn-primary:hover {
    background-color: #c82333; /* Darker red */
    border-color: #bd2130;
    transform: scale(1.05);
}

.btn-danger {
    background-color: #000; /* Black */
    border-color: #000;
    color: #fff; /* White text */
}

.btn-danger:hover {
    background-color: #333; /* Darker black */
    border-color: #333;
    transform: scale(1.05);
}

.btn-success {
    background-color: #ffc107; /* Yellow */
    border-color: #ffc107;
    color: #000; /* Black text */
}

.btn-success:hover {
    background-color: #e0a800; /* Darker yellow */
    border-color: #d39e00;
    transform: scale(1.05);
}

.btn-warning {
    background-color: #ffeb3b; /* Light yellow */
    border-color: #ffeb3b;
    color: #000; /* Black text */
}

.btn-warning:hover {
    background-color: #fbc02d; /* Darker yellow */
    border-color: #fbc02d;
    transform: scale(1.05);
}

/* Form Styles */
form {
    display: inline-block;
}

input[type="text"],
input[type="number"],
select {
    border: 1px solid #dc3545; /* Red border */
    border-radius: 4px;
    padding: 8px;
    margin-bottom: 10px;
}

input[type="text"]:focus,
input[type="number"]:focus,
select:focus {
    border-color: #ffc107; /* Yellow border on focus */
    box-shadow: 0 0 5px rgba(255, 193, 7, 0.5); /* Yellow shadow on focus */
    outline: none;
}

p {
    font-size: 18px;
    color: #333; /* Dark gray text */
    text-align: center;
}

/* Additional Elements */
.alert-info {
    background-color: #dc3545; /* Red background */
    color: #fff; /* White text */
    border: 1px solid #c82333; /* Darker red border */
}

.alert-info .alert-heading {
    color: #fff; /* White text */
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Admin - Edit Items</h1>
        
        <?php if (isset($message)) echo "<div class='alert alert-info'>$message</div>"; ?>

        <h2>Edit Existing Items</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Country</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <form method='POST' action='' enctype='multipart/form-data'>
                                <td><?= $row['id'] ?><input type='hidden' name='id' value='<?= $row['id'] ?>'></td>
                                <td><input type='text' name='country' value='<?= $row['country'] ?>' class='form-control'></td>
                                <td><input type='text' name='name' value='<?= $row['name'] ?>' class='form-control'></td>
                                <td>
                                    <select name='category' class='form-select'>
                                        <option value='coffee' <?= $row['category'] == 'coffee' ? 'selected' : '' ?>>Coffee</option>
                                        <option value='ice-cream' <?= $row['category'] == 'ice-cream' ? 'selected' : '' ?>>Ice Cream</option>
                                        <option value='sweets' <?= $row['category'] == 'sweets' ? 'selected' : '' ?>>Sweets</option>
                                    </select>
                                </td>
                                <td>
                                    <input type='file' name='image' class='form-control'>
                                    <input type='hidden' name='existing_image' value='<?= $row['image'] ?>'>
                                    <img src='<?= $row['image'] ?>' width='100' alt='Product Image'>
                                </td>
                                <td><input type='number' step='0.01' name='price' value='<?= $row['price'] ?>' class='form-control'></td>
                                <td>
                                    <button type='submit' name='update' class='btn btn-primary'>Update</button>
                                    <button type='submit' name='delete' class='btn btn-danger'>Delete</button>
                                </td>
                            </form>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan='7'>No products found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h2>Add New Item</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <input type="text" name="country" id="country" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category" id="category" class="form-select" required>
                    <option value="coffee">Coffee</option>
                    <option value="ice-cream">Ice Cream</option>
                    <option value="sweets">Sweets</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image" id="image" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" required>
            </div>
            <button type="submit" name="add" class="btn btn-success">Add Item</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>
