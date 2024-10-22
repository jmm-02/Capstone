<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['unarchive_id'])) {
    $unarchiveID = $_GET['unarchive_id'];

    // Update the complaint's IsArchived status to unarchive it
    $unarchiveQuery = "UPDATE complaints SET IsArchived = 0 WHERE id = '$unarchiveID'";
    
    if ($conn->query($unarchiveQuery)) {
        // Unarchive successful
        header("Location: user_archives.php");
        exit;
    } else {
        // Unarchive failed
        echo "Failed to unarchive complaint. Please try again.";
    }
} else {
    // If unarchive_id is not provided, redirect to the archives page
    header("Location: user_archives.php");
    exit;
}
?>
