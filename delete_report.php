<?php
session_start();
include 'connection.php';

// Check if user is logged in and authorized
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}

// Check if report_id is provided in the URL
if(isset($_GET['report_id'])) {
    $report_id = $_GET['report_id'];
    
    // Prepare and execute the SQL query to delete the report
    $query = "DELETE FROM reports WHERE report_id = :report_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':report_id', $report_id);
    
    if($stmt->execute()) {
        // Report deleted successfully
        $_SESSION['delete_message'] = "Report Deleted Successfully";
    } else {
        // Error occurred while deleting the report
        $_SESSION['delete_message'] = "Failed to Delete Report";
    }
    
    // Redirect back to user_add_report.php after deletion
    header("Location: user_add_report.php");
    exit;
} else {
    // Redirect back to user_add_report.php if report_id is not provided
    header("Location: user_add_report.php");
    exit;
}
?>
