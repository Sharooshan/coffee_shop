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

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST['customer_name'];
    $contact_number = $_POST['contact_number'];
    $reservation_date = $_POST['reservation_date'];
    $reservation_time = $_POST['reservation_time'];
    $num_guests = $_POST['num_guests'];
    $table_number = $_POST['table_number'];
    $parking_space = $_POST['parking_space'];
    $user_id = $_SESSION['user_id'];
    $user_email = $_SESSION['user_email'];

    if (!preg_match("/^[a-zA-Z ]*$/", $customer_name)) {
        $error_message = "Customer name should not contain numbers.";
    } elseif (!preg_match("/^[0-9]{8,12}$/", $contact_number)) {
        $error_message = "Contact number must be between 8 and 12 digits.";
    }  else {
        $sql = "INSERT INTO reservations (user_id, user_email, customer_name, contact_number, reservation_date, reservation_time, num_guests, table_number, parking_space, status)
                VALUES ('$user_id', '$user_email', '$customer_name', '$contact_number', '$reservation_date', '$reservation_time', '$num_guests', '$table_number', '$parking_space', 'pending')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Reservation made successfully! <a href='view_reservations.php'>View your reservations</a>";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Poppins:wght@400;600&display=swap" rel="stylesheet">

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
/* Button Styling */
.btn-reservation {
    background: linear-gradient(to right, #C8102E, #FF6F61);
    border: none;
    color: #fff;
    text-decoration: none;
    border-radius: 12px;
    display: inline-block;
    font-size: 1.2rem;
    font-weight: bold;
    padding: 14px 35px;
    transition: all 0.4s ease;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    animation: pulse 2s infinite;
}

.btn-reservation:hover {
    background: linear-gradient(to right, #FF6F61, #C8102E);
    transform: translateY(-6px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
}

.btn-reservation:active {
    background: linear-gradient(to right, #C8102E, #FF6F61);
    transform: translateY(2px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
}

/* Improved Input Field Styling */
input.form-control, select.form-control {
    border-radius: 12px;
    border: 1px solid #ddd;
    box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

input.form-control:focus, select.form-control:focus {
    border-color: #C8102E;
    box-shadow: 0 0 0 0.25rem rgba(200, 16, 46, 0.25);
}

/* Heading Styles */
h1, h2 {
    font-family: 'Poppins', sans-serif;
    text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
    animation: slideIn 1.5s ease-out;
}

/* Alert Styling */
.alert {
    border-radius: 12px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

/* Add additional animations for other elements as needed */


    </style>
   
    <title>Reservation - THE GALLERY Cafe</title>
    
   
</head>

<body>
<?php include('navbar2.php'); ?>


    <br><br>

    <div class="container mt-5">

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
        <h1>Reservation Form</h1>
        <?php
        if (isset($success_message)) {
            echo "<div class='alert alert-success'>$success_message</div>";
        } elseif (isset($error_message)) {
            echo "<div class='alert alert-danger'>$error_message</div>";
        }
        ?>
        <form action="reservation.php" method="post">
            <div class="mb-3">
                <label for="customer_name" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
            </div>
            <div class="mb-3">
                <label for="contact_number" class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number" required>
            </div>
            <div class="mb-3">
                <label for="reservation_date" class="form-label">Reservation Date</label>
                <input type="date" class="form-control" id="reservation_date" name="reservation_date" required>
            </div>
            <div class="mb-3">
                <label for="reservation_time" class="form-label">Reservation Time</label>
                <input type="time" class="form-control" id="reservation_time" name="reservation_time" required>
            </div>
            <div class="mb-3">
                <label for="num_guests" class="form-label">Number of Guests</label>
                <input type="number" class="form-control" id="num_guests" name="num_guests" required>
            </div>
            <div class="mb-3">
                <label for="table_number" class="form-label">Table Number</label>
                <select class="form-control" id="table_number" name="table_number" required>
                    <option value="">Select Table Number</option>
                    <option value="1" class="guests-1-2">1</option>
                    <option value="2" class="guests-1-2">2</option>
                    <option value="3" class="guests-3-4">3</option>
                    <option value="4" class="guests-3-4">4</option>
                    <option value="5" class="guests-4-10">5</option>
                    <option value="6" class="guests-4-10">6</option>
                    <option value="7" class="guests-4-10">7</option>
                    <option value="8" class="guests-4-10">8</option>
                    <option value="9" class="guests-4-10">9</option>
                    <option value="10" class="guests-4-10">10</option>
                    <option value="11" class="guests-4-10">11</option>
                    <option value="12" class="guests-4-10">12</option>
                    <option value="13" class="guests-4-10">13</option>
                    <option value="14" class="guests-4-10">14</option>
                    <option value="15" class="guests-4-10">15</option>
                    <option value="16" class="guests-4-10">16</option>
                    <option value="17" class="guests-4-10">17</option>
                    <option value="18" class="guests-4-10">18</option>
                    <option value="19" class="guests-4-10">19</option>
                    <option value="20" class="guests-4-10">20</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="parking_space" class="form-label">Need Parking Space?</label>
                <select class="form-control" id="parking_space" name="parking_space" required>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit Reservation</button>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>


        document.getElementById('num_guests').addEventListener('input', function() {
            var numGuests = parseInt(this.value);
            var tableOptions = document.getElementById('table_number').options;

            

            for (var i = 0; i < tableOptions.length; i++) {
                var option = tableOptions[i];
                if (numGuests >= 1 && numGuests <= 2) {
                    if (option.classList.contains('guests-1-2')) {
                        option.style.display = 'block';
                    } else {
                        option.style.display = 'none';
                    }
                } else if (numGuests >= 3 && numGuests <= 4) {
                    if (option.classList.contains('guests-3-4')) {
                        option.style.display = 'block';
                    } else {
                        option.style.display = 'none';
                    }
                } else if (numGuests >= 5 && numGuests <= 10) {
                    if (option.classList.contains('guests-5-10')) {
                        option.style.display = 'block';
                    } else {
                        option.style.display = 'none';
                    }
                } else {
                    option.style.display = 'none';
                }
            }
        });

  
    </script>
</body>

</html>
