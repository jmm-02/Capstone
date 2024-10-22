<?php
session_start();
include 'connection.php';
$userId = $_SESSION['user_id'];

// Initialize variables
$message = '';
$error = '';
$usertype = $_SESSION['user_type'];

$isFirstTimeToAddSecurity = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['security_settings'])) {
    // Get security question values
    $question1 = isset($_POST['question1']) ? $_POST['question1'] : '';
    $answer1 = isset($_POST['answer1']) ? $_POST['answer1'] : '';
    $question2 = isset($_POST['question2']) ? $_POST['question2'] : '';
    $answer2 = isset($_POST['answer2']) ? $_POST['answer2'] : '';
    $question3 = isset($_POST['question3']) ? $_POST['question3'] : '';
    $answer3 = isset($_POST['answer3']) ? $_POST['answer3'] : '';

    // Check if security answers are provided
    $securityAnswersProvided = !empty($answer1) || !empty($answer2) || !empty($answer3);

    // Ensure all security fields are filled or skipped
    if (!$securityAnswersProvided) {
        $error = "Please fill all security question fields or leave them empty to keep the current password.";
    } else {
        // Check if a row exists for the user in the security table
        $checkSecurityStmt = $conn->prepare("SELECT * FROM security WHERE user_id = :user_id");
        $checkSecurityStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $checkSecurityStmt->execute();
        $existingSecurity = $checkSecurityStmt->fetch(PDO::FETCH_ASSOC);

        // Check if no existing row, insert a new row for the user in the security table
        if (!$existingSecurity) {
            $insertSecurityStmt = $conn->prepare("INSERT INTO security (user_id, question1, answer1, question2, answer2, question3, answer3) VALUES (:user_id, :question1, :answer1, :question2, :answer2, :question3, :answer3)");
            $insertSecurityStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

            $isFirstTimeToAddSecurity = true;
        } else {
            // Update security questions and answers for an existing row
            $insertSecurityStmt = $conn->prepare("UPDATE security SET question1 = :question1, answer1 = :answer1, question2 = :question2, answer2 = :answer2, question3 = :question3, answer3 = :answer3 WHERE user_id = :user_id");
            $insertSecurityStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

            $isFirstTimeToAddSecurity = false;
        }

        // Bind parameters and execute query
        $insertSecurityStmt->bindParam(':question1', $question1, PDO::PARAM_STR);
        $insertSecurityStmt->bindParam(':answer1', password_hash($answer1, PASSWORD_BCRYPT), PDO::PARAM_STR);
        $insertSecurityStmt->bindParam(':question2', $question2, PDO::PARAM_STR);
        $insertSecurityStmt->bindParam(':answer2', password_hash($answer2, PASSWORD_BCRYPT), PDO::PARAM_STR);
        $insertSecurityStmt->bindParam(':question3', $question3, PDO::PARAM_STR);
        $insertSecurityStmt->bindParam(':answer3', password_hash($answer3, PASSWORD_BCRYPT), PDO::PARAM_STR);

        if ($insertSecurityStmt->execute()) {
            $message = $existingSecurity ? "Security Questions updated successfully." : "Security Questions added successfully.";
        } else {
            $error = $existingSecurity ? "Failed to update Security Questions. Please try again." : "Failed to add Security Questions. Please try again.";
        }
    }

    switch ($usertype) {
        case "user":
            $isFirstTimeToAddSecurity ? header('Location: user_dashboard.php') : header('Location: user_setting.php');
            break;
        case "superadmin":
            $isFirstTimeToAddSecurity ? header('Location: sa_dashboard.php') : header('Location: sa_setting.php');
            break;
        case "admin":
            $isFirstTimeToAddSecurity ? header('Location: admin_dashboard.php') : header('Location: admin_setting.php');
            break;
    }

    exit();
}
