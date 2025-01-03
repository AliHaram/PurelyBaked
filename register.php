<?php
// Start the session
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = "";     // Default password for XAMPP
$dbname = "events_db"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize error message
$error_message = "";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate passwords
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the data into the database
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            // Set success message and redirect to login page
            $_SESSION['success_message'] = "Registration successful! Please log in.";
            header("Location: login.php");
            exit;
        } else {
            $error_message = "Something went wrong! Please try again.";
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Open Sans", sans-serif;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: rgba(0, 0, 0, 0.5);
        }

        video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -2;
        }

        .wrapper {
            width: 400px;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #fff;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        }

        .input-field {
            position: relative;
            margin: 20px 0;
            border-bottom: 2px solid #ccc;
        }

        .input-field label {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.7);
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .input-field input {
            width: 100%;
            padding: 10px 0;
            background: none;
            border: none;
            outline: none;
            color: #fff;
            font-size: 1rem;
        }

        .input-field input:focus ~ label,
        .input-field input:valid ~ label {
            top: -10px;
            font-size: 0.8rem;
            color: #fff;
        }

        button {
            margin-top: 10px;
            padding: 10px;
            background: #fff;
            color: #003d80;
            font-size: 1rem;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease, color 0.3s ease;
        }

        button:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .banner {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            font-size: 0.9rem;
        }

        .banner.success {
            background: #4CAF50;
            color: #fff;
        }

        .banner.error {
            background: #F44336;
            color: #fff;
        }
    </style>
</head>

<body>
    <video autoplay muted loop playsinline>
        <source src="loginVid.mp4" type="video/mp4">
        Your browser does not support the video.
    </video>
    <div class="wrapper">
        <!-- Display error message if exists -->
        <?php if (!empty($error_message)): ?>
            <div class="banner error"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <h2>Signup</h2>
            <div class="input-field">
                <input type="text" name="name" required>
                <label>Enter your name</label>
            </div>
            <div class="input-field">
                <input type="email" name="email" required>
                <label>Enter your email</label>
            </div>
            <div class="input-field">
                <input type="password" name="password" required>
                <label>Create your password</label>
            </div>
            <div class="input-field">
                <input type="password" name="confirm_password" required>
                <label>Re-enter your password</label>
            </div>
            <button type="submit">Sign Up</button>
        </form>
    </div>
</body>

</html>
