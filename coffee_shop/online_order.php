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

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch distinct countries for the filter dropdown
$countriesResult = $conn->query("SELECT DISTINCT country FROM products");
$countries = [];
if ($countriesResult->num_rows > 0) {
    while ($row = $countriesResult->fetch_assoc()) {
        $countries[] = $row['country'];
    }
}

// Fetch filters
$countryFilter = isset($_GET['country']) ? $_GET['country'] : '';
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';
$sortOption = isset($_GET['sort']) ? $_GET['sort'] : '';

// Construct the SQL query with filters and sorting
$sql = "SELECT * FROM products WHERE 1=1";

if ($countryFilter) {
    $sql .= " AND country = '" . $conn->real_escape_string($countryFilter) . "'";
}
if ($categoryFilter) {
    $sql .= " AND category = '" . $conn->real_escape_string($categoryFilter) . "'";
}
if ($sortOption) {
    if ($sortOption == 'price_asc') {
        $sql .= " ORDER BY price ASC";
    } elseif ($sortOption == 'price_desc') {
        $sql .= " ORDER BY price DESC";
    } elseif ($sortOption == 'date') {
        $sql .= " ORDER BY created_at DESC";
    }
}

$result = $conn->query($sql);

$items = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="sample.css" rel="stylesheet">
    <br><br>
    <title>Online Order - THE GALLERY Cafe</title>
    <style>
/* Item Card Styling */
.item-card {
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
}

.item-card:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    background-color: #f9f9f9; /* Light gray background on hover */
}

.item-card img {
    width: 100%;
    height: auto;
    display: block;
    transition: opacity 0.3s ease;
}

.item-card img:hover {
    opacity: 0.9;
}

.item-card .item-details {
    padding: 15px;
    transition: padding 0.3s ease;
}

.item-card .item-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin: 0;
    color: #333;
}

.item-card .item-description {
    color: #666;
    margin: 10px 0;
}

.item-card .item-price {
    font-size: 1.1rem;
    font-weight: 500;
    color: #007bff; /* Blue for price */
}

/* Cart Icon Styling */
.cart-icon {
    position: fixed;
    top: 15px;
    right: 15px;
    z-index: 1000;
    cursor: pointer;
    background-color: #007bff; /* Blue background */
    border: none;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
}

.cart-icon:hover {
    background-color: #0056b3; /* Darker blue on hover */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    transform: scale(1.1);
}

.cart-icon i {
    font-size: 24px;
    color: #fff;
    transition: transform 0.3s ease;
}

.cart-icon:hover i {
    transform: rotate(360deg);
}

/* Cart Dropdown Styling */
.cart-dropdown {
    position: fixed;
    top: 70px;
    right: 15px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    width: 320px;
    max-height: 500px;
    overflow-y: auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    display: none;
    z-index: 1000;
    transition: opacity 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
}

.cart-dropdown.active {
    display: block;
    opacity: 1;
    transform: translateY(0);
}

.cart-item {
    display: flex;
    justify-content: space-between;
    padding: 12px 15px;
    border-bottom: 1px solid #f5f5f5;
    transition: background-color 0.2s ease, transform 0.2s ease;
}

.cart-item:hover {
    background-color: #f0f8ff; /* Light blue on hover */
    transform: scale(1.02);
}

.cart-item:last-child {
    border-bottom: none;
}

.cart-item .item-title {
    font-weight: 500;
    color: #333;
}

.cart-item .item-price {
    font-weight: 500;
    color: #007bff; /* Blue for price */
}

.cart-total {
    padding: 15px;
    font-weight: bold;
    text-align: right;
    border-top: 1px solid #ddd;
    background-color: #f8f9fa;
    transition: background-color 0.3s ease;
}

.cart-total:hover {
    background-color: #e9ecef; /* Slightly darker on hover */
}
/* Filters Section */
.filters {
    margin-bottom: 20px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fafafa; /* Slightly off-white background */
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

.filters:hover {
    background-color: #fefbd8; /* Light yellow background on hover */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

/* Filter Elements */
.filter-item {
    margin-bottom: 10px;
    padding: 12px;
    border: 1px solid #f7c846; /* Light yellow border */
    border-radius: 6px;
    background-color: #ffffff; /* White background */
    transition: background-color 0.3s ease, border-color 0.3s ease;
}

.filter-item:hover {
    background-color: #fff8e1; /* Very light yellow background on hover */
    border-color: #f7c846; /* Light yellow border */
}

/* Filter Labels */
.filter-item label {
    display: block;
    font-weight: 500;
    margin-bottom: 6px;
    color: #f7c846; /* Yellow text color */
    transition: color 0.3s ease;
}

.filter-item label:hover {
    color: #f59c42; /* Darker yellow on hover */
}

/* Filter Select and Checkboxes */
.filter-item select, .filter-item input[type="checkbox"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 6px;
    background-color: #f9f9f9; /* Light gray background */
    transition: border-color 0.3s ease;
}

.filter-item select:focus, .filter-item input[type="checkbox"]:focus {
    border-color: #f7c846; /* Light yellow border on focus */
    outline: none;
    background-color: #fff; /* White background on focus */
}

/* Filter Button */
.filter-btn {
    display: inline-block;
    padding: 12px 24px;
    background-color: #f7c846; /* Yellow background */
    color: #000; /* Black text */
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.filter-btn:hover {
    background-color: #f59c42; /* Darker yellow on hover */
    color: #fff; /* White text on hover */
}


/* Cart Icon Styling */
.cart-icon {
    position: fixed;
    top: 80px; /* Adjust this value as needed based on your navbar height */
    right: 15px;
    z-index: 1000;
    cursor: pointer;
    background-color: #007bff; /* Blue background */
    border: none;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
}

.cart-icon:hover {
    background-color: #0056b3; /* Darker blue on hover */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    transform: scale(1.1);
}

.cart-icon i {
    font-size: 24px;
    color: #fff;
    transition: transform 0.3s ease;
}

.cart-icon:hover i {
    transform: rotate(360deg);
}

/* Cart Dropdown Styling */
.cart-dropdown {
    position: fixed;
    top: 135px; /* Adjust this value to align with the cart button */
    right: 15px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    width: 320px;
    max-height: 500px;
    overflow-y: auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    display: none;
    z-index: 1000;
    transition: opacity 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
}

.cart-dropdown.active {
    display: block;
    opacity: 1;
    transform: translateY(0);
}


    </style>
</head>
<body>
<?php include('navbar2.php'); ?>
<br><br>
    <div class="container">
        <style>
    /* Keyframes for animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateX(-100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes colorChange {
            0% {
                color: #ff4d4d; /* Bright Red */
            }
            50% {
                color: #cc0000; /* Dark Red */
            }
            100% {
                color: #ff4d4d; /* Bright Red */
            }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }

        @keyframes scaleUp {
            from {
                transform: scale(0.8);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Combined styles for the h1 element */
        h1 {
            font-family: 'Arial', sans-serif;
            color: #ff4d4d; /* Initial bright red color */
            text-align: center;
            font-size: 3rem; /* Adjusted font size */
            text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.5); /* Enhanced shadow for depth */
            margin-top: 50px; /* Space above the heading */
            animation: 
                fadeIn 2s ease-out, /* Fade in effect */
                bounce 2s ease infinite, /* Bounce effect */
                colorChange 3s ease-in-out infinite, /* Color changing effect */
                scaleUp 2s ease-out; /* Scale up effect */
        }

        /* Additional Styling for Enhancement */
        h1:hover {
            text-shadow: 3px 3px 12px rgba(255, 0, 0, 0.7); /* Glow effect on hover */
            transform: scale(1.05); /* Slightly enlarge on hover */
        }
    </style>
        <h1>Online Order - All Products</h1>

        <!-- Filters Section -->
        <div class="filters">
            <form method="GET" action="">
                <div class="row">
                    <div class="col-md-3">
                        <select name="country" class="form-select" onchange="this.form.submit()">
                            <option value="">Select Country</option>
                            <?php foreach ($countries as $country): ?>
                                <option value="<?= htmlspecialchars($country) ?>" <?= $countryFilter == $country ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($country) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-select" onchange="this.form.submit()">
                            <option value="">Select Category</option>
                            <option value="coffee" <?= $categoryFilter == 'coffee' ? 'selected' : '' ?>>Coffee</option>
                            <option value="ice cream" <?= $categoryFilter == 'ice cream' ? 'selected' : '' ?>>Ice Cream</option>
                            <option value="sweets" <?= $categoryFilter == 'sweets' ? 'selected' : '' ?>>Sweets</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="">Sort By</option>
                            <option value="price_asc" <?= $sortOption == 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
                            <option value="price_desc" <?= $sortOption == 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
                          
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <!-- Items display section -->
        <div id="items-display" class="row">
            <?php foreach ($items as $item): ?>
                <div class="item-card col-md-4">
                    <div class="card">
                        <img src="<?= htmlspecialchars($item['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['name']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($item['name']) ?></h5>
                            <p class="card-text">Price: $<?= number_format($item['price'], 2) ?></p>
                            <button class="btn btn-primary add-to-cart" data-id="<?= htmlspecialchars($item['id']) ?>" data-name="<?= htmlspecialchars($item['name']) ?>" data-price="<?= htmlspecialchars($item['price']) ?>">Add to Cart</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

       

        <!-- Shopping Cart Icon -->
        <div class="cart-icon" id="cart-icon">
            <i class="fas fa-shopping-cart"></i>
        </div>

        <!-- Cart Dropdown -->
        <div class="cart-dropdown" id="cart-dropdown">
            <div id="cart-items"></div>
            <div class="cart-total" id="cart-total">Total: $0.00</div>
            <button class="btn btn-success w-100" id="checkout-button">Checkout</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            let cart = [];

            // Show/hide cart dropdown
            $('#cart-icon').click(function() {
                $('#cart-dropdown').toggleClass('active');
            });

            // Add item to cart
            $(document).on('click', '.add-to-cart', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const price = parseFloat($(this).data('price'));
                
                const existingItem = cart.find(item => item.id === id);
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({ id, name, price, quantity: 1 });
                }

                updateCart();
            });

            // Update cart display
            function updateCart() {
                let cartItemsHtml = '';
                let total = 0;

                cart.forEach(item => {
                    cartItemsHtml += `<div class="cart-item">
                        <span>${item.name} x${item.quantity}</span>
                        <span>$${(item.price * item.quantity).toFixed(2)}</span>
                    </div>`;
                    total += item.price * item.quantity;
                });

                $('#cart-items').html(cartItemsHtml);
                $('#cart-total').text(`Total: $${total.toFixed(2)}`);
            }

            // Checkout button click
            $('#checkout-button').click(function() {
                if (cart.length === 0) {
                    alert('Your cart is empty!');
                    return;
                }

                // Redirect to checkout page with cart details
                window.location.href = `checkout.php?cart=${encodeURIComponent(JSON.stringify(cart))}`;
            });
        });
    </script>
</body>
</html>
