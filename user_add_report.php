<?php
session_start();
include 'connection.php';



if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
  header("Location: login.php");
  exit;
}

$userID = $_SESSION['user_id'] ?? '';
$barangay_id = $_SESSION['barangay_id'] ?? '';

// Check if there's a delete message to display
$delete_message = isset($_SESSION['delete_message']) ? $_SESSION['delete_message'] : "";
unset($_SESSION['delete_message']); // Clear the delete message after displaying it

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
  // Retrieve form data
  $report_date = $_POST['report_date'];
  $mayor = $_POST['mayor'];
  $region = $_POST['region'];
  $budget = str_replace(',', '', $_POST['budget']); // remove ,
  $population = $_POST['population'];
  $totalcase = $_POST['totalcase'];
  $numlupon = $_POST['numlupon'];
  $male = $_POST['male'];
  $female = $_POST['female'];
  $landarea = $_POST['landarea'];
  $criminal = $_POST['criminal'];
  $civil = $_POST['civil'];
  $others = $_POST['others'];
  $totalNature = $_POST['totalNature'];
  $media = $_POST['media'];
  $concil = $_POST['concil'];
  $arbit = $_POST['arbit'];
  $totalSet = $_POST['totalSet'];
  $pending = $_POST['pending'];
  $dismissed = $_POST['dismissed'];
  $repudiated = $_POST['repudiated'];
  $certcourt = $_POST['certcourt'];
  $dropped = $_POST['dropped'];
  $totalUnset = $_POST['totalUnset'];
  $outsideBrgy = $_POST['outsideBrgy'];

  // Check if a report already exists for the specified month and year
  $existing_report_query = "SELECT * FROM reports WHERE user_id = :user_id AND barangay_id = :barangay_id AND MONTH(report_date) = MONTH(:report_date) AND YEAR(report_date) = YEAR(:report_date)";
  $stmt = $conn->prepare($existing_report_query);
  $stmt->bindParam(':user_id', $userID);
  $stmt->bindParam(':barangay_id', $barangay_id);
  $stmt->bindParam(':report_date', $report_date);
  $stmt->execute();
  $existing_report = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($existing_report) {
    // Report already exists for the specified month and year
    $message = "A report already exists for " . date('F Y', strtotime($report_date));
  } else {

    // Insert new row into the reports table
    $insert_query = "INSERT INTO reports (user_id, barangay_id, report_date, mayor, region, municipality, budget, population, totalcase, numlupon, male, female, landarea, criminal, civil, others, totalNature, media, concil, arbit, totalSet, pending, dismissed, repudiated, certcourt, dropped, totalUnset, outsideBrgy)
                         VALUES (:user_id, :barangay_id, :report_date, :mayor, :region, :municipality, :budget, :population, :totalcase, :numlupon, :male, :female, :landarea, :criminal, :civil, :others, :totalNature, :media, :concil, :arbit, :totalSet, :pending, :dismissed, :repudiated, :certcourt, :dropped, :totalUnset, :outsideBrgy)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bindParam(':user_id', $userID);
    $stmt->bindParam(':barangay_id', $barangay_id);
    $stmt->bindParam(':report_date', $report_date);
    $stmt->bindParam(':mayor', $mayor);
    $stmt->bindParam(':region', $region);
    $stmt->bindParam(':municipality', $_SESSION['municipality_name']); // add this for municipality
    $stmt->bindParam(':budget', $budget);
    $stmt->bindParam(':population', $population);
    $stmt->bindParam(':totalcase', $totalcase);
    $stmt->bindParam(':numlupon', $numlupon);
    $stmt->bindParam(':male', $male);
    $stmt->bindParam(':female', $female);
    $stmt->bindParam(':landarea', $landarea);
    $stmt->bindParam(':criminal', $criminal);
    $stmt->bindParam(':civil', $civil);
    $stmt->bindParam(':others', $others);
    $stmt->bindParam(':totalNature', $totalNature);
    $stmt->bindParam(':media', $media);
    $stmt->bindParam(':concil', $concil);
    $stmt->bindParam(':arbit', $arbit);
    $stmt->bindParam(':totalSet', $totalSet);
    $stmt->bindParam(':pending', $pending);
    $stmt->bindParam(':dismissed', $dismissed);
    $stmt->bindParam(':repudiated', $repudiated);
    $stmt->bindParam(':certcourt', $certcourt);
    $stmt->bindParam(':dropped', $dropped);
    $stmt->bindParam(':totalUnset', $totalUnset);
    $stmt->bindParam(':outsideBrgy', $outsideBrgy);

    if ($stmt->execute()) {
      $message = "Report added successfully";
    } else {
      $message = "Failed to add report";
    }
  }
}


?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reports</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
  
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

                  <h5 class="card-title mb-9 fw-semibold">Add Existing Report </h5>
                  <h6 class="text-success"> <?php if (isset($message)) {
                                              echo $message;
                                            } elseif (!empty($delete_message)) {
                                              echo '<div class="alert alert-danger" role="alert">' . $delete_message . '</div>';
                                            } ?></h6>

                  <div style="display: flex; align-items: center;">

                    <form method="POST">
                      <div>
                        <label for="report_date">Report Date:</label>
                        <input style="width:100%;" type="date" class="form-control" id="report_date" name="report_date" value="" required onchange="fetchReportData()">
                      </div>
                      <script>
                        function fetchReportData() {
                          // Get the selected report date
                          var selectedDate = document.getElementById('report_date').value;

                          // Extract the year from the selected date
                          var selectedYear = (new Date(selectedDate)).getFullYear();

                          // Make an AJAX request to fetch data based on the selected year
                          var xhr = new XMLHttpRequest();
                          xhr.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                              var data = JSON.parse(this.responseText);
                              // Update input values for 'Basic Information' fields
                              document.getElementById('mayor').value = data.mayor;
                              document.getElementById('budget').value = data.budget;
                              document.getElementById('landarea').value = data.landarea;
                              document.getElementById('region').value = data.region;
                              document.getElementById('population').value = data.population;
                              document.getElementById('numlupon').value = data.numlupon;

                              // Repeat similar steps for other sections if needed
                            }
                          };
                          xhr.open('GET', 'fetch_data.php?year=' + selectedYear, true);
                          xhr.send();
                        }
                      </script>
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
                          $inputType = in_array($field, ['mayor', 'budget', 'landarea', 'region', 'population', 'numlupon']) ? 'text' : 'number';
                          echo '<input type="' . $inputType . '" class="form-control" id="' . $field . '" name="' . $field . '" value="" required>';
                          echo '</div>';
                          echo '</div>';
                        }
                        echo '</div>';
                        echo '<br>';
                      }

                      ?>

                      <input type="submit" class="bg-gray-800 hover:bg-gray-700 px-3 py-2 rounded-md text-white" name="submit" value="Submit">
                    </form>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="row">
            <div class="col-lg-12">
              <div class="card overflow-hidden">
                <div class="card-body p-4">

                  Existing Reports:
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Report Date</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      // Fetch existing reports from the database
                      $existing_reports_query = "SELECT * FROM reports WHERE user_id = :user_id AND barangay_id = :barangay_id";
                      $stmt = $conn->prepare($existing_reports_query);
                      $stmt->bindParam(':user_id', $userID);
                      $stmt->bindParam(':barangay_id', $barangay_id);
                      $stmt->execute();
                      $existing_reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

                      foreach ($existing_reports as $report) {
                        echo '<tr>';
                        // Format report_date as "Month Year"
                        $formatted_date = date('F Y', strtotime($report['report_date']));
                        echo '<td>' . $formatted_date . '</td>';
                        echo '<td>';
                        // Edit button
                        echo '<a href="user_edit_report.php?report_id=' . $report['report_id'] . '" class="btn btn-primary btn-sm">Edit</a>';
                        // Delete button
                        echo '<a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $report['report_id'] . ');">Delete</a>';
                        echo '</td>';
                        echo '</tr>';
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</body>
<!-- Add a JavaScript function to display a confirmation dialog -->
<script>
  function confirmDelete(reportId) {
    if (confirm('Are you sure you want to delete this report?')) {
      window.location.href = 'delete_report.php?report_id=' + reportId;
    }
  }
</script>

</html>