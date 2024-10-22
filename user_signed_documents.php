<?php
session_start();
require 'connection.php'; 


if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
  header("Location: login.php");
  exit;
}

// Get the user ID from the session (assuming user is logged in)
$userID = $_SESSION['user_id'];

// Handle file deletion
if (isset($_POST['delete_file'])) {
  $filePath = $_POST['delete_file_path'];

  // Sanitize the file path
  $filePath = htmlspecialchars($filePath, ENT_QUOTES, 'UTF-8');

  // Delete file from server
  if (file_exists($filePath)) {
    unlink($filePath);

    // Delete file record from database
    $stmt = $conn->prepare("DELETE FROM upload_files WHERE file_path = :file_path AND user_id = :user_id");
    $stmt->bindParam(':file_path', $filePath, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect to the same page to avoid resubmission of the form
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
  } else {
    echo "File not found.";
  }
}

// Fetch all files with their respective details
$stmt = $conn->prepare("
    SELECT b.barangay_name, uf.signed_form, uf.file_path 
    FROM upload_files uf
    JOIN barangays b ON uf.barangay_id = b.id
    WHERE uf.user_id = :user_id
    ORDER BY b.barangay_name
");
$stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
$stmt->execute();
$files = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Organize files by barangay
$filesByBarangay = [];
foreach ($files as $file) {
  $filesByBarangay[$file['barangay_name']][] = $file;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Files</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/styles.min.css" />
 
</head>

<body class="bg-[#E8E8E7]">
  <!-- Sidebar -->
  <?php include "user_sidebar_header.php"; ?>

  <div class="p-4 sm:ml-44 ">
    <div class="rounded-lg mt-16">

      <!-- Main content -->
      <main class="h-fit w-[22rem] p-6 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-6">Files by Barangay</h1>

        <?php if (!empty($filesByBarangay)): ?>
          <?php foreach ($filesByBarangay as $barangay => $files): ?>
            <section class="mb-8">
              <h2 class="text-2xl font-semibold mb-4"><?php echo htmlspecialchars($barangay); ?></h2>
              <ul class="space-y-4">
                <?php foreach ($files as $file): ?>
                  <li class="bg-white p-4 rounded-lg shadow-md flex justify-between items-center mb-4">
                    <div class="flex-1">
                      <a href="<?php echo htmlspecialchars($file['file_path']); ?>" target="_blank" class="text-blue-600 hover:underline">
                        <?php echo htmlspecialchars($file['signed_form']); ?>
                      </a>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="ml-4">
                      <input type="hidden" name="delete_file_path" value="<?php echo htmlspecialchars($file['file_path']); ?>">
                      <button type="submit" class="bg-red-500 hover:bg-red-400 px-4 py-2 rounded-md text-white" name="delete_file">Delete</button>
                    </form>
                  </li>
                <?php endforeach; ?>
              </ul>
            </section>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-gray-600">No files found.</p>
        <?php endif; ?>
      </main>
    </div>
  </div>
</body>

</html>