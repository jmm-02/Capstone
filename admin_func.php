<?php
try {
    // Establish a new database connection
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the first name and last name of the user with the current user_id
    $stmt = $conn->prepare("SELECT first_name, last_name FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Store the first name and last name in the session (if available)
    if ($userData) {
        $_SESSION['first_name'] = $userData['first_name'];
        $_SESSION['last_name'] = $userData['last_name'];

        $admin_municipality_id = $_SESSION['municipality_id'];
        $stmt = $conn->prepare("SELECT barangay_name FROM barangays WHERE municipality_id = :municipality_id");
        $stmt->bindParam(':municipality_id', $admin_municipality_id, PDO::PARAM_INT);
        $stmt->execute();
        $barangays = $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
} catch (PDOException $e) {
    // Handle database connection or query errors
    echo "Error: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && isset($_POST["user_id"])) {
    $action = $_POST["action"];
    $userId = $_POST["user_id"];

    if ($action === "verify") {
    // Perform logic to verify the user
    $verifyQuery = "UPDATE users SET verified = 1 WHERE id = ?";
    $verifyStatement = $conn->prepare($verifyQuery);
    $verifyStatement->execute([$userId]);

    // Redirect to refresh the page or show a success message
    header("Location: admin_acc_req.php");
    exit();
} 


elseif ($action === "deny") {
    // Show a confirmation dialog before deleting
    echo '<script>
            var result = confirm("Are you sure you want to deny this request? The request will be deleted.");
            if (result) {
                window.location.href = "admin_dashboard.php?deny_user_id=' . $userId . '";
            }
          </script>';
} elseif ($action === "unverify") {
    // Perform logic to unverify the user
    $unverifyQuery = "UPDATE users SET verified = 0 WHERE id = ?";
    $unverifyStatement = $conn->prepare($unverifyQuery); // Replace $conn with $conn
    $unverifyStatement->execute([$userId]);

    // Redirect to refresh the page or show a success message
    header("Location: admin_dashboard.php");
    exit();
}
}

if (isset($_GET['deny_user_id'])) {
    $denyUserId = $_GET['deny_user_id'];
    
    try {
        $conn->beginTransaction();
        
        // Get the barangay_id of the user to be deleted
        $barangayIdQuery = "SELECT barangay_id FROM users WHERE id = ?";
        $barangayIdStatement = $conn->prepare($barangayIdQuery);
        $barangayIdStatement->execute([$denyUserId]);
        $barangayId = $barangayIdStatement->fetchColumn();
        
        // Update the users table to remove the reference to the barangay
        $updateUserQuery = "UPDATE users SET barangay_id = NULL WHERE id = ?";
        $updateUserStatement = $conn->prepare($updateUserQuery);
        $updateUserStatement->execute([$denyUserId]);

        // Delete the corresponding row from the barangays table
        $deleteBarangayQuery = "DELETE FROM barangays WHERE id = ?";
        $deleteBarangayStatement = $conn->prepare($deleteBarangayQuery);
        $deleteBarangayStatement->execute([$barangayId]);

        // Finally, delete the user from the users table
        $deleteQuery = "DELETE FROM users WHERE id = ?";
        $deleteStatement = $conn->prepare($deleteQuery);
        $deleteStatement->execute([$denyUserId]);

        $conn->commit();

        // Redirect to refresh the page or show a success message
        header("Location: admin_dashboard.php");
        exit();
    } catch (PDOException $e) {
        $conn->rollBack();
        // Handle the error here, such as displaying an error message
        echo "Error: " . $e->getMessage();
    }
}
?>