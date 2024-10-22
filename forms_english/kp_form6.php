<?php
session_start();
include '../connection.php';

$linkedNames = $_SESSION['linkedNames'] ?? [];
$apptNames = $_SESSION['apptNames'] ?? [];

$currentYear = date('Y'); // Get the current year
$currentMonth = date('F'); 
$currentDay = date('j');

include '../form_logo.php';
$cNum = $_SESSION['cNum'] ?? '';

$userID = $_SESSION['user_id'];
$formUsed = 6; // Assuming $formUsed value is set elsewhere in your code


$id = $_GET['formID'] ?? '';
if (!empty($id)){
    $backButton = '../user_used_forms.php';
}
else{
    $backButton = '../user_lupon.php';
}
if (!empty($id)) {
    $query = "SELECT made_date, received_date, lupon1, lupon2, lupon3, lupon4, lupon5, lupon6, lupon7, lupon8, lupon9, lupon10, lupon11, lupon12, lupon13, lupon14, lupon15, lupon16, lupon17, pngbrgy FROM luponforms WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Extract and format the timestamp values for made_date
        $madeDate = new DateTime($row['made_date']);
        $existingMadeDay = $madeDate->format('j');
        $existingMadeMonth = $madeDate->format('F');
        $existingMadeYear = $madeDate->format('Y');

        $receivedDate = new DateTime($row['received_date']);
        $existingReceivedDay = $receivedDate->format('j');
        $existingReceivedMonth = $receivedDate->format('F');
        $existingReceivedYear = $receivedDate->format('Y');

        // Extract lupon values
        $luponValues = [];
        for ($i = 1; $i <= 17; $i++) {
            $luponKey = "lupon$i";
            $luponValues[$i] = $row[$luponKey];
        }
        $existingPngbrgy = $row['pngbrgy'];

    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data
    $madeDate = createDateFromInputs($_POST['made_day'], $_POST['made_month'], $_POST['made_year']);
    $receivedDate = createDateFromInputs($_POST['received_day'], $_POST['received_month'], $_POST['received_year']);
    $pngbrgy = $_POST['pngbrgy'] ?? '';

    $luponValues = [];
    for ($i = 1; $i <= 17; $i++) {
        $luponKey = "lupon$i";
        $luponValues[$i] = $_POST[$luponKey] ?? '';
    }

    // Insert or update data in the database
$sql = "INSERT INTO luponforms (user_id, formUsed, made_date, received_date, lupon1, lupon2, lupon3, lupon4, lupon5, lupon6, lupon7, lupon8, lupon9, lupon10, lupon11, lupon12, lupon13, lupon14, lupon15, lupon16, lupon17, pngbrgy) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) 
        ON DUPLICATE KEY UPDATE 
        lupon1 = VALUES(lupon1), lupon2 = VALUES(lupon2), lupon3 = VALUES(lupon3), lupon4 = VALUES(lupon4), 
        lupon5 = VALUES(lupon5), lupon6 = VALUES(lupon6), lupon7 = VALUES(lupon7), lupon8 = VALUES(lupon8), 
        lupon9 = VALUES(lupon9), lupon10 = VALUES(lupon10), lupon11 = VALUES(lupon11), lupon12 = VALUES(lupon12), 
        lupon13 = VALUES(lupon13), lupon14 = VALUES(lupon14), lupon15 = VALUES(lupon15), lupon16 = VALUES(lupon16), 
        lupon17 = VALUES(lupon17), pngbrgy = VALUES(pngbrgy)";

        $stmt = $conn->prepare($sql);

$bindValues = array_merge([$userID, $formUsed, $madeDate, $receivedDate], $luponValues, [$pngbrgy]);
    $stmt->execute($bindValues);


    if ($stmt->rowCount() > 0) {
        echo "Row added successfully!";
    } else {
        echo "Error adding row!";
    }
}

function createDateFromInputs($day, $month, $year) {
    if (!empty($day) && !empty($month) && !empty($year)) {
        $monthNum = date('m', strtotime("$month 1"));
        return date('Y-m-d', mktime(0, 0, 0, $monthNum, $day, $year));
    } else {
        return date('Y-m-d');
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>KP Form 6 English</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">
    
        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

    <style>
        
        body, h5, p, select, input, button {
        font-size: 14px; /* Adjust the font size */
        font-family: 'Times New Roman', Times, serif;
    }

    .paper {
        background: white;
        margin: 0 auto;
        margin-bottom: 0.2cm; /* Adjust margin bottom */
        box-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);
        overflow: hidden;
        padding: 1%; /* Adjust the padding */
        box-sizing: border-box;
    }
 /* Regular screen styles */
 input[type="text"], input[type="number"] {
    border: none;
    border-bottom: 1px solid black;
    font-family: 'Times New Roman', Times, serif;
    font-size: 18px;
    text-align: left;
    outline: none;
    width: auto; /* Adjust width as necessary */
}

/* Print styles */
@media print {
    input[type="text"], input[type="number"] {
        border: none !important;
        border-bottom: 1px solid black !important;
        display: inline-block !important; /* Ensures the inputs are not ignored */
    }
    
    /* Force borders to be printed */
    input[type="text"]:after, input[type="number"]:after {
        content: "";
        display: block;
        margin-top: -1px;
        border-bottom: 1px solid black;
    }
    
    /* Ensure text inputs are visible */
    input[type="text"], input[type="number"], select {
        color: black !important; /* Ensures text is black */
        background-color: white !important; /* Ensures background is white */
        -webkit-print-color-adjust: exact !important; /* For Chrome, Safari */
        print-color-adjust: exact !important; /* Standard */
    }
        body, h5, p, select, input, button {
        font-size: 14px; /* Adjust the font size */
        font-family: 'Times New Roman', Times, serif;
    }
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
.paper {
    padding: 2%; /* Adjust the padding as needed */
    /* Other styles */
}
@media print {
    body {
        font-size: 12pt; /* Adjust as needed */
    }
    .input-field {
        max-width: 100%
        height: auto; /* Adjust as needed */
        /* Other print styles for input fields */
    }
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
button {
    font-family: 'Arial', sans-serif; /* Example font-family */
    font-size: 16px; /* Example font-size */
    font-weight: bold; /* Example font-weight */
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

    <a href="<?php echo $backButton; ?>">
        <button class="btn common-button" style="position:fixed; right: 20px; top: 177px;">
            <i class="fas fa-arrow-left"></i> Back
        </button>
    </a>
               
</div><h5><b style="font-family: 'Times New Roman', Times, serif;">KP Form No. 6</b></h5>
<div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
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
<h5 class="header" style="font-size: 18px; margin-top: 5px;">OFFICE OF THE PUNONG BARANGAY</h5>
</div>
            
</div>

          
<div class="e" style="font-size: 18px; text-align: right; font-family: 'Times New Roman', Times, serif;"> <br>
        
<?php
            $months = [
                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
            ];

            $currentYear = date('Y');
            ?>


                <form method="POST">
<div style="text-align: right;">
                <select name="made_month" style="text-align: center; height: 30px; border: none; border-bottom: 1px solid black;  font-size: 18px; font-family: 'Times New Roman', Times, serif;">
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option value="<?php echo $existingMadeMonth; ?>" <?php echo ($m === $existingMadeMonth) ? 'selected' : ''; ?>><?php echo $existingMadeMonth; ?></option>
        <?php else: ?>
            <option value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>
                <input type="text" name="made_day" placeholder="day" size="5" style="text-align: center; border: none; border-bottom: 1px solid black; text-align: center; width: 30px; font-size: 18px; font-family: 'Times New Roman', Times, serif;" value="<?php echo $existingMadeDay ?? ''; ?>">
                <input type="number" name="made_year" placeholder="year" style="width: 60px; border: none; border-bottom: 1px solid black; font-size: 18px; font-family: 'Times New Roman', Times, serif;" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingMadeYear) ? $existingMadeYear : date('Y'); ?>">


                <h3 style="text-align: center;"><b style="font-size: 18px; font-family: 'Times New Roman', Times, serif;">WITHDRAWAL OF APPOINTMENT</b></h3>
    
                <div style="text-align: left;">
                <br><p style="text-align: justify; font-size: 12px; margin-top:0; font-size: 18px;font-family: 'Times New Roman', Times, serif;">TO:
 <input type="text" id="lupon1" placeholder="" name="lupon1" list="nameList" value="<?php echo $luponValues[1] ?? ''; ?>" style="width:250px; height: 20px; border: none;  font-size: 18px; font-family: 'Times New Roman', Times, serif; border-bottom: 1px solid black; outline: none; size= 1;"></p>
    <datalist id="nameList">
        <?php foreach ($apptNames as $name): ?>
            <option value="<?php echo $name; ?>">
        <?php endforeach; ?>
    </datalist>
</p>
                <p style="text-align: justify; font-size: 12px; font-size: 18px; text-indent: 2em; font-family: 'Times New Roman', Times, serif;">
                After due hearing and with the concurrence of a majority of all the Lupong Tagapamayapa members of this Barangay, your appointment as member thereof is hereby withdrawn effective upon receipt hereof, on the following ground/s:
            </p>        
<input type="checkbox" name="lupon2" <?php echo isset($luponValues[2]) && $luponValues[2] ? 'checked' : ''; ?>>
<span style="font-size: 18px; font-family: 'Times New Roman', Times, serif;">-
incapacity to discharge the duties of your office as shown by
<input type="text" id="day1" name="lupon3" style="width: 330px; height: 20px; font-size: 18px; font-family: 'Times New Roman', Times, serif;" value="<?php echo $luponValues[3] ?? ''; ?>">.
</span>
<br>
<input type="checkbox" name="lupon4" <?php echo isset($luponValues[4]) && $luponValues[4] ? 'checked' : ''; ?>>
<span style="font-size: 18px; font-family: 'Times New Roman', Times, serif;">-
unsuitability by reason of  
<input type="text" id="day2" name="lupon5" style="width: 330px; height: 20px; font-size: 18px; font-family: 'Times New Roman', Times, serif;" value="<?php echo $luponValues[5] ?? ''; ?>"><br>
(Check whichever is applicable and detail or specify the act/s or omission/s constituting the ground/s for withdrawal.)
</span>

   
    <p class="important-warning-text" style="text-align: center; margin-left: 380px; margin-right: auto;font-size: 18px; font-family: 'Times New Roman', Times, serif;">
    <input type="text" id="positionInput" name="pngbrgy" style="font-size: 18px; font-family: 'Times New Roman', Times, serif; border: none; border-bottom: 1px solid black; outline: none; text-align: center;" size="25" value="<?= $existingPngbrgy ?? strtoupper($linkedNames['punong_barangay']) ?>">
    <p style=" margin-left: 420px; font-size: 18px; font-family: 'Times New Roman', Times, serif; margin-top: 20px;">Punong Barangay/Lupon Chairman
</p>
<br>

            <p style="text-align: justify; text-indent: 4em;font-size: 18px; margin-left:25px; font-family: 'Times New Roman', Times, serif;">CONFORME (Signatures):
            </p>
<div style="display: flex;">
<div style="flex: 1; margin-left: 95px;">
    <?php for ($i = 6; $i <= 11; $i++):?>
        <?php $formattedIndex = sprintf("%02d", $i); ?>
        <?php $displayIndex = $i - 5; ?>
        <p style="margin: 0;font-size: 18px; font-family: 'Times New Roman', Times, serif;"><?php echo $displayIndex; ?>. <input type="text" name="lupon<?php echo $i; ?>" style="width: 210px; margin-bottom: 5px;" value="<?php echo $luponValues[$i] ?? ''; ?>"></p>
    <?php endfor; ?>
</div>
<div style="flex: 1; margin-left: 10px;">
    <?php for ($i = 12; $i <= 16; $i++): ?>
        <?php $formattedIndex = sprintf("%02d", $i); ?>
        <?php $displayIndex = $i - 5; ?>
        <p style="margin: 0;font-size: 18px; font-family: 'Times New Roman', Times, serif;"><?php echo $displayIndex; ?>. <input type="text" name="lupon<?php echo $i; ?>" style="width: 210px; margin-bottom: 5px;" value="<?php echo $luponValues[$i] ?? ''; ?>"></p>
    <?php endfor; ?>
</div>



</div>

        </div><br><br>
                </div>

        
            <div style="text-align: justify; text-indent: 2em; font-size: 18px; font-family: 'Times New Roman', Times, serif">
            Received this
            <input type="number" name="received_day" placeholder="day" min="1" max="31" style="text-align: center; font-size: 18px; border: none; border-bottom: 1px solid black;" value="<?php echo $existingReceivedDay ?? ''; ?>">
            of
            <select name="received_month" style="font-size: 18px; text-align: center; border: none; border-bottom: 1px solid black; padding: 0; margin: 0; height: 30px; line-height: normal; box-sizing: border-box;">
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option style="font-size: 18px;" value="<?php echo $existingReceivedMonth; ?>" <?php echo ($m === $existingReceivedMonth) ? 'selected' : ''; ?>><?php echo $existingReceivedMonth; ?></option>
        <?php else: ?>
            <option style="font-size: 18px;" value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
<input type="number" name="received_year" placeholder="year" style="font-size: 18px; text-align: center; border: none; border-bottom: 1px solid black; width: 60px;" value="<?php echo $existingReceivedYear ?? date('Y'); ?>">.</div>
   
    <br><br>
    <p class="important-warning-text" style="text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif; margin-left: 440px; margin-right: auto;">
    <input type="text" name="lupon17" style="border: none; text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif; border-bottom: 1px solid black; outline: none;" size="25" value="<?php echo $luponValues[17] ?? '' ?>">    <p style="font-size: 18px; font-family: 'Times New Roman', Times, serif; margin-top: 20px; margin-right: 120px;">Signature
</p><br>
    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button" style="position: fixed; right: 20px; top: 130px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                </form>

    <p style="text-align: justify; font-size: 18px; margin-right: 700px; font-size: 18px; font-family: 'Times New Roman', Times, serif;">NOTE:
    <p style="text-align: justify; font-size: 12px; text-indent: 2em;font-size: 18px;font-family: 'Times New Roman', Times, serif;">
    The members of the <i>Lupon</i> conforming to the withdrawal must personally affix their signatures or thumb marks on the pertinent
spaces above. The withdrawal must be conformed to by more than one-half of the total number of members of the <i>Lupon</i> including
the Punong Barangay and the member concerned.
    
</p>    
    <div class="blank-page"></div>
    </body>
        </div>
        
        <script>
    var barangayCaseNumber = "<?php echo $cNum; ?>"; // Assume $cNum is your case number variable
    document.getElementById('downloadButton').addEventListener('click', function () {
        // Elements to hide during PDF generation
        var buttonsToHide = document.querySelectorAll('.top-right-buttons button');
        
        // Hide the specified buttons
        buttonsToHide.forEach(function (button) {
            button.style.display = 'none';
        });

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
            filename: 'kp_form6_' + barangayCaseNumber + '.pdf', // Dynamic filename
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

            // Show the other buttons after PDF generation
            buttonsToHide.forEach(function (button) {
                button.style.display = 'inline-block';
            });

            // Restore borders for all input types and select
            inputFields.forEach(function (field) {
                field.style.border = ''; // Use an empty string to revert to the default border
            });
        });
    });
</script>
</body>
</html> 