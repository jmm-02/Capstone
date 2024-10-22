<?php
// Include the database connection file
include 'connection.php';

// Check if the 'year' parameter is set in the GET request
if(isset($_GET['year'])) {
    // Sanitize and validate the input
    $year = $_GET['year'];
    // You may want to perform additional validation here to ensure $year is a valid year format

    // Prepare and execute the SQL query to fetch data for the given year
    $query = "SELECT mayor, budget, landarea, region, population, numlupon FROM reports WHERE YEAR(report_date) = :year";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the data as an associative array
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if data was found for the given year
    if($data) {
        // Return the data as a JSON response
        echo json_encode($data);
    } else {
        // Initialize an empty array for missing data
        $missingData = array(
            'mayor' => '',
            'budget' => '',
            'landarea' => '',
            'region' => '',
            'population' => '',
            'numlupon' => ''
        );

        // Return the missing data as a JSON response
        echo json_encode($missingData);
    }
} else {
    // 'year' parameter is not set in the GET request
    echo json_encode(array('error' => 'Year parameter is required.'));
}
?>
