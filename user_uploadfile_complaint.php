<?php
session_start();
include 'connection.php';



$uploadMessage = 'Click Choose File and select the file to Upload.';

$userID = $_SESSION['user_id'];
$barangayID = $_SESSION['barangay_id'];
// Sanitize input to prevent SQL injection
$rowID = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT) : null;

$query = "SELECT * FROM complaints WHERE id = :rowID AND UserID = :userID";
$stmt = $conn->prepare($query);
$stmt->bindParam(':rowID', $rowID);
$stmt->bindParam(':userID', $_SESSION['user_id']);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Set session variables for the data from 'complaints' table
$_SESSION['forTitle'] = $row['ForTitle'];
$_SESSION['cNames'] = $row['CNames'];
$_SESSION['rspndtNames'] = $row['RspndtNames'];
$_SESSION['cDesc'] = $row['CDesc'];
$_SESSION['petition'] = $row['Petition'];
$_SESSION['cNum'] = $row['CNum'];
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if case_id is present in URL
  if (isset($_GET['id'])) {
    $caseID = $_GET['id'];

    // Check if file input field is set and not empty
    if (isset($_FILES["file"]) && !empty($_FILES["file"]["name"])) {
      // Create User-Specific Folder
      $userFolder = "uploads/{$userID}/";
      if (!file_exists($userFolder)) {
        mkdir($userFolder, 0777, true);
      }

      // Create Case-Specific Folder
      $caseFolder = $userFolder . "{$caseID}/";
      if (!file_exists($caseFolder)) {
        mkdir($caseFolder, 0777, true);
      }

      // Specify target directory within case-specific folder
      $targetDir = $caseFolder;

      // Get the file name and target path
      $fileName = basename($_FILES["file"]["name"]);
      $targetFilePath = $targetDir . $fileName;

      // Check if file already exists
      if (file_exists($targetFilePath)) {
        $uploadMessage = "Sorry, the file already exists.";
      } else {
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
          // Insert file information into the database
          $sql = "INSERT INTO upload_files (user_id, barangay_id, case_id, file_name, file_path) VALUES (:user_id, :barangay_id, :case_id, :file_name, :file_path)";
          $stmt = $conn->prepare($sql);
          $stmt->bindParam(':user_id', $userID);
          $stmt->bindParam(':barangay_id', $barangayID);
          $stmt->bindParam(':case_id', $caseID);
          $stmt->bindParam(':file_name', $fileName);
          $stmt->bindParam(':file_path', $targetFilePath);
          if ($stmt->execute()) {
            $uploadMessage = "The file " . htmlspecialchars($fileName) . " has been uploaded and stored successfully.";
          } else {
            $uploadMessage = "Sorry, there was an error uploading your file.";
          }
        } else {
          $uploadMessage = "Sorry, there was an error uploading your file.";
        }
      }
    } else {
      $uploadMessage = "Please select a file to upload.";
    }
  } else {
    $uploadMessage = "Cannot upload files without selecting a case.";
  }

  // Check if the delete button is clicked
  if (isset($_POST["delete_file"])) {
    $deleteFileID = $_POST["delete_file_id"];

    // Retrieve file information from the database
    $sql = "SELECT * FROM upload_files WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $deleteFileID);
    $stmt->execute();
    $fileToDelete = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($fileToDelete) {
      // Delete the file from the server
      if (unlink($fileToDelete['file_path'])) {
        // Delete the file record from the database
        $sqlDelete = "DELETE FROM upload_files WHERE id = :id";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bindParam(':id', $deleteFileID);

        if ($stmtDelete->execute()) {
          $uploadMessage = "The file " . htmlspecialchars($fileToDelete['file_name']) . " has been deleted.";

          // Check if there are no more files in the case folder
          $caseFolder = "uploads/{$userID}/{$caseID}/";
          if (count(glob($caseFolder . "*")) === 0) {
            // Remove the case folder if it's empty
            rmdir($caseFolder);
            $uploadMessage .= "<br> The folder is now empty.";
          }
        } else {
          $uploadMessage = "Failed to delete the file from the database.";
        }
      } else {
        $uploadMessage = "Failed to delete the file from the server.";
      }
    } else {
      $uploadMessage = "File not found in the database.";
    }
  }
}


$fileList = [];
if ($userID && $barangayID && isset($_GET['id'])) {
  $caseID = $_GET['id'];
  $sql = "SELECT * FROM upload_files WHERE user_id = :user_id AND barangay_id = :barangay_id AND case_id = :case_id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':user_id', $userID);
  $stmt->bindParam(':barangay_id', $barangayID);
  $stmt->bindParam(':case_id', $caseID);
  $stmt->execute();
  $fileList = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Upload Files</title>
  <link rel="icon" type="image/x-icon" href="img/favicon.ico">
  

  <style>
    .card {
      box-shadow: 0 0 0.3cm rgba(0, 0, 0, 0.2);
      border-radius: 15px;

    }
  </style>
</head>

<body class="bg-[#E8E8E7]">

  <?php include "user_sidebar_header.php"; ?>

  <div class="p-4 sm:ml-44 ">
    <div class="rounded-lg mt-16">

      <div class="row">
        <div class="col-lg-8 align-items-strech">
          <div class="card three-card">
            <div class="card-body">
              <h5 class="card-title fw-semibold" style="color: black; ">Upload Files for Case: <?php echo $row['CNum']; ?>
                <br>
                Title: <?php echo $row['ForTitle']; ?>
              </h5>

              <br>

              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . ($_GET['id'] ?? ''); ?>" method="post" enctype="multipart/form-data">
                <div class="input-group">
                  <input type="file" class="bg-white rounded-md text-black" name="file" id="file"><br><br>
                  <!-- Add hidden input field to pass case_id -->
                  <input type="hidden" name="case_id" value="<?php echo $_GET['id'] ?? ''; ?>">
                  <input type="submit" class="bg-blue-500 px-2 hover:bg-blue-400 border rounded-md text-white" value="Upload" name="submit">
                </div>
              </form>

              <br>
              <h5 class="card-title fw-semibold" style="color: black; ">Uploaded Files</h5>
              <?php echo $uploadMessage; ?>
              <ul>
                <?php foreach ($fileList as $file): ?>
                  <li>
                    <a href="<?php echo $file['file_path']; ?>" target="_blank"><?php echo $file['file_name']; ?></a>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . ($_GET['id'] ?? ''); ?>" method="post" style="display:inline;">
                      <input type="hidden" name="delete_file_id" value="<?php echo $file['id']; ?>">
                      <input type="submit" value="Delete" class="bg-red-500 hover:bg-red-400 px-3 py-2 rounded-md text-white" name="delete_file">
                    </form>
                  </li>
                <?php endforeach; ?>
              </ul>

            </div>
          </div>
        </div>
      </div>
    </div>
</body>

</html>