<?php
session_start();
include '../connection.php';
$forTitle = $_SESSION['forTitle'] ?? '';
$cNames = $_SESSION['cNames'] ?? '';
$rspndtNames = $_SESSION['rspndtNames'] ?? '';
$cDesc = $_SESSION['cDesc'] ?? '';
$petition = $_SESSION['petition'] ?? '';
$cNum = $_SESSION['cNum'] ?? '';
$punong_barangay = $_SESSION['punong_barangay'] ?? '';

$complaintId = $_SESSION['current_complaint_id'] ?? '';
$currentHearing = $_SESSION['current_hearing'] ?? '';
$formUsed = 9;

// Fetch existing row values if the form has been previously submitted
$query = "SELECT * FROM hearings WHERE complaint_id = :complaintId AND form_used = :formUsed";
$stmt = $conn->prepare($query);
$stmt->bindParam(':complaintId', $complaintId);
$stmt->bindParam(':formUsed', $formUsed);
$stmt->execute();
$rowCount = $stmt->rowCount();

$currentYear = date('Y');

// Array of months
$months = array(
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
);

$currentMonth = date('F');
$currentDay = date('j');

$id = $_GET['formID'] ?? '';

$existingScenario = 0;
$existingScenarioInfo = '';

$existOfficer = '';
// Check if formID exists in the URL
if (!empty($id)) {
    // Fetch data based on the provided formID
    $query = "SELECT appear_date, made_date, received_date, resp_date, officer, scenario, scenario_info FROM hearings WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $rowCount = $stmt->rowCount();

    if ($rowCount > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Extract and format the timestamp values
        $appearDate = new DateTime($row['appear_date']);
        $appear_day = $appearDate->format('j');

        $appear_month = $appearDate->format('F');
        $appear_year = $appearDate->format('Y');
        $appear_time = $appearDate->format('H:i'); // Format for the time input

        $madeDate = new DateTime($row['made_date']);
        $receivedDate = new DateTime($row['received_date']);
        $respDate = new DateTime($row['resp_date']);

        // Populate form inputs with the extracted values
        $currentDay = $appearDate->format('j');
        $currentMonth = $appearDate->format('F');
        $currentYear = $appearDate->format('Y');

        $existingMadeDay = $madeDate->format('j');
        $existingMadeMonth = $madeDate->format('F');
        $existingMadeYear = $madeDate->format('Y');

        $existingReceivedDay = $receivedDate->format('j');
        $existingReceivedMonth = $receivedDate->format('F');
        $existingReceivedYear = $receivedDate->format('Y');

        $existingRespDay = $respDate->format('j');
        $existingRespMonth = $respDate->format('F');
        $existingRespYear = $respDate->format('Y');

        $existOfficer = $row['officer'];
        $existingScenario = $row['scenario'];
        $existingScenarioInfo = $row['scenario_info'];

        $rspndtName1 = ''; // Default to empty strings
        $rspndtName2 = '';
        $rspndtName3 = '';
        $rspndtName4 = '';

        $existScen3 = $existingScenarioInfo; // Default to empty strings
        $existScen4 = $existingScenarioInfo;


        // Echo existing scenario and scenario_info in the corresponding input fields
        if ($existingScenario == 1) {
            $rspndtName1 = $rspndtNames;
        } elseif ($existingScenario == 2) {
            $rspndtName2 = $rspndtNames;
        } elseif ($existingScenario == 3) {
            $rspndtName3 = $rspndtNames;
            $existingScenarioInfo = $row['scenario_info']; // Assign scenario_info for scenario 3
        } elseif ($existingScenario == 4) {
            $rspndtName4 = $rspndtNames;
            $existingScenarioInfo = $row['scenario_info']; // Assign scenario_info for scenario 4
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs
    $madeDay = $_POST['made_day'] ?? '';
    $madeMonth = $_POST['made_month'] ?? '';
    $madeYear = $_POST['made_year'] ?? '';

    $receivedDay = $_POST['received_day'] ?? '';
    $receivedMonth = $_POST['received_month'] ?? '';
    $receivedYear = $_POST['received_year'] ?? '';

    $respDay = $_POST['resp_day'] ?? '';
    $respMonth = $_POST['resp_month'] ?? '';
    $respYear = $_POST['resp_year'] ?? '';

    $officer = $_POST['officer'];

    $day = $_POST['day'] ?? '';
    $month = $_POST['month'] ?? '';
    $year = $_POST['year'] ?? '';
    $time = $_POST['time'] ?? '';

    $scenario = null;
    $scenarioInfo = null;

    if (!empty($_POST['scenario_1'])) {
        $scenario = 1;
        $scenarioInfo = '';
    } elseif (!empty($_POST['scenario_2'])) {
        $scenario = 2;
        $scenarioInfo = '';
    } elseif (!empty($_POST['scenario_3'])) {
        $scenario = 3;
        $scenarioInfo = $_POST['scenario_3a'];
    } elseif (!empty($_POST['scenario_4'])) {
        $scenario = 4;
        $scenarioInfo = $_POST['scenario_4a'];
    }


    $dateTimeString = "$year-$month-$day $time";
    $appearTimestamp = DateTime::createFromFormat('Y-F-j H:i', $dateTimeString);


    if ($appearTimestamp !== false) {
        $appearTimestamp = $appearTimestamp->format('Y-m-d H:i:s');

        // Logic to handle date and time inputs
        $madeDate = createDateFromInputs($madeDay, $madeMonth, $madeYear);
        $receivedDate = createDateFromInputs($receivedDay, $receivedMonth, $receivedYear);
        $respDate = createDateFromInputs($respDay, $respMonth, $respYear);

        $query = "SELECT * FROM hearings WHERE complaint_id = :complaintId AND form_used = :formUsed AND hearing_number = :currentHearing";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':complaintId', $complaintId);
        $stmt->bindParam(':formUsed', $formUsed);
        $stmt->bindParam(':currentHearing', $currentHearing);
        $stmt->execute();
        $existingForm14Count = $stmt->rowCount();


        if ($existingForm14Count > 0) {
            $message = "There is already an existing KP Form 9 in this current hearing.";
        } else {
            // Insert or update the appear_date in the hearings table
            $query = "INSERT INTO hearings (complaint_id, hearing_number, form_used, appear_date, made_date, received_date, resp_date, officer, scenario, scenario_info)
          VALUES (:complaintId, :currentHearing, :formUsed, :appearDate, :madeDate, :receivedDate, :respDate, :officer, :scenario, :scenarioInfo)
          ON DUPLICATE KEY UPDATE
          hearing_number = VALUES(hearing_number),
          form_used = VALUES(form_used),
          appear_date = VALUES(appear_date),
          made_date = VALUES(made_date),
          received_date = VALUES(received_date),
          resp_date = VALUES(resp_date),
          officer = VALUES(officer),
          scenario = VALUES(scenario),
          scenario_info = VALUES(scenario_info)
          ";


            $stmt = $conn->prepare($query);
            $stmt->bindParam(':complaintId', $complaintId);
            $stmt->bindParam(':currentHearing', $currentHearing);
            $stmt->bindParam(':formUsed', $formUsed);
            $stmt->bindParam(':appearDate', $appearTimestamp);
            $stmt->bindParam(':madeDate', $madeDate);
            $stmt->bindParam(':receivedDate', $receivedDate);
            $stmt->bindParam(':respDate', $respDate);
            $stmt->bindParam(':officer', $officer);
            $stmt->bindParam(':scenario', $scenario);
            $stmt->bindParam(':scenarioInfo', $scenarioInfo);

            if ($stmt->execute()) {
                $message = "Form submit successful.";
            } else {
                $message = "Form submit failed.";
            }
        }
    } else {
        // Handle case where DateTime object creation failed
        $message = "Invalid date/time format! Input: " . $dateTimeString;
    }
}

// Function to create a date from day, month, and year inputs
function createDateFromInputs($day, $month, $year)
{
    if (!empty($day) && !empty($month) && !empty($year)) {
        $monthNum = date('m', strtotime("$month 1"));
        return date('Y-m-d', mktime(0, 0, 0, $monthNum, $day, $year));
    } else {
        return date('Y-m-d');
    }
}

function createTimestampFromInputs($day, $month, $year, $time)
{
    if (!empty($day) && !empty($month) && !empty($year) && !empty($time)) {
        return date('Y-m-d H:i:s', strtotime("$year-$month-$day $time"));
    } else {
        return null;
    }
}

// Prepare a new query to fetch 'punong_barangay' and 'lupon_chairman' based on 'user_id'
$luponQuery = "SELECT punong_barangay, lupon_chairman FROM lupons WHERE user_id = :user_id";
$luponStmt = $conn->prepare($luponQuery);
$luponStmt->bindParam(':user_id', $_SESSION['user_id']);
$luponStmt->execute();

// Fetch the lupon data
$luponData = $luponStmt->fetch(PDO::FETCH_ASSOC);

// Check if lupon data is fetched successfully
if ($luponData) {
    // Extract 'punong_barangay' and 'lupon_chairman' from $luponData
    $punong_barangay = $luponData['punong_barangay'];
    $lupon_chairman = $luponData['lupon_chairman'];
} else {
    // If no data found, you can handle it accordingly (e.g., provide default values or display an error message)
    $punong_barangay = '';
    $lupon_chairman = '';
}

include '../form_logo.php';

?>

<!DOCTYPE html>
<html>

<head>
    <title>KP Form 9 English</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

</head>
<style>
    /* Hide the number input arrows */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Hide the number input arrows for Firefox */
    input[type=number] {
        -moz-appearance: textfield;
        border: none;
        width: 40px;
        text-align: center;

    }

    h5 {
        margin: 0;
        padding: 0;
    }

    h3 {
        margin: 0;
        padding: 0;
    }

    .centered-line {
        border-bottom: 1px ridge black;
        display: inline-block;
        min-width: 350px;
        text-align: center;
    }

    .profile-img {
        width: 3cm;
    }

    .header {
        text-align: center;
        padding-inline: 4cm;
    }

    h5 {
        margin: 0;
        padding: 0;
    }

    body {
        background: rgb(204, 204, 204);
    }

    .container {
        margin: 0 auto;
    }

    .paper {
        background: white;
        margin: 0 auto;
        margin-bottom: 0.5cm;
        box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    }

    /* Add Bootstrap responsive classes for different screen sizes */
    @media (min-width: 992px) {
        .paper {
            width: 21cm;
            height: auto;
        }

        .paper[layout="landscape"] {
            width: 29.7cm;
            height: auto;
        }
    }

    @media (min-width: 1200px) {
        .paper[size="A3"] {
            width: 29.7cm;
            height: 42cm;
        }

        .paper[size="A3"][layout="landscape"] {
            width: 42cm;
            height: 29.7cm;
        }

        .paper[size="A5"] {
            width: 14.8cm;
            height: 21cm;
        }

        .paper[size="A5"][layout="landscape"] {
            width: 21cm;
            height: 14.8cm;
        }
    }

    @media print {

        body,
        .paper {
            background: white;
            margin: 0;
            box-shadow: 0;
        }

        /* Adjust print styles here */
        .input-field {
            /* Example: Ensure input fields do not expand beyond their containers */
            max-width: 100%;
        }

        input[name="saveForm"] {
            display: none;
        }

        input[type="text"] {
            border-bottom: 1px solid black !important;
        }

        input[type="text"] {
            border-bottom: 1px solid black !important;
        }
    }

    @media print {
        .page-break {
            page-break-before: always;
        }

        input {
            border-bottom: 1px solid black !important;
        }

        select[name="received_month"] {
            border-bottom: 1px solid black;
            /* Set the desired border style and color */

        }

        /* Hide elements that should not be printed */
        .btn,
        .top-right-buttons {
            display: none !important;
        }

    }

    .bottom-border {
        border: none;
        border-bottom: 1px solid black;
    }

    .page-break {
        page-break-before: always;
    }
</style>

<body>
    <div class="container">
        <div class="paper">
            <div class="top-right-buttons">
                <button class="btn btn-primary print-button common-button" onclick="window.print()" style="position:fixed; right: 20px;">
                    <i class="fas fa-print button-icon"></i> Print
                </button>
                <button class="btn btn-success download-button common-button" id="downloadButton" style="position:fixed; right: 20px; top: 75px; ">
                    <i class="fas fa-file button-icon"></i> Download
                </button>

                <a href="../user_manage_case.php?id=<?php echo $_SESSION['current_complaint_id']; ?>">
                    <button class="btn common-button" style="position:fixed; right: 20px; top: 177px;">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                </a>

            </div>
            <h5> <b style="font-family: 'Times New Roman', Times, serif;">KP Form No. 9 </b></h5>


            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                <div style="display:inline-block;text-align: center;">
                    <img class="profile-img" src="<?php echo $profilePicture; ?>" alt="Profile Picture" style="height: 80px; width: 80px;">
                    <img class="profile-img" src="<?php echo $lgulogo; ?>" alt="Lgu Logo" style="height: 80px; width: 80px;">
                    <img class="profile-img" src="<?php echo $citylogo; ?>" alt="City Logo" style="height: 80px; width: 80px;">

                    <div style="text-align: center; font-family: 'Times New Roman', Times, serif;">
                        <br>
                        <h5 class="header" style="font-size: 18px;">Republic of the Philippines</h5>
                        <h5 class="header" style="font-size: 18px;">Province of Laguna</h5>
                        <h5 class="header" style="text-align: center; font-size: 18px;">
                            <?php
                            $municipality = $_SESSION['municipality_name'];
                            $isCity = in_array($municipality, ['Biñan', 'Calamba', 'Cabuyao', 'San Pablo', 'San Pedro', 'Santa Rosa']);
                            $isMunicipality = !$isCity;

                            if ($isCity) {
                                echo 'City of ' . $municipality;
                            } elseif ($isMunicipality) {
                                echo 'Municipality of ' . $municipality;
                            } else {
                                echo 'City/Municipality of ' . $municipality;
                            }
                            ?>
                        </h5>
                        <h5 class="header" style="font-size: 18px;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                        <h5 class="header" style="font-size: 18px; margin-top: 5px;">OFFICE OF THE PUNONG BARANGAY</h5>

                    </div>
                    <br>
                    <br>

                    <?php
                    $months = [
                        'January',
                        'February',
                        'March',
                        'April',
                        'May',
                        'June',
                        'July',
                        'August',
                        'September',
                        'October',
                        'November',
                        'December'
                    ];

                    $currentYear = date('Y');
                    ?>

                    <div class="form-group" style="text-align: justify; font-family: 'Times New Roman', Times, serif;">
                        <div class="input-field" style="float: right; width: 50%;">
                            <!-- case num here -->
                            <p style="text-align: left; margin-left:30px; font-size: 18px;">Barangay Case No.<span style="min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
                                    <?php echo !empty($cNum) ? $cNum : '&nbsp;'; ?></span></p>

                            <p style="text-align: left; margin-left:30px; margin-top: 0; font-size: 18px;"> For: <span style="border-bottom: 1px solid black; font-size: 18px;"><?php echo !empty($forTitle) ? nl2br(htmlspecialchars($forTitle)) : '&nbsp;'; ?></span> </p>
                        </div>
                    </div>


                    <div class="form-group" style="text-align: justify; text-indent: 0em; font-family: 'Times New Roman', Times, serif;">
                        <div class="label"></div>
                        <span style="border-bottom: 1px solid black; font-size: 18px;"><?php echo !empty($cNames) ? nl2br(htmlspecialchars($cNames)) : '&nbsp;'; ?></span>


                        <p style="font-size: 18px;"> Complainant/s </p>
                        <p style="font-size: 18px;">- against -</p>
                    </div>

                    <div class="form-group" style="text-align: justify; text-indent: 0em; font-family: 'Times New Roman', Times, serif;">
                        <div class="label"></div>
                        <span style="border-bottom: 1px solid black; font-size: 18px;"><?php echo !empty($rspndtNames) ? nl2br(htmlspecialchars($rspndtNames)) : '&nbsp;'; ?></span>

                        <p style="font-size: 18px;"> Respondent/s </p>

                        <h3 style="text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif;"> <b style="font-size: 18px;">
                                SUMMONS </b>
                        </h3>

                        <div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 1px; font-size: 18px; font-family: 'Times New Roman', Times, serif;">

                            <div class="input-field">
                                <p style="font-size: 18px;"> TO: <span style="border-bottom: 1px solid black; font-size: 18px;"><?php echo !empty($rspndtNames) ? nl2br(htmlspecialchars($rspndtNames)) : '&nbsp;'; ?></span>
                                </p>
                            </div>
                            <div>
                                <p style="font-size: 18px; text-indent:2em;"> Respondent/s </p>
                            </div>

                            <form method="POST">
                                <div style="text-align: justify; text-indent: 2em; margin-left: 1px; font-size: 18px; font-family: 'Times New Roman', Times, serif;">
                                    You are hereby required to appear before me on the
                                    <input style="font-size: 18px; padding-bottom: 0; border: none; border-bottom: 1px solid black;" type="number" name="day" placeholder="day" min="1" max="31" value="<?php echo $appear_day; ?>" required> of
                                    <select style="height: 30px; text-align: center; border: none; border-bottom: 1px solid black; font-size: 18px;" name="month" required>
                                        <?php foreach ($months as $m): ?>
                                            <?php if ($id > 0): ?>
                                                <option style="font-size: 18px;" value="<?php echo $appear_month; ?>" <?php echo ($m === $appear_month) ? 'selected' : ''; ?>><?php echo $appear_month; ?></option>
                                            <?php else: ?>
                                                <option style="font-size: 18px;" value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>,
                                    <input style="font-size: 18px; width: 3em; margin-right: 5px; border: none; border-bottom: 1px solid black;" type="number" name="year" placeholder="year" value="<?php echo $appear_year ?? date('Y'); ?>" required>
                                    at <input style="font-size: 18px; padding-bottom: 0; border: none; border-bottom: 1px solid black;" type="time" id="time" name="time" size="5" style="border: none;" value="<?php echo $appear_time; ?>" required> o'clock in the morning/afternoon then and there to answer to a complaint made before me, copy of which is attached hereto, for mediation/conciliation of your dispute with complainant/s.
                                </div>

                                <div style="text-align: justify; text-indent: 2em; margin-left: 1px; margin-top: 1em; font-size: 18px; font-family: 'Times New Roman', Times, serif;">
                                    You are hereby warned that if you refuse or willfully fail to appear in obedience to this summons, you may be barred from filing any counterclaim arising from said complaint.
                                    <br>
                                    <p style="text-indent: 2em; margin-left: 1px; font-size: 18px; font-family: 'Times New Roman', Times, serif;">FAIL NOT or else face punishment as for contempt of court.</p>
                                </div>


                                <div style="height: 30px; text-align: center; text-align: justify; text-indent: 0em; margin-left: 20.5px;text-indent: 2em; margin-left: 1px; font-size: 18px; font-family: 'Times New Roman', Times, serif;"> This <input style="border: none; border-bottom: 1px solid black; font-size: 18px;" type="number" name="made_day" placeholder="day" min="1" max="31" value="<?php echo $existingMadeDay; ?>">
                                    day of
                                    <select style="height: 30px; text-align: center; border: none; border-bottom: 1px solid black; font-size: 18px; font-family: 'Times New Roman', Times, serif;" name="made_month" required>
                                        <?php foreach ($months as $m): ?>
                                            <?php if ($id > 0): ?>
                                                <option style="font-size: 18px; font-family: 'Times New Roman', Times, serif;" value="<?php echo $existingMadeMonth; ?>" <?php echo ($m === $existingMadeMonth) ? 'selected' : ''; ?>><?php echo $existingMadeMonth; ?></option>
                                            <?php else: ?>
                                                <option style="font-size: 18px; font-family: 'Times New Roman', Times, serif;" value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>,
                                    <input style="font-size: 18px; width: 3em; margin-right: 5px; border: none; border-bottom: 1px solid black;" type="number" name="made_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo $existingMadeYear ?? date('Y'); ?>">.
                                </div>


                                <p class="important-warning-text" style="text-align: center; font-size: 18px; margin-left: 400px; margin-right: auto; white-space: nowrap;">
                                    <span style="min-width: 250px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
                                        <?php echo !empty($punong_barangay) ? $punong_barangay : '&nbsp;'; ?>
                                    </span>
                                </p>
                                <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: center; margin-left: 430px; font-size: 18px; font-weight: normal; white-space: nowrap; max-width: 200px;">
                                    Punong Barangay/Kalihim ng Lupon
                                </label><br>

                                <div class="page-break"> <br><br><br><br><br><br><br></div>

                                <h3 style="text-align: center; font-size: 18px;">
                                    <b style="font-size: 18px;">OFFICER'S RETURN</b>
                                </h3>


                                <div style="font-size: 18px; text-align: justify; text-indent: 2em; margin-left: 1px;">
                                    I served this summons upon respondent <?php echo $rspndtNames; ?> on the
                                    <input style="border: none; border-bottom: 1px solid black; font-size: 18px; font-family: 'Times New Roman', Times, serif;" type="number" name="received_day" placeholder="day" min="1" max="31" value="<?php echo $existingReceivedDay ?? ''; ?>">
                                    day of
                                    <select style="text-align:center;height: 30px; border: none; border-bottom: 1px solid black; font-size: 18px; font-family: 'Times New Roman', Times, serif;" name="received_month" required>
                                        <?php foreach ($months as $m): ?>
                                            <?php if ($id > 0): ?>
                                                <option style="text-align:center;border: none; border-bottom: 1px solid black; font-size: 18px; font-family: 'Times New Roman', Times, serif;" value="<?php echo $existingReceivedMonth; ?>" <?php echo ($m === $existingReceivedMonth) ? 'selected' : ''; ?>><?php echo $existingReceivedMonth; ?></option>
                                            <?php else: ?>
                                                <option style="text-align:center;border: none; border-bottom: 1px solid black; font-size: 18px; font-family: 'Times New Roman', Times, serif;" value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>,
                                    <input style="text-align:center;width: 3em; margin-right: 5px; border: none; border-bottom: 1px solid black; font-size: 18px; font-family: 'Times New Roman', Times, serif;" type="number" name="received_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo $existingReceivedYear ?? date('Y'); ?>">, and upon respondent <?php echo $rspndtNames; ?> on the day
                                    <input style="text-align:center;border: none; border-bottom: 1px solid black; font-size: 18px; font-family: 'Times New Roman', Times, serif;" type="number" name="resp_day" placeholder="day" min="1" max="31" value="<?php echo $existingRespDay ?? ''; ?>"> of
                                    <select style="text-align:center;height: 30px; border: none; border-bottom: 1px solid black; font-size: 18px; font-family: 'Times New Roman', Times, serif;" name="resp_month" required>
                                        <?php foreach ($months as $m): ?>
                                            <?php if ($id > 0): ?>
                                                <option style="text-align:center;height: 30px; border: none; border-bottom: 1px solid black; font-size: 18px; font-family: 'Times New Roman', Times, serif;" value="<?php echo $existingRespMonth; ?>" <?php echo ($m === $existingRespMonth) ? 'selected' : ''; ?>><?php echo $existingRespMonth; ?></option>
                                            <?php else: ?>
                                                <option style="text-align:center;height: 30px; border: none; border-bottom: 1px solid black; font-size: 18px; font-family: 'Times New Roman', Times, serif;" value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>,
                                    <input style="text-align:center;width: 3em; margin-right: 5px; border: none; border-bottom: 1px solid black; font-size: 18px; font-family: 'Times New Roman', Times, serif;" type="number" name="resp_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo $existingRespYear ?? date('Y'); ?>"> by: <br>
                                    <p style="font-size: 18px;text-indent: 0em;"> (Write name/s of respondent/s before mode by which he/they was/were served.)</p>
                                </div>


                                <div style="font-size: 18px; text-align: justify; text-indent: 0em; margin-left: 20.5px;">
                                    <p style="font-size: 18px; text-indent: 0em; margin-left: 18px;">
                                        <input style="text-align:center;border: none; border-bottom: 1px solid black; display: inline-block; font-size: 18px;" type="text" id="scenario1" name="scenario_1" size="15" value="<?php echo ($existingScenario == 1) ? $rspndtName1 : ''; ?>"> 1. handing to him/them said summons in person, or <br>
                                        <input style="text-align:center;border: none; border-bottom: 1px solid black; display: inline-block; font-size: 18px;" type="text" id="scenario2" name="scenario_2" size="15" value="<?php echo ($existingScenario == 2) ? $rspndtName2 : ''; ?>"> 2. handing to him/them said summons and he/they refused to receive it, or <br>
                                        <input style="text-align:center;border: none; border-bottom: 1px solid black; display: inline-block; font-size: 18px;" type="text" id="scenario3" name="scenario_3" size="15" value="<?php echo ($existingScenario == 3) ? $rspndtName3 : ''; ?>"> 3. leaving said summons at his/their dwelling with
                                        <input style="text-align:center;border: none; border-bottom: 1px solid black; font-size: 18px; width: 220px;" type="text" id="scenario3a" placeholder="Enter name" name="scenario_3a" size="15" value="<?php echo ($existingScenario == 3) ? $existScen3 : ''; ?>"> (name) a person of suitable age and discretion residing therein, or <br>
                                        <input style="text-align:center;border: none; border-bottom: 1px solid black; display: inline-block; font-size: 18px;" type="text" id="scenario4" name="scenario_4" size="15" value="<?php echo ($existingScenario == 4) ? $rspndtName4 : ''; ?>"> 4. leaving said summons at his/their office/place of business with
                                        <input style="text-align:center;border: none; border-bottom: 1px solid black; font-size: 18px; width: 220px;" type="text" id="scenario4a" placeholder="Enter name" name="scenario_4a" size="15" value="<?php echo ($existingScenario == 4) ? $existScen4 : ''; ?>">, (name) a competent person in charge thereof.
                                    </p>
                                </div><br>


                                <input type="text" name="officer" size="25" style="text-align:center;font-size: 18px; border: none; border-bottom: 1px solid black; margin-left: 450px; width: 250px;" value="<?php echo $existOfficer; ?>" required list="officerList">
                                <p style="font-size: 18px; font-family: 'Times New Roman', Times, serif; margin-top: 20px; margin-left: 550px;">Officer</p>
                                <datalist id="officerList">
                                    <!-- Display 'punong_barangay' and 'lupon_chairman' as options -->
                                    <option style="text-align:center;" value="<?php echo $punong_barangay; ?>">
                                    <option style=" text-align:center;" value="<?php echo $lupon_chairman; ?>">
                                </datalist>
                        </div>
                        <p style="font-size: 18px;text-indent: 1em; margin-left: 1px;">Received by Respondent/s representative/s:</p>

                        <br>
                        <div style="text-align: center; margin-top: 20px;">

                            <!-- First Signature and Date -->
                            <div style="display: inline-block; margin-right: 50px;">
                                <div style="border-bottom: 1px solid black; width: 200px; margin-bottom: 10px;"> </div>
                                <div style="font-size: 18px;">Signature</div>
                            </div>

                            <!-- Second Signature and Date -->
                            <div style="display: inline-block;">
                                <div style="border-bottom: 1px solid black; width: 200px; margin-bottom: 10px;"></div>
                                <div style="font-size: 18px;">Date</div>
                            </div>

                        </div>
                        <div style="text-align: center; margin-top: 20px;">
                            <br>
                            <br>
                            <!-- First Signature and Date -->
                            <div style="display: inline-block; margin-right: 50px;">
                                <div style="border-bottom: 1px solid black; width: 200px; margin-bottom: 10px;"></div>
                                <div style="font-size: 18px;">Signature</div>
                            </div>

                            <!-- Second Signature and Date -->
                            <div style="display: inline-block;">
                                <div style="border-bottom: 1px solid black; width: 200px; margin-bottom: 10px;"></div>
                                <div style="font-size: 18px;">Date</div>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($message)) : ?>
                        <p><?php echo $message; ?></p>
                    <?php endif; ?>

                    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button" style="position: fixed; right: 20px; top: 130px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                    </form>

                    <script>
                        var barangayCaseNumber = "<?php echo $cNum; ?>"; // Assume $cNum is your case number variable
                        document.getElementById('downloadButton').addEventListener('click', function() {
                            // Elements to hide during PDF generation
                            var buttonsToHide = document.querySelectorAll('.top-right-buttons button');
                            var saveButton = document.querySelector('input[name="saveForm"]');

                            // Hide the specified buttons
                            buttonsToHide.forEach(function(button) {
                                button.style.display = 'none';
                            });

                            // Hide the Save button
                            saveButton.style.display = 'none';

                            // Ensure input borders are visible for PDF generation
                            var toInputs = document.querySelectorAll('input[name^="to"]');
                            toInputs.forEach(function(input) {
                                input.style.borderBottom = '1px solid black';
                            });

                            var pdfContent = document.querySelector('.paper');
                            var downloadButton = document.getElementById('downloadButton');

                            // Hide the download button
                            downloadButton.style.display = 'none';

                            // Modify the filename option to include the barangay case number
                            html2pdf(pdfContent, {
                                margin: [10, 10, 10, 10],
                                filename: 'kp_form9_' + barangayCaseNumber + '.pdf', // Dynamic filename
                                image: {
                                    type: 'jpeg',
                                    quality: 0.98
                                },
                                html2canvas: {
                                    scale: 2, // Adjust the scale as necessary
                                    width: pdfContent.clientWidth, // Set a fixed width based on the on-screen width of the content
                                    windowWidth: document.documentElement.offsetWidth // Set the window width to match the document width
                                },
                                jsPDF: {
                                    unit: 'mm',
                                    format: 'a4',
                                    orientation: 'portrait'
                                }
                            }).then(function() {
                                // Show the download button after PDF generation
                                downloadButton.style.display = 'inline-block';

                                // Show the Save button after PDF generation
                                saveButton.style.display = 'inline-block';

                                // Show the other buttons after PDF generation
                                buttonsToHide.forEach(function(button) {
                                    button.style.display = 'inline-block';
                                });

                                // Restore borders for all input types and select
                                inputFields.forEach(function(field) {
                                    field.style.border = ''; // Use an empty string to revert to default border
                                });
                            });
                        });
                    </script>
                </div>
            </div>
</body>

</html>