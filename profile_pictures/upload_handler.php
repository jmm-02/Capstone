<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}

$complaintId = isset($_GET['id']) ? $_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle file upload
    $uploadDir = 'uploads/';  // Change this to your desired upload directory
    $uploadedFile = $uploadDir . basename($_FILES['userfile']['name']);

    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadedFile)) {
        // File successfully uploaded, store information in the database
        $fileName = $_FILES['userfile']['name'];
        $filePath = $uploadedFile;

        // Store file information in your database (you need to modify this based on your database structure)
        // Example query: INSERT INTO files (complaint_id, file_name, file_path) VALUES ($complaintId, '$fileName', '$filePath');

        // Redirect back to the upload page after successful upload
        header("Location: upload_page.php?id=$complaintId");
        exit;
    } else {
        // Handle file upload error
        echo "File upload failed.";
    }
}

// Retrieve and display uploaded files
// Modify this part to fetch file information from your database
$uploadedList = [];  // Replace this array with actual data from the database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Files</title>
</head>
<body>

<a href="user_complaints.php" class="btn btn-outline-dark m-1">Back to Complaints</a>

<h1>Uploaded Files</h1>

<ul>
    <?php foreach ($uploadedList as $fileInfo): ?>
        <li>
            <a href="download.php?file=<?= $fileInfo['file_path'] ?>" target="_blank"><?= $fileInfo['file_name'] ?></a>
        </li>
    <?php endforeach; ?>
</ul>

</body>
</html>
