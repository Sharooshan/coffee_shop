<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="sample.css">
    <title>Product Grid</title>
        
    <script src="script.js" defer></script>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            padding: 20px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            width: 100%;
            max-width: 1200px; /* Adjust as needed */
        }

        .product-card {
            background-color: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .product-card .discount {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: red;
            color: white;
            padding: 5px;
            font-size: 12px;
            border-radius: 4px;
            transition: opacity 0.3s ease;
        }

        .product-card:hover .discount {
            opacity: 0.8;
        }

        .product-card img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: transform 0.3s ease;
        }

        .product-card:hover img {
            transform: scale(1.1);
        }

        .product-card .label {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: yellow;
            color: black;
            padding: 5px;
            font-size: 12px;
            border-radius: 4px;
            transition: opacity 0.3s ease;
        }

        .product-card:hover .label {
            opacity: 0.8;
        }

        .product-card h3 {
            font-size: 16px;
            margin: 10px 0;
        }

        .product-card select {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            transition: border-color 0.3s ease;
        }

        .product-card select:focus {
            border-color: red;
            outline: none;
        }

        .product-card .price {
            font-size: 18px;
            margin: 10px 0;
        }

        .product-card .price .old-price {
            text-decoration: line-through;
            color: grey;
            font-size: 14px;
        }

        .product-card .tax {
            font-size: 12px;
            color: grey;
        }

        .product-card .add-to-cart {
            background-color: red;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .product-card .add-to-cart:hover {
            background-color: darkred;
            transform: scale(1.05);
        }

        /* Additional styles */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .product-card {
            animation: fadeIn 1s ease-in-out;
        }
    </style>
</head>
<body>
<?php include('navbar2.php'); ?>
    <div class="container">
        <div class="product-grid">
            <!-- Product 1 -->
            <div class="product-card" data-name="Kotmale Butter Salted" data-price="715.00">
                <div class="discount">35.00% OFF</div>
                <img src="menu-item-3.jpg" alt="Kotmale Butter Salted">
                <span class="label">BUTTER</span>
                <h3>Kotmale Butter Salted</h3>
                <select class="quantity-select" onchange="updatePrice(this)">
                    <option value="200" data-price="715.00">200.00 g</option>
                    <option value="500" data-price="1700.00">500.00 g</option>
                </select>
                <p class="price">Rs. 715.00 <span class="old-price">MRP: Rs. 1100.00</span></p>
                <p class="tax">Inclusive of all taxes</p>
                <button class="add-to-cart" onclick="addToCart(this)">ADD</button>
            </div>
            <!-- Product 2 -->
            <div class="product-card" data-name="India Coffee Special" data-price="756.00">
                <div class="discount">35.00% OFF</div>
                <img src="menu-item-3.jpg" alt="India Coffee">
                <span class="label">COFFEE</span>
                <h3>India Coffee Special</h3>
                <select class="quantity-select" onchange="updatePrice(this)">
                    <option value="200" data-price="756.00">200.00 g</option>
                    <option value="500" data-price="8090.00">500.00 g</option>
                </select>
                <p class="price">Rs. 756.00 <span class="old-price">MRP: Rs. 1100.00</span></p>
                <p class="tax">Inclusive of all taxes</p>
                <button class="add-to-cart" onclick="addToCart(this)">ADD</button>
            </div>
            <!-- Product 3 -->
            <div class="product-card" data-name="India Coffee Special" data-price="756.00">
                <div class="discount">35.00% OFF</div>
                <img src="menu-item-3.jpg" alt="India Coffee">
                <span class="label">COFFEE</span>
                <h3>India Coffee Special</h3>
                <select class="quantity-select" onchange="updatePrice(this)">
                    <option value="200" data-price="756.00">200.00 g</option>
                    <option value="500" data-price="8090.00">500.00 g</option>
                </select>
                <p class="price">Rs. 756.00 <span class="old-price">MRP: Rs. 1100.00</span></p>
                <p class="tax">Inclusive of all taxes</p>
                <button class="add-to-cart" onclick="addToCart(this)">ADD</button>
            </div>
            <!-- Product 4 -->
            <div class="product-card" data-name="India Coffee Special" data-price="756.00">
                <div class="discount">35.00% OFF</div>
                <img src="menu-item-3.jpg" alt="India Coffee">
                <span class="label">COFFEE</span>
                <h3>India Coffee Special</h3>
                <select class="quantity-select" onchange="updatePrice(this)">
                    <option value="200" data-price="756.00">200.00 g</option>
                    <option value="500" data-price="8090.00">500.00 g</option>
                </select>
                <p class="price">Rs. 756.00 <span class="old-price">MRP: Rs. 1100.00</span></p>
                <p class="tax">Inclusive of all taxes</p>
                <button class="add-to-cart" onclick="addToCart(this)">ADD</button>
            </div>
            <!-- Product 5 -->
            <div class="product-card" data-name="India Coffee Special" data-price="756.00">
                <div class="discount">35.00% OFF</div>
                <img src="menu-item-3.jpg" alt="India Coffee">
                <span class="label">COFFEE</span>
                <h3>India Coffee Special</h3>
                <select class="quantity-select" onchange="updatePrice(this)">
                    <option value="200" data-price="756.00">200.00 g</option>
                    <option value="500" data-price="8090.00">500.00 g</option>
                </select>
                <p class="price">Rs. 756.00 <span class="old-price">MRP: Rs. 1100.00</span></p>
                <p class="tax">Inclusive of all taxes</p>
                <button class="add-to-cart" onclick="addToCart(this)">ADD</button>
            </div>
          
        </div>
    </div>
    <script>
        function updatePrice(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            const productCard = selectElement.closest('.product-card');
            productCard.querySelector('.price').innerHTML = `Rs. ${price} <span class="old-price">MRP: Rs. 1100.00</span>`;
        }

        function addToCart(buttonElement) {
            const productCard = buttonElement.closest('.product-card');
            const productName = productCard.getAttribute('data-name');
            const productPrice = productCard.getAttribute('data-price');
            const quantitySelect = productCard.querySelector('.quantity-select');
            const quantity = quantitySelect.value;

            // Here you can handle the addition of the product to the cart
            console.log(`Added ${quantity} of ${productName} to cart at Rs. ${productPrice} each.`);
        }
    </script>
</body>
</html>
