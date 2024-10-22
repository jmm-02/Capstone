<?php
session_start();
include '../connection.php';

$userID = $_SESSION['user_id'] ?? '';
$barangay_id = $_SESSION['barangay_id'] ?? '';

// Check if the barangay has already uploaded files
$check_query = "SELECT COUNT(*) FROM mov WHERE barangay_id = :barangay_id";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bindParam(':barangay_id', $barangay_id, PDO::PARAM_INT);
$check_stmt->execute();
$already_uploaded = $check_stmt->fetchColumn();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $already_uploaded == 0) {

  function uniqueNameConverter($arg)
  {
    $pathInfo = pathinfo($arg);
    $filename = $pathInfo['filename'];
    $extension = isset($pathInfo['extension']) ? $pathInfo['extension'] : '';
    $timestamp = date("YmdHis");
    $randomString = substr(md5(mt_rand()), 0, 8); // Adding a random string
    return $filename . "_" . $timestamp . "_" . $randomString . "." . $extension;
  }

  $files = [
    'IA_1a_pdf_File',
    'IA_1b_pdf_File',
    'IA_2a_pdf_File',
    'IA_2b_pdf_File',
    'IA_2c_pdf_File',
    'IA_2d_pdf_File',
    'IA_2e_pdf_File',
    'IB_1forcities_pdf_File',
    'IB_1aformuni_pdf_File',
    'IB_1bformuni_pdf_File',
    'IB_2_pdf_File',
    'IB_3_pdf_File',
    'IB_4_pdf_File',
    'IC_1_pdf_File',
    'IC_2_pdf_File',
    'ID_1_pdf_File',
    'ID_2_pdf_File',
    'IIA_pdf_File',
    'IIB_1_pdf_File',
    'IIB_2_pdf_File',
    'IIC_pdf_File',
    'IIIA_pdf_File',
    'IIIB_pdf_File',
    'IIIC_1forcities_pdf_File',
    'IIIC_1forcities2_pdf_File',
    'IIIC_1forcities3_pdf_File',
    'IIIC_2formuni1_pdf_File',
    'IIIC_2formuni2_pdf_File',
    'IIIC_2formuni3_pdf_File',
    'IIID_pdf_File',
    'IV_forcities_pdf_File',
    'IV_muni_pdf_File',
    'V_1_pdf_File',
    'threepeoplesorg'
  ];

  $fileNames = [];
  foreach ($files as $file) {
    if (isset($_FILES[$file]) && $_FILES[$file]['error'] == 0) {
      $fileNames[$file] = uniqueNameConverter($_FILES[$file]['name']);
    } else {
      $fileNames[$file] = null; // Assign NULL if the file is not uploaded
    }
  }

  // Prepare the SQL query
  $insert_query = "INSERT INTO mov (
    user_id, 
    barangay_id,
    IA_1a_pdf_File,
    IA_1b_pdf_File,
    IA_2a_pdf_File,
    IA_2b_pdf_File,
    IA_2c_pdf_File,
    IA_2d_pdf_File,
    IA_2e_pdf_File,
    IB_1forcities_pdf_File,
    IB_1aformuni_pdf_File,
    IB_1bformuni_pdf_File,
    IB_2_pdf_File,
    IB_3_pdf_File,
    IB_4_pdf_File,
    IC_1_pdf_File,
    IC_2_pdf_File,
    ID_1_pdf_File,
    ID_2_pdf_File,
    IIA_pdf_File,
    IIB_1_pdf_File,
    IIB_2_pdf_File,
    IIC_pdf_File, 
    IIIA_pdf_File,
    IIIB_pdf_File,
    IIIC_1forcities_pdf_File,
    IIIC_1forcities2_pdf_File,
    IIIC_1forcities3_pdf_File,
    IIIC_2formuni1_pdf_File,
    IIIC_2formuni2_pdf_File,
    IIIC_2formuni3_pdf_File, 
    IIID_pdf_File, 
    IV_forcities_pdf_File, 
    IV_muni_pdf_File,
    V_1_pdf_File, 
    threepeoplesorg
  ) VALUES (
    :user_id, 
    :barangay_id, 
    :IA_1a_pdf_File,
    :IA_1b_pdf_File,
    :IA_2a_pdf_File,
    :IA_2b_pdf_File,
    :IA_2c_pdf_File,
    :IA_2d_pdf_File,
    :IA_2e_pdf_File,
    :IB_1forcities_pdf_File,
    :IB_1aformuni_pdf_File,
    :IB_1bformuni_pdf_File,
    :IB_2_pdf_File,
    :IB_3_pdf_File,
    :IB_4_pdf_File,
    :IC_1_pdf_File,
    :IC_2_pdf_File,
    :ID_1_pdf_File,
    :ID_2_pdf_File,
    :IIA_pdf_File,
    :IIB_1_pdf_File,
    :IIB_2_pdf_File,
    :IIC_pdf_File, 
    :IIIA_pdf_File,
    :IIIB_pdf_File,
    :IIIC_1forcities_pdf_File,
    :IIIC_1forcities2_pdf_File,
    :IIIC_1forcities3_pdf_File,
    :IIIC_2formuni1_pdf_File,
    :IIIC_2formuni2_pdf_File,
    :IIIC_2formuni3_pdf_File, 
    :IIID_pdf_File, 
    :IV_forcities_pdf_File, 
    :IV_muni_pdf_File,
    :V_1_pdf_File, 
    :threepeoplesorg
  )";

  $stmt = $conn->prepare($insert_query);
  
  $stmt->bindParam(':user_id', $userID);
  $stmt->bindParam(':barangay_id', $barangay_id);

  foreach ($files as $file) {
    $stmt->bindParam(":$file", $fileNames[$file], PDO::PARAM_STR);
  }

  // Execute and move files
  if ($stmt->execute()) {
    foreach ($files as $file) {
      if (isset($fileNames[$file]) && $fileNames[$file] !== null) {
        $fileTMP = $_FILES[$file]['tmp_name'];
        $fileDestination = 'movfolder/' . $fileNames[$file];
        move_uploaded_file($fileTMP, $fileDestination);
      }
    }
    echo "<script>alert('Files uploaded successfully!'); 
    window.location.href='form2movview.php';</script>";
    exit();
  } else {
    echo "<script>alert('Error inserting into database.');</script>";
  }
} else {
  echo "<script>alert('Files already uploaded for this barangay.');
  window.location.href='form2movview.php';</script>";
}

?>
