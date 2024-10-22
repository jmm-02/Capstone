<?php
session_start();

// Check if language preference is received via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['language'])) {
    $languagePreference = $_POST['language'];

    // Ensure the selected value is valid before updating
    $validLanguages = ['english', 'tagalog'];

    if (in_array($languagePreference, $validLanguages)) {
        // Update session variable with selected language
        $_SESSION['language'] = $languagePreference;
        // Return success response
        echo json_encode(['success' => true]);
        exit; // Exit script
    }
}

// Return error response if language preference is not valid
echo json_encode(['success' => false, 'message' => 'Invalid language preference']);
?>
