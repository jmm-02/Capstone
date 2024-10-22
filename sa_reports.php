<?php
session_start();
include 'connection.php';


// Check if the user is a superadmin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'superadmin') {
  header("Location: login.php");
  exit;
}

$selectedMonth = ''; // Initialize the variable
$searchedMunicipality = ''; // Initialize search variable
$sortQuery = ''; // Initialize sorting query

// Handling search functionality
if (isset($_POST['search'])) {
  $searchedMunicipality = $_POST['municipality']; // Get the searched municipality
  $selectedMonth = $_POST['selected_month']; // Get the selected month
  $selectedMonth = date('Y-m', strtotime($selectedMonth)); // Convert selected month to YYYY-MM format
}

// Determine sorting based on URL parameter
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'municipality_asc'; // Default sort
switch ($sort) {
  case 'settled_asc':
    $sortQuery = "Settled ASC";
    break;
  case 'settled_desc':
    $sortQuery = "Settled DESC";
    break;
  case 'unsettled_asc':
    $sortQuery = "Unsettled ASC";
    break;
  case 'unsettled_desc':
    $sortQuery = "Unsettled DESC";
    break;
  default:
    $sortQuery = "m.municipality_name ASC"; // Default sort by municipality name
}

// SQL query to get complaints status per municipality
$stmt = $conn->prepare("
    SELECT m.id AS municipality_id, m.municipality_name,
    COALESCE(SUM(CASE WHEN c.CStatus = 'Settled' THEN 1 ELSE 0 END), 0) AS Settled,
    COALESCE(SUM(CASE WHEN c.CStatus != 'Settled' THEN 1 ELSE 0 END), 0) AS Unsettled
    FROM municipalities m
    LEFT JOIN barangays b ON m.id = b.municipality_id
    LEFT JOIN complaints c ON b.id = c.BarangayID
    WHERE m.municipality_name LIKE :municipality
    GROUP BY m.id
    ORDER BY $sortQuery
");

$stmt->bindValue(':municipality', '%' . $searchedMunicipality . '%', PDO::PARAM_STR);
$stmt->execute();
$municipalities = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reports</title>
  <link rel="icon" type="image/x-icon" href="img/favicon.ico">
  <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>

<body class="bg-[#E8E8E7]">
  <?php include "sa_sidebar_header.php"; ?>
  <div class="p-4 sm:ml-44 ">
    <div class="rounded-lg mt-16">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <img src="img/cluster.png" alt="Logo" style="max-width: 120px; max-height: 120px; margin-right: 10px;" class="align-middle">
            <div>
              <h5 class="card-title mb-2 fw-semibold">Department of the Interior and Local Government</h5>
            </div>
          </div>
          <br>
          <h5 class="card-title mb-9 fw-semibold">Report Overview</h5>
          <hr>
          <b><br>
            <form method="POST">
              <div class="search-wrapper">
                <input type="text" name="municipality" placeholder="Search Municipality" value="<?php echo $searchedMunicipality; ?>">
                <button type="submit" name="search" class="btn-light search-btn">
                  <i class="fas fa-search"></i></button>
              </div><br><br>
              <!-- Month and year dropdown -->
              <div class="select-and-clear-container">
                <select name="selected_month">
                  <?php
                  // Loop through months and years to generate options for the last 12 months
                  for ($i = 0; $i < 12; $i++) {
                    $timestamp = strtotime("-$i months");
                    $monthYear = date('F Y', $timestamp);
                    $value = date('Y-m', $timestamp);
                  ?>
                    <option value="<?php echo $value; ?>"><?php echo $monthYear; ?></option>
                  <?php } ?>
                </select><br><br>
                <input type="submit" name="clear" value="Clear" formnovalidate>
              </div>
            </form>
            <h1><?php echo $selectedMonth; ?></h1>
            <div class="columns-container">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="padding: 8px; background-color: #d3d3d3;">Municipality</th>
                    <th style="padding: 8px; background-color: #d3d3d3;">
                      Settled
                      <a href="?sort=settled_asc">&#8593;</a> <!-- Ascending -->
                      <a href="?sort=settled_desc">&#8595;</a> <!-- Descending -->
                    </th>
                    <th style="padding: 8px; background-color: #d3d3d3;">
                      Unsettled
                      <a href="?sort=unsettled_asc">&#8593;</a> <!-- Ascending -->
                      <a href="?sort=unsettled_desc">&#8595;</a> <!-- Descending -->
                    </th>
                    <th style="padding: 8px; background-color: #d3d3d3;">Actions</th> <!-- New Actions Column -->
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($municipalities as $row) { ?>
                    <tr>
                      <td><?php echo $row['municipality_name']; ?></td>
                      <td><?php echo $row['Settled']; ?></td>
                      <td><?php echo $row['Unsettled']; ?></td>
                      <td>
                        <a href="sa_viewreport.php?municipality_id=<?php echo $row['municipality_id']; ?>" class="btn btn-primary">View Report</a>
                      </td> <!-- Action button -->
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </b>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
