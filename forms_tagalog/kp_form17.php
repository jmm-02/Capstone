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
$formUsed = 17;

// Fetch existing row values if the form has been previously submitted
$query = "SELECT * FROM hearings WHERE complaint_id = :complaintId AND form_used = :formUsed";
$stmt = $conn->prepare($query);
$stmt->bindParam(':complaintId', $complaintId);
$stmt->bindParam(':formUsed', $formUsed);
$stmt->execute();
$rowCount = $stmt->rowCount();

$currentYear = date('Y'); // Get the current year

// Array of months
$months = array(
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
);

$currentMonth = date('F'); 
$currentDay = date('j');

$id = $_GET['formID'] ?? '';
$existingFraudCheck = '';
$existingFraudText = '';
$existingViolenceCheck = '';
$existingViolenceText = '';
$existingIntimidationCheck = '';
$existingIntimidationText = '';
// Check if formID exists in the URL
if (!empty($id)) {
    // Fetch data based on the provided formID
    $query = "SELECT * FROM hearings WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $rowCount = $stmt->rowCount();

    if ($rowCount > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $madeDate = new DateTime($row['made_date']);
        $receivedDate = new DateTime($row['received_date']);
        $respDate = new DateTime($row['resp_date']);

        $existingMadeDay = $madeDate->format('j');
        $existingMadeMonth = $madeDate->format('F');
        $existingMadeYear = $madeDate->format('Y');

        $existingReceivedDay = $receivedDate->format('j');
        $existingReceivedMonth = $receivedDate->format('F');
        $existingReceivedYear = $receivedDate->format('Y');

        $existingRespDay = $respDate->format('j');
        $existingRespMonth = $respDate->format('F');
        $existingRespYear = $respDate->format('Y');

         // Fetching existing variables for the inputs
        $existingFraudCheck = $row['fraud_check'];
        $existingFraudText = $row['fraud_text'];
        $existingViolenceCheck = $row['violence_check'];
        $existingViolenceText = $row['violence_text'];
        $existingIntimidationCheck = $row['intimidation_check'];
        $existingIntimidationText = $row['intimidation_text'];
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
    
    $fraudCheck = isset($_POST['fraudcheck']) ? 1 : 0;
    $fraudText = $_POST['fraudtext'] ?? '';

    $violenceCheck = isset($_POST['violencecheck']) ? 1 : 0;
    $violenceText = $_POST['violencetext'] ?? '';

    $intimidationCheck = isset($_POST['intimidationcheck']) ? 1 : 0;
    $intimidationText = $_POST['intimidationtext'] ?? '';


    // Logic to handle date and time inputs
    $madeDate = createDateFromInputs($madeDay, $madeMonth, $madeYear);
    $receivedDate = createDateFromInputs($receivedDay, $receivedMonth, $receivedYear);
    $respDate = createDateFromInputs($respDay, $respMonth, $respYear);

    // Insert or update the appear_date in the hearings table
    $query = "INSERT INTO hearings (complaint_id, hearing_number, form_used, made_date, received_date, resp_date,fraud_check, fraud_text, violence_check, violence_text, intimidation_check, intimidation_text)
              VALUES (:complaintId, :currentHearing, :formUsed, :madeDate, :receivedDate, :respDate,:fraudCheck, :fraudText, :violenceCheck, :violenceText, :intimidationCheck, :intimidationText)
              ON DUPLICATE KEY UPDATE
              hearing_number = VALUES(hearing_number),
              form_used = VALUES(form_used),
              made_date = VALUES(made_date),
              received_date = VALUES(received_date),
              resp_date = VALUES(resp_date),
              fraud_check = VALUES(fraud_check),
              fraud_text = VALUES(fraud_text),
              violence_check = VALUES(violence_check),
              violence_text = VALUES(violence_text),
              intimidation_check = VALUES(intimidation_check),
              intimidation_text = VALUES(intimidation_text)
              ";


     $stmt = $conn->prepare($query);
    $stmt->bindParam(':complaintId', $complaintId);
    $stmt->bindParam(':currentHearing', $currentHearing);
    $stmt->bindParam(':formUsed', $formUsed);
    $stmt->bindParam(':madeDate', $madeDate);
    $stmt->bindParam(':receivedDate', $receivedDate);
    $stmt->bindParam(':respDate', $respDate);
    $stmt->bindParam(':fraudCheck', $fraudCheck);
    $stmt->bindParam(':fraudText', $fraudText);
    $stmt->bindParam(':violenceCheck', $violenceCheck);
    $stmt->bindParam(':violenceText', $violenceText);
    $stmt->bindParam(':intimidationCheck', $intimidationCheck);
    $stmt->bindParam(':intimidationText', $intimidationText);

    
    if ($stmt->execute()) {
        $message = "Form submit successful.";
    } else {
        $message = "Form submit failed.";
    }
}


// Function to create a date from day, month, and year inputs
function createDateFromInputs($day, $month, $year) {
    if (!empty($day) && !empty($month) && !empty($year)) {
        $monthNum = date('m', strtotime("$month 1"));
        return date('Y-m-d', mktime(0, 0, 0, $monthNum, $day, $year));
    } else {
        return date('Y-m-d');
    }
}

// Retrieve the profile picture name of the current user
$query = "SELECT profile_picture FROM users WHERE id = :userID";
$stmt = $conn->prepare($query);
$stmt->bindParam(':userID', $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the user has a profile picture
if ($user && !empty($user['profile_picture'])) {
    $profilePicture = '../profile_pictures/' . $user['profile_picture'];
} else {
    // Default profile picture if the user doesn't have one set
    $profilePicture = '../profile_pictures/defaultpic.jpg';
}

$query = "SELECT lgu_logo FROM users WHERE id = :userID";
$stmt = $conn->prepare($query);
$stmt->bindParam(':userID', $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the user has a profile picture
if ($user && !empty($user['lgu_logo'])) {
    $lgulogo = '../lgu_logo/' . $user['lgu_logo'];
} else {
    // Default profile picture if the user doesn't have one set
    $lgulogo = '../lgu_logo/defaultpic.jpg';
}


$query = "SELECT city_logo FROM users WHERE id = :userID";
$stmt = $conn->prepare($query);
$stmt->bindParam(':userID', $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the user has a profile picture
if ($user && !empty($user['city_logo'])) {
    $citylogo = '../city_logo/' . $user['city_logo'];
} else {
    // Default profile picture if the user doesn't have one set
    $citylogo = '../city_logo/defaultpic.jpg';
}
?>

<?php
$tagalogMonths = array(
    'January' => 'Enero',
    'February' => 'Pebrero',
    'March' => 'Marso',
    'April' => 'Abril',
    'May' => 'Mayo',
    'June' => 'Hunyo',
    'July' => 'Hulyo',
    'August' => 'Agosto',
    'September' => 'Setyembre',
    'October' => 'Oktubre',
    'November' => 'Nobyembre',
    'December' => 'Disyembre'
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>KP FORM 17</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">
    
        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

    <style>
        .paper {
    background: white;
    margin: 0 auto;
    margin-bottom: 0.5cm;
    box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    overflow: hidden; /* Add overflow property to handle content overflow */

    /* Add padding to create margins */
    padding: 2%; /* Adjust the value as needed */

    /* Set box-sizing to include padding in the element's total width and height */
    box-sizing: border-box;
}

/* Add Bootstrap responsive classes for different screen sizes */
@media (min-width: 992px) {
    .paper {
        width: calc(100% - 4%); /* Adjusted width considering left and right padding */
        height: auto; /* Auto height to adapt to the content */
    }

    .paper[layout="landscape"] {
        width: calc(100% - 4%); /* Adjusted width considering left and right padding */
        height: 21cm;
    }
}

@media print {
    .top-right-buttons {
        display: none; /* Hide the button container */
    }

    .btn {
        display: none !important; /* Hide all buttons with the class 'btn' */
    }
}

@media (min-width: 1200px) {
    .paper[size="A3"] {
        width: calc(100% - 4%); /* Adjusted width considering left and right padding */
        height: 42cm;
    }

    .paper[size="A3"][layout="landscape"] {
        width: calc(100% - 4%); /* Adjusted width considering left and right padding */
        height: 29.7cm;
    }

    .paper[size="A5"] {
        width: calc(100% - 4%); /* Adjusted width considering left and right padding */
        height: 21cm;
    }

    .paper[size="A5"][layout="landscape"] {
        width: calc(100% - 4%); /* Adjusted width considering left and right padding */
        height: 14.8cm;
    }
}
        .profile-img{
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
        height: auto; /* Auto height to adapt to the content */
    }

    .paper[layout="landscape"] {
        width: 29.7cm;
        height: auto; /* Auto height to adapt to the content */
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
    body, .paper {
        background: white;
        margin: 0;
        box-shadow: 0;
    }
}

   @media print {
  /* Adjust print styles here */
  .input-field {
    /* Example: Ensure input fields do not expand beyond their containers */
    max-width: 100%;
  }
}

.placeholder-text {
    margin-left: 15px;
    text-indent: 0em;
    font-size: 18px;
    text-align: justify;
    font-family: 'Times New Roman', Times, serif;
    text-decoration: underline;
    width: 750px;
    height: auto;
    border: none;
    overflow-y: hidden;
    resize: vertical;
    font-size: 18px;
    white-space: pre-line;
}

.placeholder-text:empty:before {
    content: 'State details here......................................................................................................................................';
    color: #999; /* Adjust the color of the placeholder text */
    text-decoration: underline;
}

   </style>
</head>
<body>
    <br>
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
            <h5> <b style="font-family: 'Times New Roman', Times, serif;">Pormularyo ng KP Blg. 17 </b></h5>
            <div style="text-align: center;">
    <div style="display: inline-block;">
        <img class="profile-img" src="<?php echo $profilePicture; ?>" alt="Profile Picture" style="height: 80px; width: 80px;">
    </div>
    <div style="display: inline-block;">
        <img class="profile-img" src="<?php echo $lgulogo; ?>" alt="Lgu Logo" style="height: 80px; width: 80px;">
    </div>
    <div style="display: inline-block;">
        <img class="profile-img" src="<?php echo $citylogo; ?>" alt="City Logo" style="height: 80px; width: 80px;">
    </div>
    <div style="text-align: center; font-family: 'Times New Roman', Times, serif;">
        <br>
                <h5 style="text-align: center;font-size: 18px;">Republika ng Pilipinas</h5>
                <h5 style="text-align: center;font-size: 18px;">Lalawigan ng Laguna</h5>
                <h5 class="header" style="text-align: center; font-size: 18px;">
                <?php
$municipality = $_SESSION['municipality_name'];
$isCity = in_array($municipality, ['Biñan', 'Calamba', 'Cabuyao', 'San Pablo', 'San Pedro', 'Santa Rosa']);
$isMunicipality = !$isCity;

if ($isCity) {
    echo 'Lungsod ng ' . $municipality;
} elseif ($isMunicipality) {
    echo 'Bayan ng ' . $municipality;
} else {
    echo 'Lungsod/Bayan ng ' . $municipality;
}
?>
    
</h5>
                <h5 style="text-align: center;font-size: 18px;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5><br>
                <h5 style="text-align: center;font-size: 18px;"><b style="font-size: 18px;font-family: 'Times New Roman', Times, serif;">TANGGAPAN NG  LUPONG TAGAPAMAYAPA </b></h5>
            </div>
</div>

            <?php
$months = [
    'Enero', 'Pebrero', 'Marso', 'Abril', 'Mayo', 'Hunyo', 'Hulyo', 'Agosto', 'Setyembre', 'Oktubre', 'Nobyembre', 'Disyembre'
];

$currentYear = date('Y');
?>
<br><br>

<div class="form-group" style="text-align: justify; font-family: 'Times New Roman', Times, serif;" >
    <div class="input-field" style="float: right; width: 50%;">
        <!-- case num here -->
        <p style="text-align: left; margin-left:30px; font-size: 18px;">Usaping Barangay Blg. <span style="min-width: 170px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
    <?php echo !empty($cNum) ? $cNum : '&nbsp;'; ?></span></p>

    <p style="text-align: left; font-size: 18px; font-size: 18px; margin-left: 30px; margin-top: 0;">
        Ukol sa: <span style="border-bottom: 1px solid black; font-size: 18px;"><?php echo !empty($forTitle) ? nl2br(htmlspecialchars($forTitle)) : '&nbsp;'; ?></span> </p>
    </div>
</div>


<div class="form-group" style="text-align: justify; text-indent: 0em; font-family: 'Times New Roman', Times, serif;">
    <div class="label"></div>
    <span style="border-bottom: 1px solid black; font-size: 18px;"><?php echo !empty($cNames) ? nl2br(htmlspecialchars($cNames)) : '&nbsp;'; ?></span>
              
<p style="font-size: 18px;">(Mga) Maysumbong</p>
<p style="font-size: 18px;">- laban kay/kina -</p>
                </div>

<div class="form-group" style="text-align: justify; text-indent: 0em; font-family: 'Times New Roman', Times, serif;">
    <div class="label"></div>
    <span style="border-bottom: 1px solid black; font-size: 18px;"><?php echo !empty($rspndtNames) ? nl2br(htmlspecialchars($rspndtNames)) : '&nbsp;'; ?></span>

<p style="font-size: 18px;"> (Mga) Ipinagsusumbong </p> 

<h3 style="text-align: center;"><b style="text-align: center; font-size: 18px;  font-family: 'Times New Roman', Times, serif;">PAGTANGGI</b></h3>
<form id="formId" method="POST">
<div style="text-align: justify;   font-size: 18px;  font-family: 'Times New Roman', Times, serif;">Sa pamamagitan nito’y itinatangi ko/naming ang pag-aayos/kasunduan sa paghahatol sapagkat ang akin/aming pag-sang-ayon ay walang saysay dahilan sa: <br>
(Lagyan ng tsek ang angkop)
    </div>
    <br>
    <div style="font-size: 18px; font-family: 'Times New Roman', Times, serif;">
    <div class="checkbox-container">
        <input type="checkbox" id="fraudCheckbox" name="fraudcheck" <?php if(isset($existingFraudCheck) && $existingFraudCheck == 1) echo "checked"; ?>>
        <label for="fraudCheckbox" class="checkbox-label"> Panlilinlang (Ipaliwanag)</label> </div>
        <div class="a">
        <textarea id="fraudtext" name="fraudtext" style="text-decoration: underline; width: 95%; margin-left: 20.5px; border: none; overflow-y: auto; resize: vertical; font-size: 18px; white-space: pre-line;" contenteditable="true"><?php echo $existingFraudText; ?></textarea>
    </div>


<div class="checkbox-container">
        <input type="checkbox" id="violenceCheckbox" name="violencecheck" <?php if(isset($existingViolenceCheck) && $existingViolenceCheck == 1) echo "checked"; ?>>
        <label for="violenceCheckbox" class="checkbox-label"> Karahasan (Ipaliwanag)</label>
        </div>
    <div class="a">
        <textarea id="violencetext" name="violencetext" style="text-decoration: underline; width: 95%; margin-left: 20.5px; border: none; overflow-y: auto; resize: vertical; font-size: 18px; white-space: pre-line;" contenteditable="true"><?php echo $existingViolenceText; ?></textarea>
    </div>

    <div class="checkbox-container">
        <input type="checkbox" id="intimidationCheckbox" name="intimidationcheck" <?php if(isset($existingIntimidationCheck) && $existingIntimidationCheck == 1) echo "checked"; ?>>
        <label for="intimidationCheckbox" class="checkbox-label">  Pananakot (Ipaliwanag)</label>
        </div>
    <div class="a">
        <textarea id="intimidationtext" name="intimidationtext" style="text-decoration: underline; width: 95%; margin-left: 20.5px; border: none; overflow-y: auto; resize: vertical; font-size: 18px; white-space: pre-line;" contenteditable="true"><?php echo $existingIntimidationText; ?></textarea>
    </div>
    </div>

<br>

    <div style="font-size: 18px;  font-family: 'Times New Roman', Times, serif; text-align: justify; ">Ngayong ika- <input  style="font-size: 18px; text-align:center; font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black; " type="text" name="resp_day" placeholder="araw" size="5" value="<?php echo $existingRespDay ?? ''; ?>"> araw ng
    <select name="month" style="font-size: 18px; text-align: center; border: none; border-bottom: 1px solid black; padding: 0; margin: 0; height: 30px; line-height: normal; box-sizing: border-box;" required>
    <?php foreach ($tagalogMonths as $englishMonth => $tagalogMonth): ?>
        <option value="<?php echo $englishMonth; ?>" <?php echo (strcasecmp($englishMonth, date('F')) === 0) ? 'selected' : ''; ?>><?php echo $tagalogMonth; ?></option>
    <?php endforeach; ?>
</select>,
                <input style="font-size: 18px;font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black;" type="number" name="made_year" size="1" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingMadeYear) ? $existingMadeYear : date('Y'); ?>">             
</div> <br>

<div style="font-family: 'Times New Roman', Times, serif;">
    <!-- Section for Names and Labels -->
    <div style="display: flex; justify-content: space-around; align-items: center; margin-top: 20px;">
        <!-- Complainant Name and Label Container -->
        <div style="text-align: center;">
        <div style="font-size: 18px; margin-bottom: 10px;">
        (Mga) Maysumbong
            </div>
            <span style="width:280px; border-bottom: 1px solid black; font-size: 18px; display: inline-block;">
                <?php echo !empty($cNames) ? nl2br(htmlspecialchars($cNames)) : '&nbsp;'; ?>
            </span>
        
        </div>
        

        <!-- Respondent Name and Label Container -->
        <div style="text-align: center;">
        <div style="font-size: 18px; margin-bottom: 10px;">
        (Mga) Ipinagsusumbong
            </div>
            <span style="width:280px;  border-bottom: 1px solid black; font-size: 18px; display: inline-block;">
                <?php echo !empty($rspndtNames) ? nl2br(htmlspecialchars($rspndtNames)) : '&nbsp;'; ?>
            </span>
           
        </div>
    </div>
</div>
 
</div><br>
<div style="text-align: justify;   font-size: 18px;  font-family: 'Times New Roman', Times, serif;"> NILAGDAAN at PINANUMPAAN sa harap ko ngayong ika- 
<input  style="font-size: 18px; text-align:center; font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black; " type="text" name="resp_day" placeholder="araw" size="5" value="<?php echo $existingRespDay ?? ''; ?>"> araw ng
<select name="month" style="font-size: 18px; text-align: center; border: none; border-bottom: 1px solid black; padding: 0; margin: 0; height: 30px; line-height: normal; box-sizing: border-box;" required>
    <?php foreach ($tagalogMonths as $englishMonth => $tagalogMonth): ?>
        <option value="<?php echo $englishMonth; ?>" <?php echo (strcasecmp($englishMonth, date('F')) === 0) ? 'selected' : ''; ?>><?php echo $tagalogMonth; ?></option>
    <?php endforeach; ?>
</select>,
<input style="font-size: 18px;  font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black; " type="number" name="resp_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingRespYear) ? $existingRespYear : date('Y'); ?>">.
              </div><br>

<p class="important-warning-text" style="font-size: 18px; text-align: center; margin-left: 490px;  font-family: 'Times New Roman', Times, serif;">
    <span style="min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
        <?php echo !empty($punong_barangay) ? $punong_barangay : '&nbsp;'; ?>
    </span>
    <label style="font-size: 18px; font-family: 'Times New Roman', Times, serif; font-weight: normal; margin-left: 15px;"> <i>Punong Barangay/Tagapangulo ng Pangkat </i></span>
</p>

<div style="text-align: justify;  font-size: 18px; font-family: 'Times New Roman', Times, serif; ">Tinangap at inihain ngayong ika- <input  style="font-size: 18px; text-align:center; font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black; " type="text" name="resp_day" placeholder="araw" size="5" value="<?php echo $existingRespDay ?? ''; ?>"> araw ng
<select name="month" style="font-size: 18px; text-align: center; border: none; border-bottom: 1px solid black; padding: 0; margin: 0; height: 30px; line-height: normal; box-sizing: border-box;" required>
    <?php foreach ($tagalogMonths as $englishMonth => $tagalogMonth): ?>
        <option value="<?php echo $englishMonth; ?>" <?php echo (strcasecmp($englishMonth, date('F')) === 0) ? 'selected' : ''; ?>><?php echo $tagalogMonth; ?></option>
    <?php endforeach; ?>
</select>,
<input style="font-size: 18px;  font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black; " type="number" name="resp_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingRespYear) ? $existingRespYear : date('Y'); ?>">.
                      
</div>

<?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button" style="position:fixed; right: 20px; top: 130px;">
</form>
     
  <div style="text-align: justify;margin: top 0;  font-size: 16px; font-family: 'Times New Roman', Times, serif; ">*Ang hindi pagtanggi sa pag-aayos o kasunduan ng paghahatol ng tagapamagitan sa loob ng taning na panahon, alinsunod sa itinakdang sampung (10) araw ay ipapalagay na isang pagtatakwil sa karapatang tumutol batay sa nasabing kadahilanan. 
    </div>       
</div>

<script>
    var barangayCaseNumber = "<?php echo $cNum; ?>"; // Assume $cNum is your case number variable
    document.getElementById('downloadButton').addEventListener('click', function () {
            // Elements to hide during PDF generation
            var buttonsToHide = document.querySelectorAll('.top-right-buttons button');
            var saveButton = document.querySelector('input[name="saveForm"]');

            // Hide the specified buttons
            buttonsToHide.forEach(function (button) {
                button.style.display = 'none';
            });

            // Hide the Save button
            saveButton.style.display = 'none';

            // Remove borders for all input types and select
            var inputFields = document.querySelectorAll('input, select');
            inputFields.forEach(function (field) {
                field.style.border = 'none';
            });

            var pdfContent = document.querySelector('.paper');
            var downloadButton = document.getElementById('downloadButton');

            // Hide the download button
            downloadButton.style.display = 'none';

     // Modify the filename option to include the barangay case number
     html2pdf(pdfContent, {
        margin: [10, 10, 10, 10],
        filename: 'kp_form17_' + barangayCaseNumber + '.pdf', // Dynamic filename
    image: { type: 'jpeg', quality: 0.98 },
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
            }).then(function () {
                // Show the download button after PDF generation
                downloadButton.style.display = 'inline-block';

                // Show the Save button after PDF generation
                saveButton.style.display = 'inline-block';

                // Show the other buttons after PDF generation
                buttonsToHide.forEach(function (button) {
                    button.style.display = 'inline-block';
                });

                // Restore borders for all input types and select
                inputFields.forEach(function (field) {
                    field.style.border = ''; // Use an empty string to revert to default border
                });
            });
        });
    </script>

</html>
