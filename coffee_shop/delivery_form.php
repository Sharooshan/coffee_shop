<?php
// delivery_form.php
session_start();

// Check if the user is logged in, if not then redirect to the sign-in page
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="sample.css" rel="stylesheet">
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
    </style><br><br>
    <title>Online Delivery Form</title>
</head>
<body>
<?php include('navbar2.php'); ?>
    <div class="container">
        <h1>Online Home Delivery</h1>
        <form method="POST" action="save_delivery.php">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile Number</label>
                <input type="text" id="mobile" name="mobile" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="payment-method" class="form-label">Payment Method</label>
                <select id="payment-method" name="payment_method" class="form-select" required>
                    <option value="online">Online</option>
                    <option value="onhand">On-Hand</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="feedback" class="form-label">Feedback</label>
                <textarea id="feedback" name="feedback" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        
    </div>
    
  
</body>
</html>
