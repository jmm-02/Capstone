<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}

$complaintId = isset($_GET['id']) ? $_GET['id'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
</head>
<body>


<a href="user_complaints.php" class="btn btn-outline-dark m-1">Back to Complaints</a>

    <h1>Upload File</h1>
    <form enctype="multipart/form-data">
        <input type="file" id="fileInput" />
        <button type="button" onclick="uploadFile()">Upload</button>
    </form>

    <div id="fileList">
        <h2>Uploaded Files</h2>
        <ul id="uploadedFiles"></ul>
    </div>

    

    <script>
        // Load previously uploaded files from local storage
        const storedFilesKey = `uploadedFiles_${<?= $complaintId ?>}`; // Include complaint ID in the local storage key
        const storedFiles = JSON.parse(localStorage.getItem(storedFilesKey)) || [];
        const fileList = document.getElementById('uploadedFiles');

        storedFiles.forEach(function(fileName) {
            const listItem = document.createElement('li');
            listItem.textContent = fileName;
            fileList.appendChild(listItem);
        });

        function uploadFile() {
            const fileInput = document.getElementById('fileInput');
            const fileList = document.getElementById('uploadedFiles');

            const file = fileInput.files[0];

            if (file) {
                const listItem = document.createElement('li');
                listItem.textContent = file.name;
                fileList.appendChild(listItem);

                // Save the uploaded file names to local storage
                const storedFiles = JSON.parse(localStorage.getItem(storedFilesKey)) || [];
                storedFiles.push(file.name);
                localStorage.setItem(storedFilesKey, JSON.stringify(storedFiles));
            } else {
                alert('Please select a file to upload.');
            }

            // Optional: Clear the file input after uploading
            fileInput.value = '';
        }
    </script>
</body>
</html>
