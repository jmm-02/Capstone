<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $complaintID = $_GET['id'];

    // Update the complaint's IsArchived status to 1 (archived)
    $query = "UPDATE complaints SET IsArchived = 1 WHERE id = $complaintID";
    if ($conn->query($query)) {
        // Redirect back to the complaints page after archiving
        header("Location: user_complaints.php");
        exit;
    } else {
        echo "Error archiving the complaint: " . $conn->error;
    }
}
?>
