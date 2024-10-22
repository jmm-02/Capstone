<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $stmt = $conn->prepare("SELECT mayor, region, budget, population, landarea, totalcase, numlupon, male, female, criminal, civil, others, totalNature, media, concil, arbit, totalSet, pending, dismissed, repudiated, certcourt, dropped, totalUnset, outsideBrgy FROM reports WHERE user_id = :user_id AND barangay_id = :barangay_id ORDER BY report_date DESC LIMIT 1");
$stmt->bindParam(':user_id', $userID);
$stmt->bindParam(':barangay_id', $barangay_id);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

       // Assign fetched data to variables
    $mayor = $row['mayor'] ?? '';
    $region = $row['region'] ?? '';
    $budget = $row['budget'] ?? '';
    $population = $row['population'] ?? '';
    $landarea = $row['landarea'] ?? '';
    $totalc = $row['totalcase'] ?? '';
    $numlup = $row['numlupon'] ?? '';
    $male = $row['male'] ?? '';
    $female = $row['female'] ?? '';
    $criminalCount = $row['criminal'] ?? '';
    $civilCount = $row['civil'] ?? '';
    $othersCount = $row['others'] ?? '';
    $natureSum = $row['totalNature'] ?? '';
    $mediationCount = $row['media'] ?? '';
    $conciliationCount = $row['concil'] ?? '';
    $arbitrationCount = $row['arbit'] ?? '';
    $totalSettledCount = $row['totalSet'] ?? '';
    $totalOutsideCount = $row['outsideBrgy'] ?? '';
    $pendingCount = $row['pending'] ?? '';
    $dismissedCount = $row['dismissed'] ?? '';
    $repudiatedCount = $row['repudiated'] ?? '';
    $certifiedCount = $row['certcourt'] ?? '';
    $droppedCount = $row['dropped'] ?? '';
    $totalUnsetCount = $row['totalUnset'] ?? '';

$months_query = $conn->prepare("SELECT DISTINCT DATE_FORMAT(report_date, '%M %Y') AS month_year FROM reports WHERE user_id = :user_id");
$months_query->execute(['user_id' => $userID]);
$months = $months_query->fetchAll(PDO::FETCH_ASSOC);

$years_query = $conn->prepare("SELECT DISTINCT DATE_FORMAT(report_date, '%Y') AS year FROM reports WHERE user_id = :user_id");
$years_query->execute(['user_id' => $userID]);
$years = $years_query->fetchAll(PDO::FETCH_ASSOC);



// Set a default value for selected_month if not set
$selected_month = isset($_POST['selected_month']) ? $_POST['selected_month'] : date('F Y');

$selected_year = isset($_POST['selected_year']) ? $_POST['selected_year'] : date('Y');

// Function to fetch annual report data
function fetchAnnualReportData($conn, $userID, $selected_year) {
    $annual_report_query = $conn->prepare("SELECT 
            SUM(totalcase) AS totalcase_sum,
            SUM(criminal) AS criminal_sum,
            SUM(civil) AS civil_sum,
            SUM(others) AS others_sum,
            SUM(totalNature) AS totalNature_sum,
            SUM(media) AS media_sum,
            SUM(concil) AS concil_sum,
            SUM(arbit) AS arbit_sum,
            SUM(totalSet) AS totalSet_sum,
            SUM(pending) AS pending_sum,
            SUM(dismissed) AS dismissed_sum,
            SUM(repudiated) AS repudiated_sum,
            SUM(certcourt) AS certcourt_sum,
            SUM(dropped) AS dropped_sum,
            SUM(totalUnset) AS totalUnset_sum,
            SUM(outsideBrgy) AS outsideBrgy_sum
            FROM reports
            WHERE user_id = :user_id
            AND YEAR(report_date) = :selected_year");

    $annual_report_query->execute([
        'user_id' => $userID,
        'selected_year' => $selected_year
    ]);

    return $annual_report_query->fetch(PDO::FETCH_ASSOC);
}
// Function to fetch monthly report data
function fetchMonthlyReportData($conn, $userID, $selected_month) {
    $report_query = $conn->prepare("SELECT * FROM reports WHERE user_id = :user_id AND DATE_FORMAT(report_date, '%M %Y') = :selected_month");
    $report_query->execute(['user_id' => $userID, 'selected_month' => $selected_month]);

    return $report_query->fetch(PDO::FETCH_ASSOC);
}

// Function to handle year selection
function handleYearSelection($conn, $userID, &$selected_year, &$annual_report_data) {
    if (isset($_POST['selected_year'])) {
        $selected_year = $_POST['selected_year'];
        $annual_report_data = fetchAnnualReportData($conn, $userID, $selected_year);
    }
}

// Function to handle month selection
function handleMonthSelection($conn, $userID, &$selected_month, &$report_data) {
    if (isset($_POST['selected_month'])) {
        $selected_month = $_POST['selected_month'];
        $report_data = fetchMonthlyReportData($conn, $userID, $selected_month);
    }
}

// Function to handle default behavior
function handleDefaultBehavior($conn, $userID, &$default_report_data) {
    if (!isset($_POST['selected_year']) && !isset($_POST['selected_month'])) {
        $default_report_query = $conn->prepare("SELECT * FROM reports WHERE user_id = :user_id ORDER BY report_date DESC LIMIT 1");
        $default_report_query->execute(['user_id' => $userID]);
        $default_report_data = $default_report_query->fetch(PDO::FETCH_ASSOC);
    }
}

// Usage
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    handleYearSelection($conn, $userID, $selected_year, $annual_report_data);
    handleMonthSelection($conn, $userID, $selected_month, $report_data);
    handleDefaultBehavior($conn, $userID, $default_report_data);

    // Update displayed data based on the selected options
    // Adjust the values displayed in the input fields based on selected_month and selected_year

    // Check if the "Annual Report" select button is pressed
  if (isset($_POST['submit_annual'])) {
        $annual_report_data = fetchAnnualReportData($conn, $userID, $selected_year);
        $selected_year = $_POST['selected_year'];

        // Fetch annual report data for the selected year

        // Assign fetched annual report data to the corresponding variables

        $mayor = $report_data['mayor'];
        $region = $report_data['region'];
        $budget = $report_data['budget'];
        $population = $report_data['population'];
        $landarea = $report_data['landarea'];
        $male = $report_data['male'];
        $female = $report_data['female'];
        $numlup = $report_data['numlupon'];

        
        $criminalCount = $annual_report_data['criminal_sum'] ?? '';
        $civilCount = $annual_report_data['civil_sum'] ?? '';
        $othersCount = $annual_report_data['others_sum'] ?? '';
        $natureSum = $annual_report_data['totalNature_sum'] ?? '';
        $mediationCount = $annual_report_data['media_sum'] ?? '';
        $conciliationCount = $annual_report_data['concil_sum'] ?? '';
        $arbitrationCount = $annual_report_data['arbit_sum'] ?? '';

        $natureSum = $annual_report_data['totalNature_sum'] ?? '';
        $totalSettledCount = $annual_report_data['totalSet_sum'] ?? '';
        $pendingCount = $annual_report_data['pending_sum'] ?? '';
        $dismissedCount = $annual_report_data['dismissed_sum'] ?? '';
        $repudiatedCount = $annual_report_data['repudiated_sum'] ?? '';
        $certifiedCount = $annual_report_data['certcourt_sum'] ?? '';
        $droppedCount = $annual_report_data['dropped_sum'] ?? '';

        $totalUnsetCount = $annual_report_data['totalUnset_sum'] ?? '';
        $outsideJurisdictionCount = $annual_report_data['outsideBrgy_sum'] ?? '';
        
    }
    elseif (isset($_POST['submit_monthly'])) {

         $s_mayor = $report_data['mayor'] ?? '';
    $s_region = $report_data['region'] ?? '';
    $s_budget = $report_data['budget'] ?? '';
    $s_population = $report_data['population'] ?? '';
    $s_landarea = $report_data['landarea'] ?? '';
    $s_male = $report_data['male'] ?? '';
    $s_female = $report_data['female'] ?? '';
    $s_totalc = $report_data['totalcase'] ?? '';
    $s_numlup = $report_data['numlupon'] ?? '';
    $s_criminal = $report_data['criminal'] ?? '';
    $s_civil = $report_data['civil'] ?? '';
    $s_others = $report_data['others'] ?? '';
    $s_totalNature = $report_data['totalNature'] ?? '';
    $s_mediation = $report_data['media'] ?? '';
    $s_conciliation = $report_data['concil'] ?? '';
    $s_arbit = $report_data['arbit'] ?? '';
    $s_totalSet = $report_data['totalSet'] ?? '';
    $s_pending = $report_data['pending'] ?? '';
    $s_dismissed = $report_data['dismissed'] ?? '';
    $s_repudiated = $report_data['repudiated'] ?? '';
    $s_dropped = $report_data['dropped'] ?? '';
    $s_totalUnset = $report_data['totalUnset'] ?? '';
    $s_outside = $report_data['outsideBrgy'] ?? '';
    $s_certified = $report_data['certcourt'] ?? '';

    }
}
} ?>