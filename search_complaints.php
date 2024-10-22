<?php
include 'connection.php';

if (isset($_GET['search'])) {
    $search = $_GET['search'];

    // Modify your SQL query to search for matching rows
    $query = "SELECT * FROM complaints WHERE UserID = '$userID' AND IsArchived = 0 AND (CNum LIKE '%$search%' OR ForTitle LIKE '%$search%' OR CNames LIKE '%$search%' OR RspndtNames LIKE '%$search%')";
    $result = $conn->query($query);

    $data = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }

    // Return the results as JSON
    header('Content-Type: application/json');
    echo json_encode($data);
}
?>
