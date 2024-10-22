<?php
session_start();
include 'connection.php';

// Check if the user is a superadmin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'superadmin') {
    header("Location: login.php");
    exit;
}

// Check if the admin user ID is provided in the URL
if (isset($_GET['admin_id'])) {
    $adminId = $_GET['admin_id'];

    // Fetch admin user data based on the provided ID
    $stmt = $conn->prepare("SELECT u.id, u.municipality_id, u.first_name, u.last_name, u.contact_number, u.email, u.password, m.municipality_name FROM users u
                            INNER JOIN municipalities m ON u.municipality_id = m.id
                            WHERE u.user_type = 'admin' AND u.id = :admin_id");
    $stmt->bindParam(':admin_id', $adminId, PDO::PARAM_INT);
    $stmt->execute();
    $adminUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$adminUser) {
        // Admin user not found, handle this case
        header("Location: sa_registeredmuni.php");
        exit;
    }
} else {
    // Admin user ID is not provided in the URL, handle this case
    header("Location: sa_registeredmuni.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $newFirstName = $_POST['first_name'];
    $newLastName = $_POST['last_name'];
    $newContactNumber = $_POST['contact_number'];
    $newEmail = $_POST['email'];

    // Check if a new password is provided
    if (!empty($_POST['new_password'])) {
        $newPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

        // Perform SQL update to save the changes, including the new password
        $updateStmt = $conn->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, contact_number = :contact_number, email = :email, password = :password WHERE id = :admin_id");
        $updateStmt->bindParam(':password', $newPassword, PDO::PARAM_STR); 
    } else {
        // Perform SQL update without changing the password
        $updateStmt = $conn->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, contact_number = :contact_number, email = :email WHERE id = :admin_id");
    }

    $updateStmt->bindParam(':first_name', $newFirstName, PDO::PARAM_STR);
    $updateStmt->bindParam(':last_name', $newLastName, PDO::PARAM_STR);
    $updateStmt->bindParam(':contact_number', $newContactNumber, PDO::PARAM_STR);
    $updateStmt->bindParam(':email', $newEmail, PDO::PARAM_STR);
    $updateStmt->bindParam(':admin_id', $adminId, PDO::PARAM_INT);

    if ($updateStmt->execute()) {
        // Redirect back to the superadmin dashboard after successful update
        header("Location: sa_registeredmuni.php");
        exit;
    } else {
        // Handle the case where the update fails
        $error = "Update failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Account</title>
     <style>
/* Style for the background color */
body {
    background-color: #e9ecf3; /* Light gray background color */
}

.columns-container {
    display: flex;
    justify-content: flex-start; /* Aligns children to the start (left side) of the container */
}

.left-column {
    width: 100%; /* Adjust this as needed */
}

.card {
    border-radius: 20px; /* Set the radius of the card's corners to 20px */
    width: 40%; /* Adjust the width as needed */
    margin-left: 0; /* Align the card to the left */
    padding: 20px; /* Optional: Add some padding inside the card */
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); /* Optional: Add some shadow for better aesthetics */
}

/* Add additional styles for responsive design */
@media (max-width: 768px) {
    .card {
        width: 90%; /* Larger width for smaller screens */
    }
}

.form-row {
    display: flex;
    align-items: center; /* Aligns items vertically in the center */
    margin-bottom: 10px; /* Adds space between each row */
}

.form-row label {
    margin-right: 10px; /* Adds some space between the label and the input */
    width: 40%; /* Adjusts the width of the label */
}

.form-row .form-control {
    flex-grow: 1; /* Allows the input to take up the remaining space */
}


.back-button {
    display: inline-flex;
    align-items: center;
    padding: 8px 12px;
    margin-bottom: 20px; /* Space between button and card */
    background-color: #909090; /* Soft blue color */
    color: white; /* Text color */
    text-decoration: none; /* Remove underline from link */
    border-radius: 4px; /* Rounded corners */
    font-size: 16px; /* Adjust font size as needed */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Optional: add shadow for depth */
    border: none; /* Remove border if any */
}

.back-button i {
    margin-right: 5px; /* Space between icon and text */
}

/* Adjust the left-column layout to align items to the start */
.left-column {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}


</style>
</head>
<body>
<div class="columns-container">
    <div class="left-column">

        <!-- Back Button -->
        <a href="sa_registeredmuni.php" class="back-button">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <div class="card">
        <h4><b>Manage Account</b></h4><hr><br>
        <?php if (isset($error)) { ?>
            <p class="text-danger"><?php echo $error; ?></p>
        <?php } ?>
        <form method="post">
            
<form method="post">
    <div class="form-row">
        <label for="first_name"><b>First Name:</label></b>
        <input type="text" placeholder= "Enter First Name" class="form-control" id="first_name" name="first_name" value="<?php echo $adminUser['first_name']; ?>" required>
    </div>
    <div class="form-row">
        <label for="last_name"><b>Last Name:</label></b>
        <input type="text" placeholder= "Enter Last Name" class="form-control" id="last_name" name="last_name" value="<?php echo $adminUser['last_name']; ?>" required>
    </div>
    <div class="form-row">
        <label for="contact_number"><b>Contact Number:</label></b>
        <input type="text" placeholder= "Enter Contact Number" class="form-control" id="contact_number" name="contact_number" value="<?php echo $adminUser['contact_number']; ?>" required>
    </div>
    <div class="form-row">
        <label for="email"><b>Email:</label></b>
        <input type="email" placeholder= "Enter Email" class="form-control" id="email" name="email" value="<?php echo $adminUser['email']; ?>" required>
    </div>
    <br><div class="form-row">
        <label for="new_password"><b>New Password </b>(leave empty to keep current password):</label>
        <input type="password" placeholder= "Enter New Password" class="form-control" id="new_password" name="new_password">
    </div>
    <br><br>
    <button type="submit" class="btn btn-success" style="margin-left: 380px;">Save Changes</button>
</form>

    </div>
</div>
</div>
</body>
</html>