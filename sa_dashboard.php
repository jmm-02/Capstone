<?php
session_start();

// Ensure the user is a superadmin
include 'connection.php';



// Check if the user is a superadmin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'superadmin') {
    header("Location: login.php");
    exit;
}

// Calculate the current quarter start and end dates
$currentMonth = date('n');
$year = date('Y');

// Determine the start and end months of the current quarter
if ($currentMonth >= 1 && $currentMonth <= 3) {
    $startDate = "$year-01-01";
    $endDate = "$year-03-31";
} elseif ($currentMonth >= 4 && $currentMonth <= 6) {
    $startDate = "$year-04-01";
    $endDate = "$year-06-30";
} elseif ($currentMonth >= 7 && $currentMonth <= 9) {
    $startDate = "$year-07-01";
    $endDate = "$year-09-30";
} else {
    $startDate = "$year-10-01";
    $endDate = "$year-12-31";
}

// Query to get quarterly consolidated complaints by municipality, including those with 0 complaints
$query = "
    SELECT 
        m.municipality_name,
        COUNT(c.id) AS total_complaints
    FROM 
        municipalities m
    LEFT JOIN 
        barangays b ON m.id = b.municipality_id
    LEFT JOIN 
        complaints c ON b.id = c.BarangayID AND c.MDate BETWEEN :startDate AND :endDate
    WHERE 
        m.municipality_name != 'Sample Municipality'
    GROUP BY 
        m.municipality_name
    ORDER BY 
        m.municipality_name ASC
";

$stmt = $conn->prepare($query);
$stmt->bindParam(':startDate', $startDate);
$stmt->bindParam(':endDate', $endDate);
$stmt->execute();
$complaintData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Define an array of colors for each municipality
$colors = [
    '#FF5733', // Red-Orange
    '#33FF57', // Green
    '#3357FF', // Blue
    '#F333FF', // Pink
    '#33FFF5', // Cyan
    '#FF33A6', // Magenta
    '#FF8F33', // Orange
    '#C70039', // Crimson
    '#900C3F', // Dark Red
    '#581845', // Purple
];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet" href="assets/css/styles.min.css" />
 
    <style>
        .card {
            box-shadow: 0 0 0.3cm rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            margin-bottom: 20px;
        }
        .card-text-center {
            text-align: center;
        }
        .custom-card {
            width: 100%;
            color: white;
            text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);
        }
    </style>
</head>

<body class="bg-[#E8E8E7]">

<?php include "sa_sidebar_header.php"; ?>

<div class="p-4 sm:ml-44">
    <div class="rounded-lg mt-16">
        <div class="row">
            <?php 
            $colorIndex = 0; // Initialize a color index
            foreach ($complaintData as $data): 
                // Rotate through the color array
                $color = $colors[$colorIndex % count($colors)];
                $colorIndex++;
            ?>
                <div class="col-md-4">
                    <div class="card custom-card" style="background-color: <?= htmlspecialchars($color) ?>;">
                        <div class="card-body">
                            <h5 class="card-title mb-9 fw-semibold">
                                <?= htmlspecialchars($data['municipality_name']) ?>
                            </h5>
                            <p class="mb-9 fw-semibold" style="font-size: 40px;">
                                <?= htmlspecialchars($data['total_complaints']) ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

</body>
</html>
