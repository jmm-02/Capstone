<?php
session_start();
include 'connection.php';


if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
  header("Location: login.php");
  exit;
}

$userID = $_SESSION['user_id'] ?? '';
$barangay_id = $_SESSION['barangay_id'] ?? '';

// Check if the report_id is provided in the URL
if (isset($_GET['report_id'])) {
  $report_id = $_GET['report_id'];
  // Query to fetch the report data using the report_id
  $query = "SELECT * FROM reports WHERE report_id = :report_id";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':report_id', $report_id);
  $stmt->execute();
  $report = $stmt->fetch(PDO::FETCH_ASSOC);

  // Check if the report exists
  if (!$report) {
    echo "Report not found.";
    exit;
  }

  // Extract the month and year from the report_date
  $report_date = date('F Y', strtotime($report['report_date']));
} else {
  echo "Report ID is missing.";
  exit;
}

if (isset($_POST['update'])) {
  // Retrieve form data
  $report_date = $_POST['report_date'];
  $mayor = $_POST['mayor'];
  $budget = str_replace(',', '', $_POST['budget']); // remove ,
  $totalcase = $_POST['totalcase'];
  $numlupon = $_POST['numlupon'];
  $landarea = $_POST['landarea'];
  $region = $_POST['region'];
  $population = $_POST['population'];
  $male = $_POST['male'];
  $female = $_POST['female'];
  $criminal = $_POST['criminal'];
  $others = $_POST['others'];
  $civil = $_POST['civil'];
  $totalNature = $_POST['totalNature'];
  $media = $_POST['media'];
  $arbit = $_POST['arbit'];
  $concil = $_POST['concil'];
  $totalSet = $_POST['totalSet'];
  $pending = $_POST['pending'];
  $repudiated = $_POST['repudiated'];
  $dropped = $_POST['dropped'];
  $outsideBrgy = $_POST['outsideBrgy'];
  $dismissed = $_POST['dismissed'];
  $certcourt = $_POST['certcourt'];
  $totalUnset = $_POST['totalUnset'];

  // Prepare update query
  $update_query = "UPDATE reports SET report_date = :report_date, mayor = :mayor, budget = :budget, totalcase = :totalcase, numlupon = :numlupon, landarea = :landarea, region = :region, population = :population, male = :male, female = :female, criminal = :criminal, others = :others, civil = :civil, totalNature = :totalNature, media = :media, arbit = :arbit, concil = :concil, totalSet = :totalSet, pending = :pending, repudiated = :repudiated, dropped = :dropped, outsideBrgy = :outsideBrgy, dismissed = :dismissed, certcourt = :certcourt, totalUnset = :totalUnset WHERE report_id = :report_id";

  // Prepare and execute the update query
  $stmt = $conn->prepare($update_query);
  $stmt->bindParam(':report_date', $report_date);
  $stmt->bindParam(':mayor', $mayor);
  $stmt->bindParam(':budget', $budget);
  $stmt->bindParam(':totalcase', $totalcase);
  $stmt->bindParam(':numlupon', $numlupon);
  $stmt->bindParam(':landarea', $landarea);
  $stmt->bindParam(':region', $region);
  $stmt->bindParam(':population', $population);
  $stmt->bindParam(':male', $male);
  $stmt->bindParam(':female', $female);
  $stmt->bindParam(':criminal', $criminal);
  $stmt->bindParam(':others', $others);
  $stmt->bindParam(':civil', $civil);
  $stmt->bindParam(':totalNature', $totalNature);
  $stmt->bindParam(':media', $media);
  $stmt->bindParam(':arbit', $arbit);
  $stmt->bindParam(':concil', $concil);
  $stmt->bindParam(':totalSet', $totalSet);
  $stmt->bindParam(':pending', $pending);
  $stmt->bindParam(':repudiated', $repudiated);
  $stmt->bindParam(':dropped', $dropped);
  $stmt->bindParam(':outsideBrgy', $outsideBrgy);
  $stmt->bindParam(':dismissed', $dismissed);
  $stmt->bindParam(':certcourt', $certcourt);
  $stmt->bindParam(':totalUnset', $totalUnset);
  $stmt->bindParam(':report_id', $report_id);


  // Execute the update query
  if ($stmt->execute()) {
    $message = "Report updated successfully";
    // Fetch the updated report data from the database
    $query = "SELECT * FROM reports WHERE report_id = :report_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':report_id', $report_id);
    $stmt->execute();
    $report = $stmt->fetch(PDO::FETCH_ASSOC);
  } else {
    $message = "Failed to update report";
  }
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reports</title>
  <link rel="shortcut icon" type="image/png" href=".assets/images/logos/favicon.png" />
  
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

      <!--  Row 1 -->
      <div class="row">
        <div class="col-lg-7 d-flex align-items-strech">
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

                  <h5 class="card-title mb-9 fw-semibold">Edit Report of <?php echo $report_date; ?> </h5>
                  <h6 class="text-success"> <?php if (isset($message)) {
                                              echo $message;
                                            } ?></h6>

                  <div style="display: flex; align-items: center;">

                    <form method="POST">
                      <div>
                        <label for="report_date">Report Date:</label>
                        <!-- Display the report_date in the input field -->
                        <input style="width:100%;" type="date" class="form-control" id="report_date" name="report_date" value="<?php echo $report['report_date']; ?>" required onchange="fetchReportData()">
                      </div>

                      <!-- Define field sections -->
                      <?php
                      $sections = [
                        'Basic Information' => ['mayor', 'budget', 'totalcase', 'numlupon', 'landarea', 'region', 'population', 'male', 'female'],
                        'Nature of Cases' => ['criminal', 'others', 'civil', 'totalNature'],
                        'Action Taken - Settled' => ['media', 'arbit', 'concil', 'totalSet'],
                        'Action Taken - Unsettled' => ['pending', 'repudiated', 'dropped', 'outsideBrgy', 'dismissed', 'certcourt', 'totalUnset']
                      ];

                      foreach ($sections as $sectionTitle => $fields) {
                        echo '<div class="row">';
                        echo '<b>' . $sectionTitle . '</b>';
                        foreach ($fields as $field) {
                          echo '<div class="col-md-6">';
                          echo '<div class="form-group">';
                          echo '<label for="' . $field . '">' . ucwords(str_replace('_', ' ', $field)) . ':</label>';
                          // Check if the field should be of type "text" or "number"
                          $inputType = in_array($field, ['mayor', 'budget', 'landarea', 'region', 'population']) ? 'text' : 'number';
                          echo '<input type="' . $inputType . '" class="form-control" id="' . $field . '" name="' . $field . '" value="' . $report[$field] . '" required>';
                          echo '</div>';
                          echo '</div>';
                        }
                        echo '</div>';
                        echo '<br>';
                      }
                      ?>

                      <input type="submit" class="bg-blue-500 hover:bg-blue-400 px-3 py-2 rounded-md text-white" name="update" value="Update">
                    </form>


                  </div>
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