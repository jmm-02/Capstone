<?php
include 'connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['profile_pic'])) {
    $userId = $_SESSION['user_id'];
    $uploadDir = 'profile_pictures/';

    // Check if the user already has a profile picture
    $getUserStmt = $conn->prepare("SELECT profile_picture FROM users WHERE id = :user_id");
    $getUserStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $getUserStmt->execute();
    $user = $getUserStmt->fetch(PDO::FETCH_ASSOC);
    $oldProfilePic = $user['profile_picture'];

    // Get the uploaded file details
    $file = $_FILES['profile_pic'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];

    // Check file type
    if ($file['type'] == 'image/jpeg' || $file['type'] == 'image/png') {
        // Remove the old profile picture if it exists
        if (!empty($oldProfilePic)) {
            $oldFilePath = $uploadDir . $oldProfilePic;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        // Move the uploaded file to the profile pictures directory
        $uniqueFileName = $userId . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
        $destination = $uploadDir . $uniqueFileName;

        if (move_uploaded_file($fileTmpName, $destination)) {
            // Update the 'users' table with the file path/reference for this user
            $updateStmt = $conn->prepare("UPDATE users SET profile_picture = :profile_pic WHERE id = :user_id");
            $updateStmt->bindParam(':profile_pic', $uniqueFileName, PDO::PARAM_STR);
            $updateStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            if ($updateStmt->execute()) {
                // Consider returning a JSON response indicating success
                $response = [
                    'success' => true,
                    'message' => 'Profile picture uploaded and updated successfully.'
                ];
            } else {
                // Consider returning a JSON response indicating failure
                $response = [
                    'success' => false,
                    'message' => 'Failed to update profile picture in the database.'
                ];
            }
        } else {
            // Consider returning a JSON response indicating failure
            $response = [
                'success' => false,
                'message' => 'Failed to move uploaded file to the designated folder.'
            ];
        }
    } else {
        // Consider returning a JSON response indicating file type error
        $response = [
            'success' => false,
            'message' => 'File type should be JPG or PNG.'
        ];
    }
} else {
    // Consider returning a JSON response indicating no file uploaded or invalid request
    $response = [
        'success' => false,
        'message' => 'No file uploaded or invalid request.'
    ];
}
?>
