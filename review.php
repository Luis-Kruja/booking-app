<?php
session_start();
include 'config/db_connection.php'; // Ensure this file contains the DB connection logic
global $db;
// Check if the user is logged in
if (!isset($_SESSION['email']) || !isset($_SESSION['user_id'])) {
    echo "You must be logged in to leave a review.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apartmentId = $_POST['apartment_id'];
    $reviewText = trim($_POST['review']);
    $userId = $_SESSION['user_id']; // Assuming `user_id` is stored in the session after login

    if (empty($reviewText)) {
        echo "Review cannot be empty.";
        exit;
    }

    // Insert review into the database
    $query = "INSERT INTO reviews (apartment_id, user_id, review) VALUES (?, ?, ?)";

    if ($stmt = $db->prepare($query)) {
        $stmt->bind_param("iis", $apartmentId, $userId, $reviewText);
        if ($stmt->execute()) {
            echo "Thank you for your review!";
        } else {
            echo "Failed to submit the review. Please try again.";
        }
        $stmt->close();
    } else {
        echo "Error preparing the query.";
    }
} else {
    echo "Invalid request.";
}
?>
