<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    echo json_encode([
        'logged_in' => true,
        'user_id' => $_SESSION['user_id'], 
        'user_name' => $_SESSION['user_name'] ?? null
    ]);
} else {
    echo json_encode(['logged_in' => false]);
}
?>
