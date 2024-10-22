<?php
// upload_files.php
session_start();
include 'connection.php';
include 'index-navigation.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}

$complaintId = isset($_GET['id']) ? $_GET['id'] : 0;

// Check if the complaint belongs to the current user to ensure security
// ... your existing code to check if the complaint belongs to the current user ...

// Fetch file paths associated with the complaint
$fetchFilesQuery = "SELECT files_path FROM complaints WHERE id = ?";
$stmtFetchFiles = $conn->prepare($fetchFilesQuery);
$stmtFetchFiles->execute([$complaintId]);
$complaintFiles = $stmtFetchFiles->fetch(PDO::FETCH_ASSOC);
$filePaths = explode(',', $complaintFiles['files_path']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'uploads/'; // Specify your upload directory
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileType = $_FILES['file']['type'];
    $fileSize = $_FILES['file']['size'];

    // Validate file type, size, etc., and move it to the uploads folder
    // Add additional security measures as needed

    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($fileTmpName, $targetPath)) {
        // Update files_path column in the complaints table
        try {
            $updateFilesPathQuery = "UPDATE complaints SET files_path = CONCAT(files_path, ',', ?) WHERE id = ?";
            $stmt = $conn->prepare($updateFilesPathQuery);
            $stmt->execute([$targetPath, $complaintId]);

            // Fetch updated file paths
            $stmtFetchFiles->execute([$complaintId]);
            $complaintFiles = $stmtFetchFiles->fetch(PDO::FETCH_ASSOC);
            $filePaths = explode(',', $complaintFiles['files_path']);

            // Provide feedback to the user
            echo "File uploaded successfully!";
        } catch (PDOException $e) {
            // Provide error feedback to the user
            echo "Error updating files_path: " . $e->getMessage();
        }
    } else {
        // Provide error feedback to the user
        echo "Error uploading file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... your existing head section ... -->
</head>
<body>
    <div class="container">
        <h2>Upload Files for Complaint #<?= $complaintId ?></h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="file">Select File:</label>
                <input type="file" name="file" id="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>

        <?php if (!empty($filePaths)): ?>
            <h3>Uploaded Files:</h3>
            <ul>
                <?php foreach ($filePaths as $filePath): ?>
                    <li><a href="<?= $filePath ?>" target="_blank"><?= basename($filePath) ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>
</html>
