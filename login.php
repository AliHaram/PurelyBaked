<?php
// Start the session
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = "";     // Default password for XAMPP
$dbname = "events_db"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize messages
$success_message = "";
$error_message = "";

// Check for a success message from the registration page
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Check if the email exists in the database
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the user record
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password matches; start a session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name']; // Store the user's name
            $_SESSION['email'] = $user['email'];
            $redirectPage = isset($_GET['redirect']) ? $_GET['redirect'] : 'dashboard.php';
header("Location: $redirectPage");
            exit;
        } else {
            // Password doesn't match
            $error_message = "Invalid email or password. Please try again.";
        }
    } else {
        // Email not found
        $error_message = "Invalid email or password. Please try again.";
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
    <title>Login</title>
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

        .error-message {
            color: red;
            font-size: 0.9rem;
            margin-top: -10px;
            margin-bottom: 10px;
        }

        .success-message {
            color: green;
            font-size: 0.9rem;
            margin-top: -10px;
            margin-bottom: 10px;
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

        #signup {
            color: white;
        }

        #signupButton {
            color: #e6b800;
        }
    </style>
</head>

<body>
    <video autoplay muted loop playsinline>
        <source src="loginVid.mp4" type="video/mp4">
        Your browser does not support the video.
    </video>
    <div class="wrapper">
        <form action="login.php" method="POST">
            <h2>Login</h2>

            <!-- Display success message dynamically -->
            <?php if (!empty($success_message)): ?>
                <p class="success-message"><?php echo htmlspecialchars($success_message); ?></p>
            <?php endif; ?>

            <!-- Display error message dynamically -->
            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>

            <div class="input-field">
                <input type="email" name="email" required>
                <label>Enter your email</label>
            </div>
            <div class="input-field">
                <input type="password" name="password" required>
                <label>Enter your password</label>
            </div>
            <label id="signup">Don't have an account? <a id="signupButton" href="register.php">Sign Up</a></label>

            <button type="submit">Log In</button>
        </form>
    </div>
</body>

</html>
