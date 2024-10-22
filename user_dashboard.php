  <?php
  session_start();

  include 'connection.php';
  

  if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
  }

  $userID = $_SESSION['user_id'] ?? '';
  $barangay_id = $_SESSION['barangay_id'] ?? '';

  $stmt_casetype_query = "SELECT 
                            SUM(CASE WHEN CType = 'Criminal' AND isArchived = 0 THEN 1 ELSE 0 END) AS criminal_count,
                            SUM(CASE WHEN CType = 'Civil' AND isArchived = 0 THEN 1 ELSE 0 END) AS civil_count,
                            SUM(CASE WHEN CType = 'Others' AND isArchived = 0 THEN 1 ELSE 0 END) AS others_count
                        FROM complaints 
                        WHERE UserID = :user_id AND BarangayID = :barangay_id AND MONTH(Mdate) = MONTH(NOW())";

  $stmt_casetype_count = $conn->prepare($stmt_casetype_query);
  $stmt_casetype_count->bindParam(':user_id', $userID);
  $stmt_casetype_count->bindParam(':barangay_id', $barangay_id);
  $stmt_casetype_count->execute();
  $stmt_casetype_count_temp = $stmt_casetype_count->fetch(PDO::FETCH_ASSOC);

  $natureOfCasesData = [
    'Criminal' => $stmt_casetype_count_temp['criminal_count'] ?? 0,
    'Civil' => $stmt_casetype_count_temp['civil_count'] ?? 0,
    'Others' => $stmt_casetype_count_temp['others_count'] ?? 0
  ];

  // for cases card
  $stmt_casestatus_query = "SELECT 
                            SUM(CASE WHEN CMethod = 'Pending' AND isArchived = 0 THEN 1 END) AS total_pending_count,
                            SUM(CASE WHEN CStatus = 'Unsettled' AND isArchived = 0 THEN 1 END) AS total_unsettled_count,
                            SUM(CASE WHEN CStatus = 'Settled' AND isArchived = 0 THEN 1 END) AS total_settled_count
                        FROM complaints 
                        WHERE UserID = :user_id AND BarangayID = :barangay_id AND MONTH(Mdate) = MONTH(NOW())";

$stmt_casestatus_count = $conn->prepare($stmt_casestatus_query);
$stmt_casestatus_count->bindParam(':user_id', $userID);
$stmt_casestatus_count->bindParam(':barangay_id', $barangay_id);
$stmt_casestatus_count->execute();
$stmt_casestatus_count_temp = $stmt_casestatus_count->fetch(PDO::FETCH_ASSOC);

$totalSettledCount = $stmt_casestatus_count_temp['total_settled_count'] ?? 0;
$totalUnsettledCount = $stmt_casestatus_count_temp['total_unsettled_count'] ?? 0;
$totalPendingCount = $stmt_casestatus_count_temp['total_pending_count'] ?? 0;

  // for summary card
  $stmt_complaint_query = "SELECT 
                            SUM(CASE WHEN MONTH(Mdate) = 1 AND isArchived = 0 THEN 1 END) AS jan,
                            SUM(CASE WHEN MONTH(Mdate) = 2 AND isArchived = 0 THEN 1 END) AS feb,
                            SUM(CASE WHEN MONTH(Mdate) = 3 AND isArchived = 0 THEN 1 END) AS mar,
                            SUM(CASE WHEN MONTH(Mdate) = 4 AND isArchived = 0 THEN 1 END) AS apr,
                            SUM(CASE WHEN MONTH(Mdate) = 5 AND isArchived = 0 THEN 1 END) AS may,
                            SUM(CASE WHEN MONTH(Mdate) = 6 AND isArchived = 0 THEN 1 END) AS jun,
                            SUM(CASE WHEN MONTH(Mdate) = 7 AND isArchived = 0 THEN 1 END) AS july,
                            SUM(CASE WHEN MONTH(Mdate) = 8 AND isArchived = 0 THEN 1 END) AS aug,
                            SUM(CASE WHEN MONTH(Mdate) = 9 AND isArchived = 0 THEN 1 END) AS sep,
                            SUM(CASE WHEN MONTH(Mdate) = 10 AND isArchived = 0 THEN 1 END) AS oct,
                            SUM(CASE WHEN MONTH(Mdate) = 11 AND isArchived = 0 THEN 1 END) AS nov,
                            SUM(CASE WHEN MONTH(Mdate) = 12 AND isArchived = 0 THEN 1 END) AS decs
                        FROM complaints 
                        WHERE UserID = :user_id AND BarangayID = :barangay_id AND YEAR(Mdate) = YEAR(NOW())";

$stmt_complaint_count = $conn->prepare($stmt_complaint_query);
$stmt_complaint_count->bindParam(':user_id', $userID);
$stmt_complaint_count->bindParam(':barangay_id', $barangay_id);
$stmt_complaint_count->execute();
$stmt_complaint_count_temp = $stmt_complaint_count->fetch(PDO::FETCH_ASSOC);

$summaryData = [
  'January' => $stmt_complaint_count_temp['jan'] ?? 0,
  'February' => $stmt_complaint_count_temp['feb'] ?? 0,
  'March' => $stmt_complaint_count_temp['mar'] ?? 0,
  'April' => $stmt_complaint_count_temp['apr'] ?? 0,
  'May' => $stmt_complaint_count_temp['may'] ?? 0,
  'June' => $stmt_complaint_count_temp['jun'] ?? 0,
  'July' => $stmt_complaint_count_temp['july'] ?? 0,
  'August' => $stmt_complaint_count_temp['aug'] ?? 0,
  'September' => $stmt_complaint_count_temp['sep'] ?? 0,
  'October' => $stmt_complaint_count_temp['oct'] ?? 0,
  'November' => $stmt_complaint_count_temp['nov'] ?? 0,
  'December' => $stmt_complaint_count_temp['decs'] ?? 0,
];


  ?>

  <!doctype html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <style>
      .card {
        box-shadow: 0 0 0.3cm rgba(0, 0, 0, 0.2);
        border-radius: 15px;
      }

      .custom-card {
        margin-bottom: 20px;
      }

      .card-text-center {
        text-align: center;
      }

      .settled-card {
        text-align: center;
        background-image: url('img/settled.png');
        background-size: cover;
        background-position: center;
        width: 100%;
      }

      .unsettled-card {
        text-align: center;
        background-image: url('img/unsettled.png');
        background-size: cover;
        background-position: center;
        width: 100%;
      }

      .pending-card {
        text-align: center;
        background-image: url('img/pending.png');
        background-size: cover;
        background-position: center;
        width: 100%;
      }

      .summary-card {
        background-color: white;
        text-align: center;
        background-size: cover;
        background-position: center;
        width: 100%;
      }

      .nature-card {
        background-color: white;
        text-align: center;
        background-size: cover;
        background-position: center;
        width: 100%;
      }

      .ref-card {
        background-color: white;
        background-size: cover;
        color: black;
        /* Default link color */
      }

      .ref-card a:hover {
        color: red;
        /* Change color on hover */
      }

      .seven-card {
        background-image: url('img/official.png');
        background-size: cover;
        background-position: center;
        width: 100%;
        padding-bottom: 56.25%;
        /* 9:16 aspect ratio (16 / 9 * 100%) */
      }

      .five-card {
        background-image: url('img/fb.png');
        background-size: cover;
        background-position: center;
        width: 100%;
        padding-bottom: 56.25%;
        /* 9:16 aspect ratio (16 / 9 * 100%) */
      }

      .eight-card {
        background-image: url('img/ig.png');
        background-size: cover;
        background-position: center;
        width: 100%;
        padding-bottom: 56.25%;
        /* 9:16 aspect ratio (16 / 9 * 100%) */

      }
    </style>

    <script src="node_modules/chart.js/dist/chart.umd.js"></script>

    <script src="node_modules/jquery/dist/jquery.min.js"></script>

    <script src="node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    
    <title>Dashboard</title>

    <link rel="icon" type="image/x-icon" href="img/favicon.ico">

    
  </head>

  <body class="bg-[#E8E8E7]">

    <?php include "user_sidebar_header.php"; ?>

    <div class="p-4 sm:ml-44 ">
      <div class="rounded-lg mt-16">

        <div class="flex items-center my-2">
          <div class="flex-grow border-t border-gray-400"></div>
          <span class="px-2 text-lg text-gray-500">Cases</span>
          <div class="flex-grow border-t border-gray-400"></div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="card settled-card">
              <div class="card-body">
                <!-- Card content goes here -->
                <h5 class="card-title mb-9 fw-semibold" style="color: white; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);">
                  Settled Cases
                </h5>
                <p class="mb-9 fw-semibold" style="color: white; font-size: 40px; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);">
                  <?php
                    echo $totalSettledCount;
                  ?>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card unsettled-card">
              <div class="card-body">
                <!-- Card content goes here -->
                <h5
                  class="card-title mb-9 fw-semibold"
                  style="color: white; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5)">
                  Unsettled Cases
                </h5>

                <p
                  class="mb-9 fw-semibold"
                  style="color: white; font-size: 40px; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5)">
                  <?php
                   echo $totalUnsettledCount;
                  ?>
                </p>

              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card pending-card">
              <div class="card-body">
                <!-- Card content goes here -->
                <h5
                  class="card-title mb-9 fw-semibold"
                  style="color: white; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);">
                  Pending Cases
                </h5>

                <p
                  class="mb-9 fw-semibold"
                  style="color: white; font-size: 40px; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);">
                  <?php
                   echo $totalPendingCount;
                  ?>
                </p>

              </div>
            </div>
          </div>
        </div>
        <!-- New row for the additional card -->
        <div class="row">
          <div class="col-md-6">
            <div class="card summary-card">
              <div class="card-body">
                <!-- Card content goes here -->
                <h5 class="card-title mb-9 fw-semibold" style="color: black;">Summary(<?php echo date('Y'); ?>)</h5>
                <canvas id="complaintsChart" width="800" height="400"></canvas>
                <script>
                  var ctx = document.getElementById('complaintsChart').getContext('2d');
                  var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                      labels:  <?php echo json_encode(array_keys($summaryData))?>,
                      datasets: [{
                        label: 'Number of Complaints',
                        data: <?php echo json_encode($summaryData)?>,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                      }]
                    },
                    options: {
                      scales: {
                        y: {
                          beginAtZero: true
                        }
                      }
                    }
                  });
                </script>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card nature-card">
              <div class="card-body">
                <h5 class="card-title mb-9 fw-semibold" style="color: black;">Nature of Cases(<?php echo date('F Y'); ?>)</h5>
                <canvas id="natureOfCasesChart" width="800" height="400"></canvas>
                <script>
                  // Example data for demonstration
                  var natureOfCases = {
                    "Civil": 10,
                    "Criminal": 5,
                    "Others": 3,
                    // Add more data as needed
                  };

                  var ctx = document.getElementById('natureOfCasesChart').getContext('2d');
                  var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                      labels: <?php echo json_encode(array_keys($natureOfCasesData))?>,
                      datasets: [{
                        label: 'Count',
                        data: <?php echo json_encode($natureOfCasesData)?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                      }]
                    },
                    options: {
                      scales: {
                        y: {
                          beginAtZero: true,
                          title: {
                            display: true,
                            text: 'Count'
                          }
                        },
                        x: {
                          title: {
                            display: true,
                          }
                        }
                      }
                    }
                  });
                </script>
              </div>
            </div>
          </div>
        </div>

        <div class="flex items-center my-2">
          <div class="flex-grow border-t border-gray-400"></div>
          <span class="px-2 text-lg text-gray-500">References & Links</span>
          <div class="flex-grow border-t border-gray-400"></div>
        </div>

        <div class="row">
          <div class="col-md-8">
            <div class="card ref-card">
              <div class="card-body">
                <!-- Card content goes here -->
                <h5 class="card-title mb-9 fw-semibold" style="color: black;">References</h5>
                <a href="links/Related_Laws_Katarungang_Pambarangay_Handbook (1).pdf" download>Related Laws KP Handbook</a><br>
                <a href="links/OFFENSES WITHIN KP_Jurisdiction_for Admin.pptx.pdf" download>Offenses within KP Jurisdiction for Admin</a><br>
                <a href="links/LTIA-FORMS-6-7-1.docx.pdf" download>LTIA-FORMS-6-7-1</a><br>
                <a href="links/KP-for-Atty-Ver.ppt.pdf" download>Revised KP Law</a><br>
                <a href="links/template-conso-report-KP (1).xlsx - Sheet1.pdf" download>Consolidated KP Compliance Report</a><br>
                <a href="links/KATARUNGANG PAMBARANGAY.pptx.pdf" download>DILG Laguna Cluster-A SUB LGRC</a><br>
                <a href="links/KP-Flowchart-with-link-to-KP-Forms_atty-ver.pptx.pdf" download>KP Flowchart with Links</a><br>
                <a href="links/KP actual process_Jurusdictional aspect.pptx.pdf" download>KP Actual Process Jurisdictional Aspect</a><br>
                <a href="links/Katarungang-Pambarangay-2018-v2.pptx.pdf" download>KP 2018 V2</a><br>
                <a href="links/criminal-cases-under-the-jurisdiction-of-KP_atty-ver.pptx.pdf" download>Criminal Cases Under the Jurisdiction of KP</a><br>
                <a href="links/KP-IRR.pdf" download>KP Forms English</a><br>
                <a href="links/543442409-KP-Forms-Tagalog-1.pdf" download>KP Forms Tagalog</a>
              </div>
            </div>
          </div>
          <div class="col-md-4">

            <a href="https://www.dilg.gov.ph/" class="card seven-card overflow-hidden" style="text-decoration: none;" target="_blank"></a>

            <a href="https://www.facebook.com/dilglaguna.clustera.7" class="card five-card overflow-hidden" style="text-decoration: none;" target="_blank"></a>

            <a href="https://www.instagram.com/dilgr4a/" class="card eight-card overflow-hidden" style="text-decoration: none;" target="_blank"></a>
          </div>
        </div>
      </div>
    </div>
    </div>
  </body>

  </html>