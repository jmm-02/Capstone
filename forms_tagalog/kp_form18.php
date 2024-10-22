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
$formUsed = 18;

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

// Check if formID exists in the URL
if (!empty($id)) {
    // Fetch data based on the provided formID
    $query = "SELECT appear_date, made_date, received_date, resp_date FROM hearings WHERE id = :id";
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
    

    $day = $_POST['day'] ?? '';
    $month = $_POST['month'] ?? '';
    $year = $_POST['year'] ?? '';
    $time = $_POST['time'] ?? '';

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
    $message = "There is already an existing KP Form 18 in this current hearing.";
}

else{

    // Insert or update the appear_date in the hearings table
    $query = "INSERT INTO hearings (complaint_id, hearing_number, form_used, appear_date, made_date, received_date, resp_date)
              VALUES (:complaintId, :currentHearing, :formUsed, :appearDate, :madeDate, :receivedDate, :respDate)
              ON DUPLICATE KEY UPDATE
              hearing_number = VALUES(hearing_number),
              form_used = VALUES(form_used),
              appear_date = VALUES(appear_date),
              made_date = VALUES(made_date),
              received_date = VALUES(received_date), 
              resp_date = VALUES(resp_date)";


     $stmt = $conn->prepare($query);
    $stmt->bindParam(':complaintId', $complaintId);
    $stmt->bindParam(':currentHearing', $currentHearing);
    $stmt->bindParam(':formUsed', $formUsed);
    $stmt->bindParam(':appearDate', $appearTimestamp);
    $stmt->bindParam(':madeDate', $madeDate);
    $stmt->bindParam(':receivedDate', $receivedDate);
    $stmt->bindParam(':respDate', $respDate);

    if ($stmt->execute()) {
        $message = "Form submit successful.";
    } else {
        $message = "Form submit failed.";
    }
}
}
else {
        // Handle case where DateTime object creation failed
        $message ="Invalid date/time format! Input: ". $dateTimeString;
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

function createTimestampFromInputs($day, $month, $year, $time) {
    if (!empty($day) && !empty($month) && !empty($year) && !empty($time)) {
        return date('Y-m-d H:i:s', strtotime("$year-$month-$day $time"));
    } else {
        return null; 
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
<html>
<head>
    <title>KP Form 18 Tagalog</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- here angle the link for responsive paper -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">
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
    body, .paper {
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
        /* Hide elements that should not be printed */
        .btn, .top-right-buttons {
            display: none !important;
    }
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
            </div>      <h5> <b style="font-family: 'Times New Roman', Times, serif;">Pormularyo ng KP Blg. 18 </b></h5>

          <div style="display:inline-block;text-align: center;">
<img class="profile-img" src="<?php echo $profilePicture; ?>" alt="Profile Picture" style="height: 80px; width: 80px;">
<img class="profile-img" src="<?php echo $lgulogo; ?>" alt="Lgu Logo" style="height: 80px; width: 80px;">
<img class="profile-img" src="<?php echo $citylogo; ?>" alt="City Logo" style="height: 80px; width: 80px;">
<div style="text-align: center; font-family: 'Times New Roman', Times, serif;">
<br>
        <h5 class="header" style="font-size: 18px;">Republika ng Pilipinas</h5>
        <h5 class="header" style="font-size: 18px;">Lalawigan ng Laguna</h5>
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
        <h5 class="header" style="font-size: 18px;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
        <h5 class="header" style="font-size: 18px; margin-top: 5px;">TANGGAPAN NG  LUPONG TAGAPAMAYAPA</h5>
    
</div>
<br>
<br>
            <?php
            $months = [
                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            $currentYear = date('Y');
            ?>

<div class="form-group" style="text-align: justify; font-family: 'Times New Roman', Times, serif;" >
    <div class="input-field" style="float: right; width: 50%;">
        <!-- case num here -->
        <p style="text-align: left; margin-left:30px; font-size: 18px;">Usaping Barangay Blg.<span style="min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
    <?php echo !empty($cNum) ? $cNum : '&nbsp;'; ?></span></p>

        <p style="text-align: left; margin-left:30px; margin-top: 0; font-size: 18px;"> Ukol sa:  <span style="border-bottom: 1px solid black; font-size: 18px;"><?php echo !empty($forTitle) ? nl2br(htmlspecialchars($forTitle)) : '&nbsp;'; ?></span> </p>
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

       


                <h3 style="text-align: center;"><b style="font-size: 18px;"> PAABISO NG PADINIG <br>
(Ukol sa: Di-Pagharap)</b> </h3>
<div class="form-group" style="text-align: justify; text-indent: 0em;">
    <div class="label"></div>
    <div class="input-field">
        <p style="font-size: 18px;"> KAY:     <span style="text-align: center; min-width: 200px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
    <?php echo !empty($cNames) ? $cNames : '&nbsp;'; ?></span> <p style="font-family: 'Times New Roman', Times, serif; font-size: 18px; margin-left: 80px;">(Mga) Maysumbong</p> </div>

</div>
<form method="POST">

    <div>
     <p style="text-indent: 2.8em; text-align: justify; font-size: 18px;">
    Sa pamamagitan nito;y inaatasan ka na humarap sa akin/Pangkat sa ika-
  <input style="border: none; border-bottom: 1px solid black; border-bottom: 1px solid black; width: 42px; font-size: 18px;"
 type="number" name="day" placeholder="day" min="1" max="31" value="<?php echo $appear_day; ?>" required>  araw ng
 <select name="month" style="font-size: 18px; text-align: center; border: none; border-bottom: 1px solid black; padding: 0; margin: 0; height: 30px; line-height: normal; box-sizing: border-box;" required>
    <?php foreach ($tagalogMonths as $englishMonth => $tagalogMonth): ?>
        <option value="<?php echo $englishMonth; ?>" <?php echo (strcasecmp($englishMonth, date('F')) === 0) ? 'selected' : ''; ?>><?php echo $tagalogMonth; ?></option>
    <?php endforeach; ?>
                </select>,
                
                <input style="border: none; border-bottom: 1px solid black; border-bottom: 1px solid black; width: 42px; font-size: 18px;"
 type="text" name="year" placeholder="year" size="1"  value="<?php echo isset($appear_year) ? $appear_year : date('Y'); ?>" required>  Sa ganap na ika- <input type="time" id="time" name="time" size="5" style="font-size: 18px; border: none; border-bottom: 1px solid black;" value="<?php echo $appear_time; ?>"required>
 g umaga/hapon upang ipaliwanag kung bakit di ka humarap para sa pamamagitan/pag-aayos na nakatakda noong
                <input style="border: none; border-bottom: 1px solid black; border-bottom: 1px solid black; width: 42px; font-size: 18px;"
 type="number" name="resp_day" placeholder="day" min="1" max="31" value="<?php echo $existingRespDay ?? ''; ?>" required>
 <select name="month" style="font-size: 18px; text-align: center; border: none; border-bottom: 1px solid black; padding: 0; margin: 0; height: 30px; line-height: normal; box-sizing: border-box;" required>
    <?php foreach ($tagalogMonths as $englishMonth => $tagalogMonth): ?>
        <option value="<?php echo $englishMonth; ?>" <?php echo (strcasecmp($englishMonth, date('F')) === 0) ? 'selected' : ''; ?>><?php echo $tagalogMonth; ?></option>
    <?php endforeach; ?>
</select>,
                
                <input style="border: none; border-bottom: 1px solid black; border-bottom: 1px solid black; width: 42px; font-size: 18px;"
 type="text" name="resp_year" placeholder="year" size="1" value="<?php echo isset($existingRespYear) ? $existingRespYear : date('Y'); ?>" required>
at bakit ang iyong sumbong ay di-dapat ipawalang-saysay, at kung bakit di-dapat magpalabas ng paghahadlang na makapagsakdal ka sa hukuman/tanggapan ng pamahalaan, at di mo pagharap o pagtangging humarap sa Punong Barangay/Tagapangulo ng Lupon.


<br>
 <p style="text-indent: 2em; font-size: 18px; font-family: 'Times New Roman', Times, serif;">Ngayong ika-    <input style="text-align: center; width: 30px; border: none; border-bottom: 1px solid black; border-bottom: 1px solid black;  font-size: 18px;" type="number" name="made_day" placeholder="day" min="1" max="31" value="<?php echo $existingMadeDay; ?>"> araw ng
 <select name="month" style="font-size: 18px; text-align: center; border: none; border-bottom: 1px solid black; padding: 0; margin: 0; height: 30px; line-height: normal; box-sizing: border-box;" required>
    <?php foreach ($tagalogMonths as $englishMonth => $tagalogMonth): ?>
        <option value="<?php echo $englishMonth; ?>" <?php echo (strcasecmp($englishMonth, date('F')) === 0) ? 'selected' : ''; ?>><?php echo $tagalogMonth; ?></option>
    <?php endforeach; ?>
</select>,
                
                <input style="border: none; border-bottom: 1px solid black; border-bottom: 1px solid black; width: 44px; font-size: 18px;" type="number" name="made_year" size="1" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingMadeYear) ? $existingMadeYear : date('Y'); ?>">.
              
<div id="nameInput" style="display: none;">
  <input type="text" id="name" name="name" placeholder="Enter Name" oninput="updateOptionText(this.value)" onkeydown="checkEnterKey(event)">
</div>
<p class="important-warning-text" style="text-align: center; font-size: 18px; margin-left: 350px; margin-right: auto;">
    <span style="min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
        <?php echo !empty($punong_barangay) ? $punong_barangay : '&nbsp;'; ?>
    </span></p>
    <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: center; margin-left: 420px; font-size: 18px; font-weight: normal; white-space: nowrap; max-width: 250px;">
    Punong Barangay/Tagapangulo ng Pangkat</label><br>
               
 
                    </div>
<div style="font-size: 18px; text-indent: 2em;"> 
Pinaabisuhan ngayong ika- <input style="text-align: center; width: 30px; border: none; border-bottom: 1px solid black; border-bottom: 1px solid black;  font-size: 18px;" type="text" name="received_day" placeholder="day" size="5" value="<?php echo $existingReceivedDay ?? ''; ?>"> araw ng
<select name="month" style="font-size: 18px; text-align: center; border: none; border-bottom: 1px solid black; padding: 0; margin: 0; height: 30px; line-height: normal; box-sizing: border-box;" required>
    <?php foreach ($tagalogMonths as $englishMonth => $tagalogMonth): ?>
        <option value="<?php echo $englishMonth; ?>" <?php echo (strcasecmp($englishMonth, date('F')) === 0) ? 'selected' : ''; ?>><?php echo $tagalogMonth; ?></option>
    <?php endforeach; ?>
</select>,
<input style="border: none; border-bottom: 1px solid black; border-bottom: 1px solid black; width:44px; font-size: 18px;" type="number" name="received_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingReceivedYear) ? $existingReceivedYear : date('Y'); ?>">.
        </div>
    </div>

    <div class="d">
    <div style="font-size: 18px; text-align: center; ">
    <div style="text-align: center;">
        <p style="text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif; ">(Mga) Maysumbong</p>
        <ul style="margin-bottom: 10; padding: 0; list-style: none; font-size: 18px; text-align: center;">
        <span style="width: 380px; min-width: 250px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;font-family: 'Times New Roman', Times, serif;"><?php echo $cNames; ?></span>
           
        </ul>
    </div>

    <div style="text-align: center; font-family: 'Times New Roman', Times, serif;">
        <p style="font-size: 18px; font-family: 'Times New Roman', Times, serif; "><br>(Mga) Ipinagsusumbong</p>
        <ul style="margin-bottom: 10; padding: 0; list-style: none; font-size: 18px; text-align: center;">
        <span style="width: 380px;min-width: 250px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;font-family: 'Times New Roman', Times, serif;"><?php echo $rspndtNames; ?></span>
          
        </ul>
    </div>
</div>
<form>
                    <?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
            
    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button" style="position: fixed; right: 20px; top: 130px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
</form><br><br>
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
        filename: 'kp_form18_' + barangayCaseNumber + '.pdf', // Dynamic filename
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
</div>
</div>
</body>
</html>