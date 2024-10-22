<?php 
session_start();
include 'connection.php';
$userId = $_SESSION['user_id'];

// Initialize variables
$message = '';
$error = '';

$usertype = $_SESSION['user_type'];

// Process form submissions for updating user data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $newFirstName = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $newLastName = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $newContactNumber = isset($_POST['contact_number']) ? $_POST['contact_number'] : '';
    $newEmail = isset($_POST['email']) ? $_POST['email'] : '';
    $newUsername = isset($_POST['username']) ? $_POST['username'] : '';

    // Check if the email is the same as the current user's email
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($newEmail !== $user['email']) {
        // Check if the new email already exists in the database
        $checkEmailStmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE email = :email");
        $checkEmailStmt->bindParam(':email', $newEmail, PDO::PARAM_STR);
        $checkEmailStmt->execute();
        $emailExists = $checkEmailStmt->fetch(PDO::FETCH_ASSOC)['count'];

        if ($emailExists > 0) {
            $error = "Email already in use. Please choose another one.";
        }
    }

    // Check for password length
    if (!empty($_POST['new_password']) && strlen($_POST['new_password']) < 8) {
        $error = "Password should be at least 8 characters long.";
    }

    if (empty($error)) {
        // No errors, proceed with updating the user data
        if (!empty($_POST['new_password'])) {
            $newPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
            $updateStmt = $conn->prepare("UPDATE users SET username = :username, first_name = :first_name, last_name = :last_name, contact_number = :contact_number, email = :email, password = :password WHERE id = :user_id");
            $updateStmt->bindParam(':password', $newPassword, PDO::PARAM_STR);
        } else {
            $updateStmt = $conn->prepare("UPDATE users SET username = :username, first_name = :first_name, last_name = :last_name, contact_number = :contact_number, email = :email WHERE id = :user_id");
        }

        $updateStmt->bindParam(':username', $newUsername, PDO::PARAM_STR);
        $updateStmt->bindParam(':first_name', $newFirstName, PDO::PARAM_STR);
        $updateStmt->bindParam(':last_name', $newLastName, PDO::PARAM_STR);
        $updateStmt->bindParam(':contact_number', $newContactNumber, PDO::PARAM_STR);
        $updateStmt->bindParam(':email', $newEmail, PDO::PARAM_STR);
        $updateStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        if ($updateStmt->execute()) {

            if ($usertype === "user") {
         header('Location: user_setting.php');
         exit();
}
        elseif ($usertype === "superadmin") {
    header('Location: sa_setting.php');
    exit();
        }
        elseif($usertype === "admin"){
      header('Location: admin_setting.php');
    exit();
            
        }

        } else {
            // Update failed
            $error = "Failed to update user data. Please try again.";
            // Handle the error, redirect or display error message
        }
    }
}
?>
