<?php 
// Initialize the linkedNames array
$linkedNames = array();

// Get the current year
$currentYear = date('Y');

// Check if the user has a row in the lupons table for the current year
$checkRowQuery = "SELECT COUNT(*) FROM lupons WHERE user_id = :user_id AND YEAR(created_at) = :current_year";
$checkRowStmt = $conn->prepare($checkRowQuery);
$checkRowStmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
$checkRowStmt->bindParam(':current_year', $currentYear, PDO::PARAM_INT);
$checkRowStmt->execute();
$rowCount = $checkRowStmt->fetchColumn();

if ($rowCount === 0) {
    // If no row exists for the current year, create a new row for the user for the current year
    $createRowQuery = "INSERT INTO lupons (user_id, created_at) VALUES (:user_id, NOW())";
    $createRowStmt = $conn->prepare($createRowQuery);
    $createRowStmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
    $createRowStmt->execute();
}

// Handle form submission only for the current year's row
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_SESSION['user_id'];

    // Ensure that only unique values are saved
    if (isset($_POST['linked_name']) && is_array($_POST['linked_name'])) {
        $linkedNames = array_unique($_POST['linked_name']);

        // Reorganize the array so that it starts from 1 and has no gaps
        $linkedNames = array_values($linkedNames);

        // Fill any missing values with null
        $linkedNames = array_pad($linkedNames, 20, null);
    } else {
        // Handle the case where $_POST['linked_name'] doesn't exist or is not an array
        // You might want to define a default behavior here, like initializing it with empty values
        $linkedNames = array_pad([], 20, null);
    }

    // Get the values of "Punong Barangay" and "Lupon Chairman" from POST
    $punongBarangay = $_POST['punong_barangay'] ?? '';
    $luponChairman = $_POST['lupon_chairman'] ?? '';

    try {
        // Use prepared statements to update the database for the current year's row
        $stmt = $conn->prepare("UPDATE lupons SET 
                                name1 = :name1, name2 = :name2, name3 = :name3, name4 = :name4, name5 = :name5, 
                                name6 = :name6, name7 = :name7, name8 = :name8, name9 = :name9, name10 = :name10,
                                name11 = :name11, name12 = :name12, name13 = :name13, name14 = :name14, name15 = :name15,
                                name16 = :name16, name17 = :name17, name18 = :name18, name19 = :name19, name20 = :name20,
                                punong_barangay = :punong_barangay, lupon_chairman = :lupon_chairman
                                WHERE user_id = :user_id AND YEAR(created_at) = :current_year AND appoint = 0");


        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':current_year', $currentYear, PDO::PARAM_INT);
        for ($i = 1; $i <= 20; $i++) {
            $paramName = ":name" . $i;
            $stmt->bindParam($paramName, $linkedNames[$i - 1], PDO::PARAM_STR);
        }
        $stmt->bindParam(':punong_barangay', $punongBarangay, PDO::PARAM_STR);
        $stmt->bindParam(':lupon_chairman', $luponChairman, PDO::PARAM_STR);

        $stmt->execute();

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    if (isset($_POST['appoint'])) {
        // Get the values of "Punong Barangay" and "Lupon Chairman" from POST
    $punongBarangay = $_POST['punong_barangay'];
    $luponChairman = $_POST['lupon_chairman'];

   $checkAppointQuery = "SELECT COUNT(*) FROM lupons WHERE user_id = :user_id AND YEAR(created_at) = YEAR(NOW()) AND appoint = 1";
            $checkAppointStmt = $conn->prepare($checkAppointQuery);
            $checkAppointStmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
            $checkAppointStmt->execute();
            $rowCount = $checkAppointStmt->fetchColumn();

    if ($rowCount === 0) {
    
         $createAppointQuery1 = "INSERT INTO lupons (user_id, appoint, name1, name2, name3, name4, name5, name6, name7, name8, name9, name10, name11, name12, name13, name14, name15, name16, name17, name18, name19, name20, punong_barangay, lupon_chairman) VALUES (:user_id, 1, :name1, :name2, :name3, :name4, :name5, :name6, :name7, :name8, :name9, :name10, :name11, :name12, :name13, :name14, :name15, :name16, :name17, :name18, :name19, :name20, :punong_barangay, :lupon_chairman)";
                $createAppointStmt1 = $conn->prepare($createAppointQuery1);
                $createAppointStmt1->bindParam(':user_id', $userID, PDO::PARAM_INT);
                $createAppointStmt1->bindParam(':lupon_chairman', $luponChairman, PDO::PARAM_INT);
                $createAppointStmt1->bindParam(':punong_barangay', $punongBarangay, PDO::PARAM_INT);


        // Assuming you have the names in an array named $linkedNames
        for ($i = 0; $i < count($linkedNames); $i++) {
            $paramName = ":name" . ($i + 1);
            $createAppointStmt1->bindParam($paramName, $linkedNames[$i], PDO::PARAM_STR);
        }

        // Execute both prepared statements to add rows with 'appoint' = 0 and 'appoint' = 1
        $createAppointStmt1->execute();

    } else {
        
            $updateAppointQuery = $conn->prepare("UPDATE lupons SET 
                                name1 = :name1, name2 = :name2, name3 = :name3, name4 = :name4, name5 = :name5, 
                                name6 = :name6, name7 = :name7, name8 = :name8, name9 = :name9, name10 = :name10,
                                name11 = :name11, name12 = :name12, name13 = :name13, name14 = :name14, name15 = :name15,
                                name16 = :name16, name17 = :name17, name18 = :name18, name19 = :name19, name20 = :name20,
                                punong_barangay = :punong_barangay, lupon_chairman = :lupon_chairman
                                WHERE user_id = :user_id AND YEAR(created_at) = YEAR(NOW()) AND appoint = 1");

            $updateAppointQuery->bindParam(':user_id', $userID, PDO::PARAM_INT);
            $updateAppointQuery->bindParam(':lupon_chairman', $luponChairman, PDO::PARAM_STR);
            $updateAppointQuery->bindParam(':punong_barangay', $punongBarangay, PDO::PARAM_STR);

            // Assuming you have the names in an array named $linkedNames
            for ($i = 0; $i < count($linkedNames); $i++) {
                $paramName = ":name" . ($i + 1);
                $updateAppointQuery->bindParam($paramName, $linkedNames[$i], PDO::PARAM_STR);
            }

            $updateAppointQuery->execute();
            }
}

}


// Fetch linked names, Punong Barangay, and Lupon Chairman for the current user and current year
$linkedNamesQuery = "SELECT name1, name2, name3, name4, name5, name6, name7, name8, name9, name10,
                         name11, name12, name13, name14, name15, name16, name17, name18, name19, name20,
                         punong_barangay, lupon_chairman
                     FROM lupons
                     WHERE user_id = :user_id AND YEAR(created_at) = :current_year";
$linkedNamesStmt = $conn->prepare($linkedNamesQuery);
$linkedNamesStmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
$linkedNamesStmt->bindParam(':current_year', $currentYear, PDO::PARAM_INT);
$linkedNamesStmt->execute();
$linkedNames = $linkedNamesStmt->fetch(PDO::FETCH_ASSOC);

// Set these values in sessions
$_SESSION['linkedNames'] = $linkedNames;

// Fetch linked names, Punong Barangay, and Lupon Chairman for the current user and current year
$appointedNames = "SELECT name1, name2, name3, name4, name5, name6, name7, name8, name9, name10,
                         name11, name12, name13, name14, name15, name16, name17, name18, name19, name20,
                         punong_barangay, lupon_chairman
                     FROM lupons
                     WHERE user_id = :user_id AND YEAR(created_at) = :current_year AND appoint = 1";

$appointedStmt = $conn->prepare($appointedNames);
$appointedStmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
$appointedStmt->bindParam(':current_year', $currentYear, PDO::PARAM_INT);
$appointedStmt->execute();
$apptNames = $appointedStmt->fetch(PDO::FETCH_ASSOC);

// Set these values in sessions
$_SESSION['apptNames'] = $apptNames;

?>
