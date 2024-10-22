<?php
session_start();
include 'connection.php';



// Set default language to English if not set
$_SESSION['language'] = isset($_SESSION['language']) ? $_SESSION['language'] : 'english';

// Update language preference if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['language'])) {
  $languagePreference = $_POST['language'];

  // Ensure the selected value is valid before updating
  $validLanguages = ['english', 'tagalog'];

  if (in_array($languagePreference, $validLanguages)) {
    $_SESSION['language'] = $languagePreference;
  }
}

$uploadMessage = 'Click Choose File and select the file to Upload.';

$userID = $_SESSION['user_id'];
$barangayID = $_SESSION['barangay_id'];
// Sanitize input to prevent SQL injection
$rowID = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT) : null;

if ($rowID === null) {
  header("Location: user_complaints.php");
  exit("Error: Row ID is missing. Please select a valid case to manage.");
}

$query = "SELECT * FROM complaints WHERE id = :rowID AND UserID = :userID";
$stmt = $conn->prepare($query);
$stmt->bindParam(':rowID', $rowID);
$stmt->bindParam(':userID', $_SESSION['user_id']);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
  header("Location: user_complaints.php");
  exit("Error: No matching case found for the given ID.");
}

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
          $sql = "INSERT INTO upload_files (user_id, barangay_id, case_id, signed_form, file_path) VALUES (:user_id, :barangay_id, :case_id, :signed_form, :file_path)";
          $stmt = $conn->prepare($sql);
          $stmt->bindParam(':user_id', $userID);
          $stmt->bindParam(':barangay_id', $barangayID);
          $stmt->bindParam(':case_id', $caseID);
          $stmt->bindParam(':signed_form', $fileName);
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

// Query the 'lupons' table to get 'punong_barangay' and 'lupon_chairman'
$luponsQuery = "SELECT punong_barangay, lupon_chairman FROM lupons WHERE user_id = :userID";
$luponsStmt = $conn->prepare($luponsQuery);
$luponsStmt->bindParam(':userID', $_SESSION['user_id']);
$luponsStmt->execute();
$luponsRow = $luponsStmt->fetch(PDO::FETCH_ASSOC);

if ($luponsRow) {
  $_SESSION['punong_barangay'] = $luponsRow['punong_barangay'];
  $_SESSION['lupon_chairman'] = $luponsRow['lupon_chairman'];
}

$currentHearing = '';
$existingRow = false; // Flag to indicate if an existing row is found

// Fetch the current hearing from the case_progress table
$fetchCurrentHearingQuery = "SELECT current_hearing FROM case_progress WHERE complaint_id = :complaintId";
$stmt = $conn->prepare($fetchCurrentHearingQuery);
$stmt->bindParam(':complaintId', $_GET['id']);
$stmt->execute();
$currentHearingResult = $stmt->fetch(PDO::FETCH_ASSOC);

if ($currentHearingResult) {
  $currentHearing = $currentHearingResult['current_hearing'];
  $existingRow = true; // Set flag to true if an existing row is found
} else {
  $currentHearing = '0';
}

// Fetch the latest hearing value
$fetchLatestHearingQuery = "SELECT latest_hearing FROM case_progress WHERE complaint_id = :complaintId";
$stmt = $conn->prepare($fetchLatestHearingQuery);
$stmt->bindParam(':complaintId', $_GET['id']);
$stmt->execute();
$latestHearingResult = $stmt->fetch(PDO::FETCH_ASSOC);
$latestHearing = $latestHearingResult['latest_hearing'];

// Determine the number of hearings to display based on the latest hearing
$numHearings = intval(str_replace(['st', 'nd', 'rd', 'th'], '', $latestHearing));
$numHearings = max(3, $numHearings); // Ensure a minimum of 3 hearings are displayed
if (!$existingRow) {
  // If no existing row, hide the minimum 3 hearings
  $numHearings = 0;
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['hearing'])) {
    // Update the current hearing value with ordinal suffix
    $selectedHearing = $_POST['hearing'];
    $currentHearing = $selectedHearing . getOrdinalSuffix($selectedHearing);

    // Update the case_progress table with the selected hearing value
    $updateHearingQuery = "UPDATE case_progress SET current_hearing = :currentHearing WHERE complaint_id = :complaintId";
    $stmt = $conn->prepare($updateHearingQuery);
    $stmt->bindParam(':currentHearing', $currentHearing);
    $stmt->bindParam(':complaintId', $_GET['id']);
    if ($stmt->execute()) {
      // Database update successful
    } else {
      // Database update failed
      // Handle the error accordingly
    }
  } elseif (isset($_POST['add_hearing'])) {
    if (!$existingRow) {
      // If no existing row, add a new row with default values
      $numHearings = 1; // Start from 1st hearing
      $currentHearing = '1st'; // Set current hearing to 1st
      $latestHearing = '1st'; // Set latest hearing to 1st

      // Insert new row into the case_progress table
      $insertNewRowQuery = "INSERT INTO case_progress (complaint_id, current_hearing, latest_hearing) VALUES (:complaintId, :currentHearing, :latestHearing)";
      $stmt = $conn->prepare($insertNewRowQuery);
      $stmt->bindParam(':complaintId', $_GET['id']);
      $stmt->bindParam(':currentHearing', $currentHearing);
      $stmt->bindParam(':latestHearing', $latestHearing);
      if ($stmt->execute()) {
        // New row added successfully
      } else {
        // Failed to add new row
        // Handle the error accordingly
      }
    } else {
      // Increment the number of hearings
      $numHearings++;

      // Update the latest hearing value in the case_progress table
      $latestHearing = $numHearings . getOrdinalSuffix($numHearings);
      $updateLatestHearingQuery = "UPDATE case_progress SET latest_hearing = :latestHearing WHERE complaint_id = :complaintId";
      $stmt = $conn->prepare($updateLatestHearingQuery);
      $stmt->bindParam(':latestHearing', $latestHearing);
      $stmt->bindParam(':complaintId', $_GET['id']);
      if ($stmt->execute()) {
        // Database update successful
      } else {
        // Database update failed
        // Handle the error accordingly
      }
    }
  }
}

// Set session variables for the current complaint ID and current hearing
$_SESSION['current_complaint_id'] = $_GET['id'];
$_SESSION['current_hearing'] = $currentHearing;

// Function to get the ordinal suffix
function getOrdinalSuffix($number)
{
  if (!is_numeric($number)) {
    return ''; // Return an empty string if $number is not numeric
  }

  if ($number % 100 >= 11 && $number % 100 <= 13) {
    return 'th';
  }
  switch ($number % 10) {
    case 1:
      return 'st';
    case 2:
      return 'nd';
    case 3:
      return 'rd';
    default:
      return 'th';
  }
}

// Set language session variable
if (isset($_POST['language'])) {
  $selectedLanguage = ($_POST['language'] === 'english') ? 'en' : 'tl';
  $_SESSION['language'] = $selectedLanguage;
}

// Define folder name based on selected language
$folderName = ($_SESSION['language'] === 'tl') ? 'forms_tagalog' : 'forms_english';
?>


<!doctype html>
<html lang="<?php echo isset($_SESSION['language']) ? $_SESSION['language'] : 'en'; ?>">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Case</title>
  <link rel="shortcut icon" type="image/png" href=".assets/images/logos/favicon.png" />
  
  <style>
    body,
    html {
      margin: 0;
      padding: 0;
      width: 100%;
      height: 100%;
    }

    .hearing-button {
      padding: 10px 20px;
      border: 2px solid #333;
      border-radius: 5px;
      background-color: #fff;
      color: #333;
      font-size: 16px;
      font-weight: bold;
      text-transform: uppercase;
      cursor: pointer;
      transition: background-color 0.3s, color 0.3s, border-color 0.3s;
    }

    .hearing-button:hover,
    .hearing-button.active {
      background-color: #ffcc00;
      color: #fff;
      border-color: #ffcc00;
    }

    .active {
      background-color: #ffcc00;
      color: #fff;
    }

    .modal-container {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.8);
      /* Add a semi-transparent background */
      z-index: 9999;
      /* Ensure the modal is above other elements */
      overflow: auto;
    }

    .iframe-container {
      width: 100vw;
      /* Set the width to 100% of the viewport width */
      height: 100vh;
      /* Set the height to 100% of the viewport height */
      border: none;
      display: flex;
      align-items: center;
      justify-content: center;
      position: fixed;
      /* Use fixed positioning for full-screen effect */
      top: 0;
      left: 0;
      background-color: rgba(0, 0, 0, 0.8);
      z-index: 9999;
      overflow: auto;
    }

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


      <?php
      $page = isset($_GET['page']) ? $_GET['page'] : 1;
      ?>
      <a href="user_complaints.php?page=<?= $page ?>" class="btn btn-dark m-1">Back to Complaints</a>
      <br><br>
      <div class="row">
        <div class="col-lg-8 d-flex align-items-strech">
          <div class="card w-100">
            <div class="card-body">
              <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                <div class="mb-3 mb-sm-0">

                  <div class="d-flex align-items-center">
                    <img src="img/cluster.png" alt="Logo" style="max-width: 120px; max-height: 120px; margin-right: 10px;" class="align-middle">
                    <div>
                      <h5 class="card-title mb-2 fw-semibold">Department of the Interior and Local Government</h5>

                    </div>
                  </div>
                  <br>

                  <div class="hearing-buttons">
                    <form method="POST">
                      <?php for ($i = 1; $i <= $numHearings; $i++) {
                        $suffix = 'th';
                        if ($i % 10 == 1 && $i != 11) {
                          $suffix = 'st';
                        } elseif ($i % 10 == 2 && $i != 12) {
                          $suffix = 'nd';
                        } elseif ($i % 10 == 3 && $i != 13) {
                          $suffix = 'rd';
                        }
                      ?>
                        <button type="submit" name="hearing" value="<?php echo $i . 'th'; ?>" class="btn <?php echo ($currentHearing === $i . 'th') ? 'btn-warning active' : 'btn-light'; ?> m-1"><?php echo $i . $suffix . ' Hearing'; ?></button>
                      <?php } ?>
                    </form>
                    <form method="POST">
                      <button type="submit" name="add_hearing" class="bg-blue-500 hover:bg-blue-400 px-3 py-2 rounded-md text-white">Add Hearing</button>
                    </form>
                  </div>

                  <h5 class="card-title mb-9 fw-semibold">Manage Case</h5>
                  <hr>

                  <h5 class="card-title mb-9 fw-semibold"><?php echo "Case Number:" . $_SESSION['cNum']; ?></h5>
                  <h5 class="card-title mb-9 fw-semibold"><?php echo "Case Title: " . $_SESSION['cNames']; ?> vs <?php echo $_SESSION['rspndtNames']; ?></h5>
                  <h5 class="card-title mb-9 fw-semibold"><?php echo "Complaint:" . $_SESSION['cDesc']; ?></h5>
                  <hr>

                  <h5 class="card-title mb-9 fw-semibold"><?php echo ucfirst($_SESSION['language']); ?> Forms</h5>

                  <form method="POST">
                    <button type="submit" name="language" value="english"class="btn <?php echo ($_SESSION['language'] === 'en') ? 'bg-gray-800 hover:bg-gray-700 px-3 py-2 rounded-md text-white' : 'bg-gray-300 hover:bg-gray-200 px-3 py-2 rounded-md text-black'; ?> m-1">English</button>

                    <button type="submit" name="language" value="tagalog" class="btn <?php echo ($_SESSION['language'] === 'tl') ? 'bg-gray-800 hover:bg-gray-700 px-3 py-2 rounded-md text-white' : 'bg-gray-300 hover:bg-gray-200 px-3 py-2 rounded-md text-black'; ?> m-1">Tagalog</button>
                  </form>

                  <br>

                  <div class="form-buttons">
                    <?php
                    $formButtons = [
                      'KP 7' => 'kp_form7.php',
                      'KP 8' => 'kp_form8.php',
                      'KP 9' => 'kp_form9.php',
                      'KP 10' => 'kp_form10.php',
                      'KP 11' => 'kp_form11.php',
                      'KP 12' => 'kp_form12.php',
                      'KP 13' => 'kp_form13.php',
                      'KP 14' => 'kp_form14.php',
                      'KP 15' => 'kp_form15.php',
                      'KP 16' => 'kp_form16.php',
                      'KP 17' => 'kp_form17.php',
                      'KP 18' => 'kp_form18.php',
                      'KP 19' => 'kp_form19.php',
                      'KP 20' => 'kp_form20.php',
                      'KP 20 A' => 'kp_form20A.php',
                      'KP 20 B' => 'kp_form20B.php',
                      'KP 21' => 'kp_form21.php',
                      'KP 22' => 'kp_form22.php',
                      'KP 23' => 'kp_form23.php',
                      'KP 24' => 'kp_form24.php',
                      'KP 25' => 'kp_form25.php',
                    ];

                    foreach ($formButtons as $buttonText => $formFileName) {
                      $formUsed = array_search($buttonText, array_keys($formButtons)) + 7;

                      $formID = null; // Initialize $formID
                      $formIdentifier = null; // Initialize $formIdentifier

                      // Define folder name based on selected language
                      $languageFolder = ($_SESSION['language'] === 'tl') ? 'forms_tagalog/' : 'forms_english/';

                      // Construct file path based on language
                      $formPath = $languageFolder . $formFileName;

                      // Display form buttons with data-form attribute
                      echo '<a href="' . $formPath . '?formID=' . $formID . '" class="open-form"><button class="btn btn-dark m-1" data-form="' . $formFileName . '"><i class="fas fa-file-alt"></i> ' . $buttonText . $formIdentifier . ' </button></a>';
                    }

                    ?>
                  </div>

                </div>

              </div>



              <script>
                document.addEventListener("DOMContentLoaded", function() {
                  const openFormButtons = document.querySelectorAll(".open-form");

                  openFormButtons.forEach(function(button) {
                    button.addEventListener("click", function() {
                      const formFileName = button.getAttribute("data-form");

                      // Get the language from the active button
                      const language = document.querySelector(".active").getAttribute("value");

                      // Construct file path based on language
                      const languageFolder = (language === 'english') ? 'forms_english/' : 'forms_tagalog/';
                      const formPath = languageFolder + formFileName;

                      // Open a new window or modal with the form content
                      openFormWindow(formPath);
                    });
                  });

                });
              </script>



              <hr>
              <div class="columns-container">
                <div class="form-buttons">
                  <div class="form-buttons">
                    <h5>Used Forms</h5>

                    <?php
                    $formButtons = [
                      'KP 7',
                      'KP 8',
                      'KP 9',
                      'KP 10',
                      'KP 11',
                      'KP 12',
                      'KP 13',
                      'KP 14',
                      'KP 15',
                      'KP 16',
                      'KP 17',
                      'KP 18',
                      'KP 19',
                      'KP 20',
                      'KP 21',
                      'KP 22',
                      'KP 23',
                      'KP 24',
                      'KP 25',
                      'KP 20 - A',
                      'KP 20 - B'
                    ];

                    foreach ($formButtons as $buttonText) {
                      $formUsed = array_search($buttonText, $formButtons) + 7; // Assuming a sequential mapping starting from 7

                      // Query to fetch the forms with the same complaint_id, form_used, and hearing_number
                      $query = "SELECT id FROM hearings WHERE complaint_id = :complaintId AND hearing_number = :currentHearing AND form_used = :formUsed";
                      $stmt = $conn->prepare($query);
                      $stmt->bindParam(':complaintId', $_GET['id']);
                      $stmt->bindParam(':currentHearing', $currentHearing);
                      $stmt->bindParam(':formUsed', $formUsed);
                      $stmt->execute();
                      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                      // Display buttons with proper naming for multiple occurrences
                      $counter = 0;
                      foreach ($results as $result) {
                        $counter++;
                        $formID = $result['id'];
                        $formIdentifier = count($results) > 1 ? " ($counter)" : "";
                        $buttonID = 'formButton_' . $formUsed . '_' . $counter;
                        echo '<button class="open-form btn btn-success m-1" id="' . $buttonID . '" data-form-id="' . $formID . '" data-form-used="' . $formUsed . '"><i class="fas fa-file-alt"></i> ' . $buttonText . $formIdentifier . ' </button>';
                      }
                    }
                    ?>
                  </div>


                  <script>
                    // JavaScript to handle button clicks and redirection with formID and formUsed
                    var buttons = document.querySelectorAll('.open-form');
                    buttons.forEach(function(button) {
                      button.addEventListener('click', function() {
                        var formID = this.getAttribute('data-form-id');
                        var formUsed = this.getAttribute('data-form-used');
                        var folderName = '<?php echo $folderName; ?>'; // PHP variable for folder name

                        // Adjust formUsed based on special cases
                        if (formUsed == 26) {
                          formUsed = '20A';
                        } else if (formUsed == 27) {
                          formUsed = '20B';
                        }

                        window.location.href = folderName + '/kp_form' + formUsed + '.php?formID=' + formID;
                      });
                    });
                  </script>
                  <br>
                  <br>
                  <hr>
                  <h5>Signed Forms</h5>


                  <br>


                  <br>
                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . ($_GET['id'] ?? ''); ?>" method="post" enctype="multipart/form-data" class="mb-4">
                    <div class="input-group">

                      <input type="file" class="bg-white rounded-md text-black" name="file" id="file">
                      
                      <button type="submit" class="bg-blue-500 px-2 hover:bg-blue-400 border rounded-md text-white">Upload</button>
                    </div>
                  </form>

                  <?php echo $uploadMessage; ?>

                  <ul class="list-group">
                    <?php foreach ($fileList as $file): ?>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                          <a href="<?php echo $file['file_path']; ?>" target="_blank"><?php echo $file['signed_form']; ?></a>
                        </div>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . ($_GET['id'] ?? ''); ?>" method="post" class="ml-2">
                          <input type="hidden" name="delete_file_id" value="<?php echo $file['id']; ?>">
                          <button type="submit" class="bg-red-500 hover:bg-red-400 px-3 py-2 rounded-md text-white" name="delete_file">Delete</button>
                        </form>
                      </li>
                    <?php endforeach; ?>
                  </ul>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>