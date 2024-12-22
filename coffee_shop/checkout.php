<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="sample.css" rel="stylesheet">
    <style>
        /* Keyframes for animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-20px); }
            60% { transform: translateY(-10px); }
        }

        @keyframes scaleUp {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
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
                fadeIn 1.5s ease-out, /* Fade in effect */
                bounce 2s ease infinite, /* Bounce effect */
                scaleUp 1.5s ease-out; /* Scale up effect */
        }

        /* Additional Styling for Enhancement */
        h1:hover {
            text-shadow: 3px 3px 12px rgba(255, 0, 0, 0.7); /* Glow effect on hover */
            transform: scale(1.05); /* Slightly enlarge on hover */
        }

        /* Container Styling */
        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            background-color: #fff;
            animation: fadeIn 1.5s ease-out;
        }

        /* Form Control Styling */
        .form-control, .form-select, .form-textarea {
            border-radius: 0.5rem;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #ff4d4d;
            box-shadow: 0 0 8px rgba(255, 77, 77, 0.5);
        }

        .btn-primary {
            background-color: #ff4d4d;
            border-color: #ff4d4d;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #cc0000;
            border-color: #cc0000;
        }

        /* Additional Styles for Feedback and Address Textareas */
        #feedback, #address {
            resize: vertical; /* Allow vertical resizing */
        }
    </style>
    <title>Checkout</title>
</head>
<body>
    <div class="container">
        <h1>Checkout</h1>
        <form method="POST" action="process_checkout.php">
            <div class="mb-3">
                <label for="delivery-option" class="form-label">Choose Delivery Option</label>
                <select id="delivery-option" name="delivery_option" class="form-select" required>
                    <option value="delivery">Online Home Delivery</option>
                    <option value="reservation">Booking with Reservation</option>
                </select>
            </div>
            <input type="hidden" name="cart" value="<?= htmlspecialchars($_GET['cart'] ?? '') ?>">
            <div id="delivery-details" class="d-none">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="mobile" class="form-label">Mobile Number</label>
                    <input type="text" id="mobile" name="mobile" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea id="address" name="address" class="form-control" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="payment-method" class="form-label">Payment Method</label>
                    <select id="payment-method" name="payment_method" class="form-select">
                        <option value="online">Online</option>
                        <option value="onhand">On-Hand</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="feedback" class="form-label">Feedback</label>
                    <textarea id="feedback" name="feedback" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Proceed</button>
        </form>
    </div>
    <script>
        document.getElementById('delivery-option').addEventListener('change', function() {
            const deliveryDetails = document.getElementById('delivery-details');
            if (this.value === 'delivery') {
                deliveryDetails.classList.remove('d-none');
            } else {
                deliveryDetails.classList.add('d-none');
            }
        });
    </script>
</body>
</html>
