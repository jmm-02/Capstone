<?php
// Fetch user data based on the logged-in user's ID
$userId = $_SESSION['user_id'];

// Initialize variables
$message = '';
$error = '';

// Process form submissions for updating user data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $newFirstName = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $newLastName = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $newContactNumber = isset($_POST['contact_number']) ? $_POST['contact_number'] : '';
    $newEmail = isset($_POST['email']) ? $_POST['email'] : '';
    $newUsername = isset($_POST['username']) ? $_POST['username'] : '';

    // Check if the email is the same as the current user's email

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
            // Update security questions and answers
            $updateSecurityStmt = $conn->prepare("UPDATE security SET question1 = :question1, answer1 = :answer1, question2 = :question2, answer2 = :answer2, question3 = :question3, answer3 = :answer3 WHERE user_id = :user_id");
            $updateSecurityStmt->bindParam(':question1', $_POST['question1'], PDO::PARAM_STR);
            $updateSecurityStmt->bindParam(':answer1', password_hash($_POST['answer1'], PASSWORD_BCRYPT), PDO::PARAM_STR);
            $updateSecurityStmt->bindParam(':question2', $_POST['question2'], PDO::PARAM_STR);
            $updateSecurityStmt->bindParam(':answer2', password_hash($_POST['answer2'], PASSWORD_BCRYPT), PDO::PARAM_STR);
            $updateSecurityStmt->bindParam(':question3', $_POST['question3'], PDO::PARAM_STR);
            $updateSecurityStmt->bindParam(':answer3', password_hash($_POST['answer3'], PASSWORD_BCRYPT), PDO::PARAM_STR);
            $updateSecurityStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $updateSecurityStmt->execute();

            // Redirect back to the user settings page after successful update
            $message = "Updated Successfully.";
            // Fetch updated user data after the successful update
            $updatedStmt = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
            $updatedStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $updatedStmt->execute();
            $user = $updatedStmt->fetch(PDO::FETCH_ASSOC);
        } else {
            // Handle the case where the update fails
            $error = "Update failed. Please try again.";
        }
    } elseif (isset($_POST['security_settings'])) {
        // Check if security answers are provided
        $securityAnswersProvided = isset($_POST['answer1']) && isset($_POST['answer2']) && isset($_POST['answer3']);

        // Ensure all security fields are filled
        if (!$securityAnswersProvided) {
            $error = "Please fill all security question fields.";
        } else {
            $question1 = isset($_POST['question1']) ? $_POST['question1'] : '';
            $answer1 = isset($_POST['answer1']) ? $_POST['answer1'] : '';
            $question2 = isset($_POST['question2']) ? $_POST['question2'] : '';
            $answer2 = isset($_POST['answer2']) ? $_POST['answer2'] : '';
            $question3 = isset($_POST['question3']) ? $_POST['question3'] : '';
            $answer3 = isset($_POST['answer3']) ? $_POST['answer3'] : '';


            // Check if a row exists for the user in the security table
            $checkSecurityStmt = $conn->prepare("SELECT * FROM security WHERE user_id = :user_id");
            $checkSecurityStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $checkSecurityStmt->execute();
            $existingSecurity = $checkSecurityStmt->fetch(PDO::FETCH_ASSOC);

            if (!$existingSecurity) {
                // If no existing row, insert a new row for the user in the security table
                $insertSecurityStmt = $conn->prepare("INSERT INTO security (user_id, question1, answer1, question2, answer2, question3, answer3) VALUES (:user_id, :question1, :answer1, :question2, :answer2, :question3, :answer3)");
                $insertSecurityStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $insertSecurityStmt->bindParam(':question1', $question1, PDO::PARAM_STR);
                $insertSecurityStmt->bindParam(':answer1', password_hash($answer1, PASSWORD_BCRYPT), PDO::PARAM_STR);
                $insertSecurityStmt->bindParam(':question2', $question2, PDO::PARAM_STR);
                $insertSecurityStmt->bindParam(':answer2', password_hash($answer2, PASSWORD_BCRYPT), PDO::PARAM_STR);
                $insertSecurityStmt->bindParam(':question3', $question3, PDO::PARAM_STR);
                $insertSecurityStmt->bindParam(':answer3', password_hash($answer3, PASSWORD_BCRYPT), PDO::PARAM_STR);

                if ($insertSecurityStmt->execute()) {
                    $message = "Security Questions added successfully.";
                } else {
                    $error = "Failed to add Security Questions. Please try again.";
                }
            } else {
                // Update security questions and answers for an existing row
                $updateSecurityStmt = $conn->prepare("UPDATE security SET question1 = :question1, answer1 = :answer1, question2 = :question2, answer2 = :answer2, question3 = :question3, answer3 = :answer3 WHERE user_id = :user_id");
                $updateSecurityStmt->bindParam(':question1', $question1, PDO::PARAM_STR);
                $updateSecurityStmt->bindParam(':answer1', password_hash($answer1, PASSWORD_BCRYPT), PDO::PARAM_STR);
                $updateSecurityStmt->bindParam(':question2', $question2, PDO::PARAM_STR);
                $updateSecurityStmt->bindParam(':answer2', password_hash($answer2, PASSWORD_BCRYPT), PDO::PARAM_STR);
                $updateSecurityStmt->bindParam(':question3', $question3, PDO::PARAM_STR);
                $updateSecurityStmt->bindParam(':answer3', password_hash($answer3, PASSWORD_BCRYPT), PDO::PARAM_STR);
                $updateSecurityStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

                if ($updateSecurityStmt->execute()) {
                    $message = "Security Questions updated successfully.";
                } else {
                    $error = "Failed to update Security Questions. Please try again.";
                }
            }
        }
    }
}

?>