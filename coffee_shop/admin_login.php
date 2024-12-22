<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="admin.css" rel="stylesheet">
    <title>Admin Login - Coffee Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   
   <style>
    /* General Styles */
body {
    background-color: #f8f9fa;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    font-family: Arial, sans-serif;
    color: #333;
}

/* Container */
.container {
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

.container:hover {
    transform: scale(1.05);
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
}

/* Headers */
.container h2 {
    margin-bottom: 20px;
    text-align: center;
    color: #000;
}

/* Form Controls */
.form-control {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    transition: all 0.3s ease-in-out;
}

.form-control:focus {
    box-shadow: 0 0 5px rgba(255, 193, 7, 0.5);
    border-color: #ffc107;
}

/* Buttons */
.btn {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    user-select: none;
    border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    position: relative;
    overflow: hidden;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 300%;
    height: 300%;
    background: rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease-in-out;
    transform: rotate(45deg);
}

.btn:hover::before {
    left: -50%;
}

.btn-primary {
    background-color: #dc3545;
    border-color: #dc3545;
    color: #fff;
}

.btn-primary:hover {
    background-color: #c82333;
    border-color: #bd2130;
}

.btn-primary:focus {
    box-shadow: 0 0 5px rgba(220, 53, 69, 0.5);
}

.btn-primary:active {
    background-color: #bd2130;
    border-color: #b21f2d;
}

.btn-yellow {
    background-color: #ffc107;
    border-color: #ffc107;
    color: #000;
}

.btn-yellow:hover {
    background-color: #e0a800;
    border-color: #d39e00;
}

.btn-yellow:focus {
    box-shadow: 0 0 5px rgba(255, 193, 7, 0.5);
}

.btn-yellow:active {
    background-color: #d39e00;
    border-color: #c69500;
}

.btn-black {
    background-color: #000;
    border-color: #000;
    color: #fff;
}

.btn-black:hover {
    background-color: #333;
    border-color: #333;
}

.btn-black:focus {
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
}

.btn-black:active {
    background-color: #222;
    border-color: #222;
}

/* Links */
.form-text {
    display: block;
    margin-top: -15px;
    margin-bottom: 20px;
    color: #6c757d;
    transition: color 0.3s ease-in-out;
}

.form-text:hover {
    color: #dc3545;
}

/* Sign-in, Sign-up */
.signup-container, .signin-container {
    max-width: 400px;
    margin: 50px auto;
}

/* Reservation Form */
.reservation-form {
    max-width: 600px;
    margin: 50px auto;
}

/* Edit Order Form */
.edit-order-form {
    max-width: 800px;
    margin: 50px auto;
}

/* Tables */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
}

table th, table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

table th {
    background-color: #000;
    color: white;
}

/* Status Labels */
.status-accepted {
    color: #28a745;
    font-weight: bold;
}

.status-rejected {
    color: #dc3545;
    font-weight: bold;
}

/* Footer */
.footer {
    background-color: #000;
    color: #fff;
    text-align: center;
    padding: 10px;
    position: fixed;
    width: 100%;
    bottom: 0;
}

   </style>
</head>
<body>
    <div class="container">
        <div class="signin-container">
            <h2>Admin/Staff Sign In</h2>
            <form action="admin_login_process.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
              
                <button type="submit" class="btn btn-primary w-100">Sign In</button>
            </form>
            
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
