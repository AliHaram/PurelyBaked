<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'You must be logged in to register for events.'
    ]);
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "events_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database connection failed.'
    ]);
    exit;
}

// Get the user ID and event ID
$user_id = $_SESSION['user_id'];
$event_id = intval($_GET['event_id']);

// Check if the user is already registered for the event
$sql_check = "SELECT * FROM registrations WHERE user_id = ? AND event_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $user_id, $event_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'You are already registered for this event.'
    ]);
    exit;
}

// Register the user for the event
$sql_register = "INSERT INTO registrations (user_id, event_id) VALUES (?, ?)";
$stmt_register = $conn->prepare($sql_register);
$stmt_register->bind_param("ii", $user_id, $event_id);

if ($stmt_register->execute()) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Event registration successful!'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Event registration failed. Please try again later.'
    ]);
}

$conn->close();
?>
