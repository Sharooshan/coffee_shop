<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <title>Order Details - THE GALLERY Cafe</title>
</head>
<body>
<div class="container">
    <h1>Order Details</h1>
    <!-- Order List Section -->
    <div id="order-list">
        <!-- Order details will be dynamically loaded here -->
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Function to load order details from server
    function loadOrderDetails() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_orders.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send();

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const orders = JSON.parse(xhr.responseText);
                    displayOrders(orders);
                } else {
                    console.error('Failed to load orders.');
                }
            }
        };
    }

    // Function to display order details on the page
    function displayOrders(orders) {
        const orderListDiv = document.getElementById('order-list');
        orderListDiv.innerHTML = ''; // Clear previous orders

        orders.forEach(order => {
            const orderItem = document.createElement('div');
            orderItem.innerHTML = `
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">${order.order_id}</h5>
                        <p class="card-text">Status: ${order.status}</p>
                        <ul class="list-group list-group-flush">
                            ${order.items.map(item => `<li class="list-group-item">${item.name} - $${item.price.toFixed(2)}</li>`).join('')}
                        </ul>
                    </div>
                </div>
            `;
            orderListDiv.appendChild(orderItem);
        });
    }

    // Load order details when the page is loaded
    window.onload = function () {
        loadOrderDetails();
    };
</script>
</body>
</html>
