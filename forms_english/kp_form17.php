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

include '../form_logo.php';

?>

<!DOCTYPE html>
<html>
<head>
    <title>KP FORM 17</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">

    <style>
  .profile-img{
   width: 3cm;
}

.header {
   text-align: center;
   padding-inline: 4cm;
}
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

    }
    h5{
        margin:0;
        padding:0;
    }
    .checkbox-container {
        display: flex;
        align-items: center;
    }

    .checkbox-label {
        margin-left: 10px;
        font-size: 18px;
        font-weight:normal;
    }

    .a {
        margin-top: 5px;
        margin-bottom: 15px;
    }
    
    body {
    background: rgb(204, 204, 204);
}

    @media print {
        
        
        .checkbox-label {
            border-bottom: none;
        }
        #nameR {
            border-bottom: none;
        }
    }
</style>
</head>
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


            </div>      <h5> <b style="font-family: 'Times New Roman', Times, serif;">KP Form No. 17 </b></h5>
     <div style="display:inline-block;text-align: center;">
            <img class="profile-img" src="<?php echo $lgulogo; ?>" alt="Lgu Logo" style="height: 80px; width: 80px;">
<img class="profile-img" src="<?php echo $profilePicture; ?>" alt="Profile Picture" style="height: 80px; width: 80px;">

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
        <h5 class="header" style="font-size: 18px;">OFFICE OF THE LUPONG TAGAPAMAYAPA</h5>
    </div>
<br>

                <?php
                $months = [
                    'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

                $currentYear = date('Y');
                ?>
  
   <div class="form-group" style="text-align: justify; font-family: 'Times New Roman', Times, serif;" >
    <div class="input-field" style="float: right; width: 50%;">
        <!-- case num here -->
        <p style="text-align: left; margin-left:30px; font-size: 18px;">Barangay Case No.<span style="min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
    <?php echo !empty($cNum) ? $cNum : '&nbsp;'; ?></span></p>

        <p style="text-align: left; margin-left:30px; margin-top: 0; font-size: 18px;"> For:  <span style="border-bottom: 1px solid black; font-size: 18px;"><?php echo !empty($forTitle) ? nl2br(htmlspecialchars($forTitle)) : '&nbsp;'; ?></span> </p>
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

<form method ="POST">
<h3 style="text-align: center;"><b style="font-size: 18px; font-family: 'Times New Roman', Times, serif;">REPUDIATION</b></h3>

<div style="text-align: justify; text-indent: 0em; margin-left: 1px; font-size: 18px; font-family: 'Times New Roman', Times, serif;">I/WE hereby repudiate the settlement/agreement for arbitration on the ground that my/our consent was vitiated by: <br>
(Check out whichever is applicable)
    </div>
    <br>

<div style="font-size: 18px; font-family: 'Times New Roman', Times, serif;">
    <div class="checkbox-container">
        <input type="checkbox" id="fraudCheckbox" name="fraudcheck" <?php if(isset($existingFraudCheck) && $existingFraudCheck == 1) echo "checked"; ?>>
        <label for="fraudCheckbox" class="checkbox-label"> Fraud. (State details)</label>
    </div>
    <div class="a">
        <textarea placeholder="Type here" id="fraudtext" name="fraudtext" style="text-decoration: underline; width: 95%; margin-left: 20.5px; border: none; overflow-y: auto; resize: vertical; font-size: 18px; white-space: pre-line;" contenteditable="true"><?php echo $existingFraudText; ?></textarea>
    </div>

    <div class="checkbox-container">
        <input type="checkbox" id="violenceCheckbox" name="violencecheck" <?php if(isset($existingViolenceCheck) && $existingViolenceCheck == 1) echo "checked"; ?>>
        <label for="violenceCheckbox" class="checkbox-label"> Violence. (State details)</label>
    </div>
    <div class="a">
        <textarea placeholder="Type here"  id="violencetext" name="violencetext" style="text-decoration: underline; width: 95%; margin-left: 20.5px; border: none; overflow-y: auto; resize: vertical; font-size: 18px; white-space: pre-line;" contenteditable="true"><?php echo $existingViolenceText; ?></textarea>
    </div>

    <div class="checkbox-container">
        <input type="checkbox" id="intimidationCheckbox" name="intimidationcheck" <?php if(isset($existingIntimidationCheck) && $existingIntimidationCheck == 1) echo "checked"; ?>>
        <label for="intimidationCheckbox" class="checkbox-label"> Intimidation. (State details)</label>
    </div>
    <div class="a">
        <textarea placeholder="Type here" id="intimidationtext" name="intimidationtext" style="text-decoration: underline; width: 95%; margin-left: 20.5px; border: none; overflow-y: auto; resize: vertical; font-size: 18px; white-space: pre-line;" contenteditable="true"><?php echo $existingIntimidationText; ?></textarea>
    </div>
</div>


    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;font-size: 18px;font-family: 'Times New Roman', Times, serif; "> This
    <input style="text-align:center; width:44px; font-size: 18px;font-family: 'Times New Roman', Times, serif; " type="number" name="made_day" placeholder="day" min="1" max="31" value="<?php echo $existingMadeDay ?? ''; ?>"> day of
    <select style="text-align:center; font-size: 18px;font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black;" name="made_month" required>
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option style="text-align:center;font-size: 18px;font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black;" value="<?php echo $existingMadeMonth; ?>" <?php echo ($m === $existingMadeMonth) ? 'selected' : ''; ?>><?php echo $existingMadeMonth; ?></option>
        <?php else: ?>
            <option style="text-align:center;font-size: 18px;font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black;" value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
                <input style="text-align:center; font-size: 18px;font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black;" type="number" name="made_year" size="1" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingMadeYear) ? $existingMadeYear : date('Y'); ?>">.</div> 
<br>

<div style="font-family: 'Times New Roman', Times, serif;">
    <!-- Section for Names and Labels -->
    <div style="display: flex; justify-content: space-around; align-items: center; margin-top: 20px;">
        <!-- Complainant Name and Label Container -->
        <div style="text-align: center;">
            <span style="width:280px; border-bottom: 1px solid black; font-size: 18px; display: inline-block;">
                <?php echo !empty($cNames) ? nl2br(htmlspecialchars($cNames)) : '&nbsp;'; ?>
            </span>
            <div style="font-size: 18px; margin-top: 10px;">
                Complainant/s
            </div>
        </div>
        

        <!-- Respondent Name and Label Container -->
        <div style="text-align: center;">
            <span style="width:280px;  border-bottom: 1px solid black; font-size: 18px; display: inline-block;">
                <?php echo !empty($rspndtNames) ? nl2br(htmlspecialchars($rspndtNames)) : '&nbsp;'; ?>
            </span>
            <div style="font-size: 18px; margin-top: 10px;">
                Respondent/s
            </div>
        </div>
    </div>
</div>

<br>
<div style="text-align: justify; text-indent: 0em; margin-left: 20.5px; font-size: 18px;font-family: 'Times New Roman', Times, serif; "> SUBSCRIBED AND SWORN TO before me this <input style="width:44px;text-align:center; font-size: 18px;font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black;" type="text" name="resp_day" placeholder="day" size="5" value="<?php echo $existingRespDay ?? ''; ?>"> day of
  <select style="text-align:center; font-size: 18px;font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black;" name="resp_month" required>
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option style="text-align:center;font-size: 18px;font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black;" value="<?php echo $existingRespMonth; ?>" <?php echo ($m === $existingRespMonth) ? 'selected' : ''; ?>><?php echo $existingRespMonth; ?></option>
        <?php else: ?>
            <option style="text-align:center;font-size: 18px;font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black;" value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
<input  style="text-align:center;font-size: 18px;font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black;" type="number" name="resp_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingRespYear) ? $existingRespYear : date('Y'); ?>">.
                
</div><br><br><br>
<p class="important-warning-text" style="text-align: center; font-size: 18px; margin-left: 550px; margin-right: auto;">
    <span style="min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
        <?php echo !empty($punong_barangay) ? $punong_barangay : '&nbsp;'; ?>
    </span></p>
    <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: center; margin-left: 410px;   font-size: 18px; font-weight: normal; white-space: nowrap; max-width: 200px;">Punong Barangay/Pangkat Chairman/Member</label>
               
<br>
<br>
<div style="text-align: justify; text-indent: 0em; margin-left: 20.5px; font-size: 18px; "> Received and filed * this <input style="width:44px; text-align:center; font-size: 18px;font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black;" type="text" name="received_day" placeholder="day" size="5" value="<?php echo $existingReceivedDay ?? ''; ?>">  of
                

                <select style="text-align:center;font-size: 18px;font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black;" name="received_month" required>
               <?php foreach ($months as $m): ?>
                   <?php if ($id > 0): ?>
                       <option style="text-align:center;font-size: 18px;font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black;" value="<?php echo $existingReceivedMonth; ?>" <?php echo ($m === $existingReceivedMonth) ? 'selected' : ''; ?>><?php echo $existingReceivedMonth; ?></option>
                   <?php else: ?>
                       <option style="text-align:center;font-size: 18px;font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black;" value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
                   <?php endif; ?>
               <?php endforeach; ?>
           </select> ,
                                               <input style="text-align:center; font-size: 18px;font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black;" type="number" name="received_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingReceivedYear) ? $existingReceivedYear : date('Y'); ?>">
                                               </div>
                                          

<p class="important-warning-text" style="text-align: center; font-size: 18px; margin-left: 550px; margin-right: auto;">
    <span style="min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
        <?php echo !empty($punong_barangay) ? $punong_barangay : '&nbsp;'; ?>
    </span></p>
    <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: center; margin-left: 580px;   font-size: 18px; font-weight: normal; white-space: nowrap; max-width: 200px;">Punong Barangay</label>
               <br> <br>
  <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px; font-size: 18px; ">* Failure to repudiate the settlement or the arbitration agreement within the time limits respectively set (ten [10] days from the date of settlement and five[5] days from the date of arbitration agreement) shall be deemed a waiver of the right to challenge on
said grounds.
    </div>       
</div>

            
                <?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button no-print" style="position:fixed; right: 20px; top: 130px;">
</form>

<script>
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

            // Use html2pdf to generate a PDF
            html2pdf(pdfContent, {
                margin: 10,
                filename: 'your_page.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
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
                    </body>
</html>
