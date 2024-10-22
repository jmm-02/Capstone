<?php
session_start();
include 'connection.php';



$userID = $_SESSION['user_id'] ?? null; // Get user ID from session
$barangayID = $_SESSION['barangay_id'] ?? null; // Get barangay ID from session

// Handle file upload logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_FILES["file"]) && !empty($_FILES["file"]["name"])) {
    // Specify upload directory
    $uploadDirectory = "uploads/lupon/";

    // Get the file name and target path
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $uploadDirectory . $fileName;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
      // Insert file information into the database
      $sql = "INSERT INTO user_files (user_id, barangay_id, file_name, file_path) 
                    VALUES (:user_id, :barangay_id, :file_name, :file_path)";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':user_id', $userID);
      $stmt->bindParam(':barangay_id', $barangayID);
      $stmt->bindParam(':file_name', $fileName);
      $stmt->bindParam(':file_path', $targetFilePath);
      $stmt->execute();
      $uploadMessage = "The file " . htmlspecialchars($fileName) . " has been uploaded and stored successfully.";
    } else {
      $uploadMessage = "Sorry, there was an error uploading your file.";
    }
  } else {
    $uploadMessage = "Please select a file to upload.";
  }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_FILES["file"]) && !empty($_FILES["file"]["name"])) {
    // Handle file upload logic
  } elseif (isset($_POST['delete_file'])) {
    $fileID = $_POST['file_id'] ?? null;
    if ($fileID) {
      // Fetch file information from the database
      $sql = "SELECT file_path FROM user_files WHERE id = :file_id AND user_id = :user_id AND barangay_id = :barangay_id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':file_id', $fileID);
      $stmt->bindParam(':user_id', $userID);
      $stmt->bindParam(':barangay_id', $barangayID);
      $stmt->execute();
      $file = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($file) {
        // Delete the file from the server
        unlink($file['file_path']);

        // Delete the file record from the database
        $sql = "DELETE FROM user_files WHERE id = :file_id AND user_id = :user_id AND barangay_id = :barangay_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':file_id', $fileID);
        $stmt->bindParam(':user_id', $userID);
        $stmt->bindParam(':barangay_id', $barangayID);
        $stmt->execute();

        $deleteMessage = "File deleted successfully.";
      } else {
        $deleteMessage = "File not found or you do not have permission to delete it.";
      }
    } else {
      $deleteMessage = "Invalid file ID.";
    }
  }
}
// Retrieve uploaded files from the database
$sql = "SELECT * FROM user_files WHERE user_id = :user_id AND barangay_id = :barangay_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $userID);
$stmt->bindParam(':barangay_id', $barangayID);
$stmt->execute();
$files = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Upload File for Lupon</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
  
</head>

<body class="bg-[#E8E8E7]">

  <?php include "user_sidebar_header.php"; ?>

  <div class="p-4 sm:ml-44 ">
    <div class="rounded-lg mt-16">

      <div class="row">
        <div class="col-lg-8 align-items-strech">
          <div class="card three-card">
            <div class="card-body">
              <h5 class="card-title fw-semibold" style="color: black;">Uploaded Files</h5>
              <?php if (isset($deleteMessage)) echo '<p>' . $deleteMessage . '</p>'; ?>
              <ul>
                <?php foreach ($files as $file): ?>
                  <li>
                    <a href="<?php echo $file['file_path']; ?>" target="_blank"><?php echo $file['file_name']; ?></a>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="delete-form" style="display:inline;">
                      <input type="hidden" name="file_id" value="<?php echo $file['id']; ?>">
                      <button type="submit" class="bg-red-500 px-3 py-2 hover:bg-red-400 border rounded-md text-white" name="delete_file" onclick="return confirm('Are you sure you want to delete the file?')">Delete</button>
                    </form>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
          <br>
          <div class="card three-card">
            <div class="card-body">
              <h5 class="card-title fw-semibold" style="color: black;">Upload File for Lupon</h5>

              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

                <div class="input-group">

                  <input type="file" class="bg-white rounded-md text-black" name="file" id="file"><br><br>
                  <input type="submit" class="bg-blue-500 px-2 hover:bg-blue-400 border rounded-md text-white" value="Upload" name="submit">

                </div>
              </form>       

            </div>
          </div>
        </div>
      </div>
    </div>
</body>

</html>