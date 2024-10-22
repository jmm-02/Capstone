<?php
session_start();
$apptNames = $_SESSION['apptNames'] ?? [];
$linkedNames = $_SESSION['linkedNames'] ?? [];

include '../connection.php'; // my database connection

$currentYear = date('Y'); // Get the current year

// Array of months
$months = array(
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
);

$currentMonth = date('F'); 
$currentDay = date('j');

include '../form_logo.php';
$cNum = $_SESSION['cNum'] ?? '';
$userID = $_SESSION['user_id'];
$formUsed = 1; // Assuming $formUsed value is set elsewhere in your code


$id = $_GET['formID'] ?? '';


if (!empty($id)){
    $backButton = '../user_used_forms.php';
}
else{
    $backButton = '../user_lupon.php';
}

// Fetch existing data based on the provided formID
if (!empty($id)) {
    $query = "SELECT made_date, received_date, lupon1, lupon2, lupon3, lupon4, lupon5, lupon6, lupon7, lupon8, lupon9, lupon10, lupon11, lupon12, lupon13, lupon14, lupon15, lupon16, lupon17, lupon18, lupon19, lupon20, pngbrgy FROM luponforms WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Extract and format the timestamp values for made_date and received_date
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
        for ($i = 1; $i <= 20; $i++) {
            $luponKey = "lupon$i";
            $luponValues[$i] = $row[$luponKey];
        }

        // Extract pngbrgy value
        $existingPngbrgy = $row['pngbrgy'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $madeDate = createDateFromInputs($_POST['made_day'], $_POST['made_month'], $_POST['made_year']);
    $receivedDate = createDateFromInputs($_POST['received_day'], $_POST['received_month'], $_POST['received_year']);

    $lupons = array();
    for ($i = 1; $i <= 20; $i++) {
        $luponKey = "appointed_lupon_$i";
        $lupons[] = $_POST[$luponKey] ?? '';
    }

    $sql = "INSERT INTO luponforms (user_id, formUsed, made_date, received_date, ";
    for ($i = 1; $i <= 20; $i++) {
        $sql .= "lupon$i, ";
    }
    $sql .= "pngbrgy) VALUES (?, ?, ?, ?, ";
    for ($i = 1; $i <= 20; $i++) {
        $sql .= "?, ";
    }
    $sql .= "?) ON DUPLICATE KEY UPDATE ";
    for ($i = 1; $i <= 20; $i++) {
        $sql .= "lupon$i = VALUES(lupon$i), ";
    }
    $sql .= "user_id = VALUES(user_id), formUsed = VALUES(formUsed), made_date = VALUES(made_date), received_date = VALUES(received_date), pngbrgy = VALUES(pngbrgy)";

    $stmt = $conn->prepare($sql);
    $stmt->execute(array_merge([$userID, $formUsed, $madeDate, $receivedDate], $lupons, [$_POST['pngbrgy']]));

    if ($stmt->rowCount() > 0) {
        echo "Form submitted successfully!";
    } else {
        echo "Error adding form!";
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
    <title>KP Form 1 English</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- here angle the link for responsive paper -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">
</head>
<style>
    .profile-img {
        width: 3cm;
    }

    /* Hide the number input arrows for WebKit browsers like Chrome, Safari */
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

    /* Regular screen styles for text inputs */
    input[type="text"], input[type="number"] {
        border: none;
        border-bottom: 1px solid black;
        font-family: 'Times New Roman', Times, serif;
        font-size: 18px;
        text-align: left;
        outline: none;
        width: auto; /* Adjust width as necessary */
    }

    h3, h5 {
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

    /* Consolidated Print styles */
    @media print {
        body, html, .container, .paper {
            background: white;
            margin: 0;
            padding: 0;
            box-shadow: none;
            width: auto;
        }
        
        .paper {
            padding-left: 2.54cm; 
            padding-right: 2.54cm; 
        }

        input[type="text"], input[type="number"], select {
            border: none !important;
            border-bottom: 1px solid black !important;
            color: black !important;
            background-color: white !important;
            display: inline-block !important;
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
        
        input[type="text"]:after, input[type="number"]:after {
            content: "";
            display: block;
            margin-top: -1px;
            border-bottom: 1px solid black;
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
    <a href="<?php echo $backButton; ?>">
        <button class="btn common-button" style="position:fixed; right: 20px; top: 177px;">
            <i class="fas fa-arrow-left"></i> Back
        </button>
    </a>
    </div>
    <h5> <b style="font-family: 'Times New Roman', Times, serif;">KP Form No. 1</b></h5>
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
<br>
<br>
<?php
            $months = [
                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
            ];

            $currentYear = date('Y');
            ?>


<div style="text-align: right;">
<form method="POST">
                 <select name="made_month" style="text-align: center; height: 30px; border: none; border-bottom: 1px solid black;  font-size: 18px; font-family: 'Times New Roman', Times, serif;">
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option value="<?php echo $existingMadeMonth; ?>" <?php echo ($m === $existingMadeMonth) ? 'selected' : ''; ?>><?php echo $existingMadeMonth; ?></option>
        <?php else: ?>
            <option value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>
                
                <input type="text" name="made_day" placeholder="day" size="5" style="text-align: center; border: none; border-bottom: 1px solid black; text-align: center; width: 30px; font-size: 18px; font-family: 'Times New Roman', Times, serif;" value="<?php echo $existingMadeDay ?? ''; ?>" required>,</label>
                <input type="number" name="made_year" placeholder="year" style="width: 40px; border: none; border-bottom: 1px solid black; font-size: 18px; font-family: 'Times New Roman', Times, serif;" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingMadeYear) ? $existingMadeYear : date('Y'); ?>">


<h3 style="text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif; font-weight: bold;">
<br>NOTICE TO CONSTITUTE THE LUPON</h3>

<br><br><div style="text-align: left;">
                    <p style="font-family: 'Times New Roman', Times, serif; font-size: 18px;">To All Barangay Members and All Other Persons Concerned:</p>
                    <p style="text-indent: 2em; text-align: justify; font-family: 'Times New Roman', Times, serif; font-size: 18px;">In compliance with Section 1(a), Chapter 7, Title One, Book III, Local Government Code of 1991 (Republic Act No. 7160), of the
                    <i>Katarungang Pambarangay Law</i>, notice is hereby given to constitute the <i>Lupong Tagapamayapa</i> of this Barangay.
                    The persons I am considering for appointment are the following:</p>
                       <div style="display: flex;">
    <div style="flex: 1; margin-left: 70px;">
        <?php for ($i = 1; $i <= 10; $i++): ?>
            <?php $nameKey = "name$i"; ?>
            <?php $value = (!empty($id) && isset($luponValues[$i])) ? $luponValues[$i] : ($apptNames[$nameKey] ?? ''); ?>
            <p style="margin: 0; font-family: 'Times New Roman', Times, serif; font-size: 18px;"><?php echo $i; ?>. <input type="text" name="appointed_lupon_<?php echo $i; ?>" value="<?php echo $value; ?>" style="width: 250px; margin-bottom: 5px;font-family: 'Times New Roman', Times, serif; font-size: 18px;"></p>
        <?php endfor; ?>
    </div>

    <div style="flex: 1;">
        <?php for ($i = 11; $i <= 20; $i++): ?>
            <?php $nameKey = "name$i"; ?>
            <?php $value = (!empty($id) && isset($luponValues[$i])) ? $luponValues[$i] : ($apptNames[$nameKey] ?? ''); ?>
            <p style="margin: 0; font-family: 'Times New Roman', Times, serif; font-size: 18px;"><?php echo $i; ?>. <input type="text" name="appointed_lupon_<?php echo $i; ?>" value="<?php echo $value; ?>" style="width: 250px; margin-bottom: 5px; font-family: 'Times New Roman', Times, serif; font-size: 18px;"></p>
        <?php endfor; ?>
    </div>
</div>


        


                <br><br><p style="text-indent: 2em; text-align: justify; font-family: 'Times New Roman', Times, serif; font-size: 18px;">They have been chosen on the basis of their suitability for the task of conciliation considering their integrity, impartiality, independence of mind, sense of fairness and reputation for probity in view of their age, social standing in the community, tact, patience, resourcefulness, flexibility, open-mindedness and other relevant factors.
                The law provides that only those actually residing or working in the barangay who are not expressly disqualified by law are qualified to be appointed as <i>Lupon</i> members.</p>


<p style="text-indent: 2em; text-align: justify; font-family: 'Times New Roman', Times, serif; font-size: 18px;">
                        All persons are hereby enjoined to immediately inform me and of their opposition to or endorsement of any or all the proposed members or recommend to me other persons not included in the list but not later than the
    <input type="text" name="received_day" placeholder="day" size="5" style="text-align: center; border: none; border-bottom: 1px solid black; text-align: center; width: 30px; font-size: 18px; font-family: 'Times New Roman', Times, serif;" value="<?php echo $existingReceivedDay ?? ''; ?>" required>
    ,<select name="received_month" style="text-align: center; height: 30px; border: none; border-bottom: 1px solid black;  font-size: 18px; font-family: 'Times New Roman', Times, serif;">
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option value="<?php echo $existingReceivedMonth; ?>" <?php echo ($m === $existingReceivedMonth) ? 'selected' : ''; ?>><?php echo $existingReceivedMonth; ?></option>
        <?php else: ?>
            <option value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>
    <input type="number" name="received_year" placeholder="year" style="width: 40px; border: none; border-bottom: 1px solid black; font-size: 18px; font-family: 'Times New Roman', Times, serif;" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingReceivedYear) ? $existingReceivedYear : date('Y'); ?>">
(the last day for posting this notice).</div>

    <br><br><br><br>
<p class="important-warning-text" style="font-family: 'Times New Roman', Times, serif; text-align: center; font-size: 18px; margin-left: 450px; margin-right: auto;">
    <input type="text" id="positionInput" name="pngbrgy" style="font-family: 'Times New Roman', Times, serif; border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 18px;" size="25" value="<?= $existingPngbrgy ?? strtoupper($linkedNames['punong_barangay']) ?>">
    <p style="font-family: 'Times New Roman', Times, serif; text-align: center; font-size: 18px; margin-top: 15px; margin-left: 450px;">Punong Barangay</p>
</p>
<input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button" style="position: fixed; right: 20px; top: 130px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">

</form>

<div style="text-align: left; font-family: 'Times New Roman', Times, serif; font-size: 18px;">
    <div style="margin-bottom: 0;"><br><br>
        <span style="font-weight: normal; display: inline-block; width: 120px; font-size: 18px; text-indent: 2em;">IMPORTANT:</span>
        <span style="display: inline; font-size: 18px; margin-left: 180px; text-align: left; vertical-align: top;">This notice is required to be posted in three (3) conspicuous</span>
        <span style="display: inline; font-size: 18px; margin-left: 303px; text-align: left; vertical-align: top;">places in the barangay for at least three (3) weeks.</span>
    </div>
    <div style="margin-top: 20px;">
        <span style="font-weight: normal; display: inline-block; width: 140px; font-size: 18px; text-indent: 2em;">WARNING:</span>
        <span style="display: inline; font-size: 18px; margin-left: 160px; text-align: left; vertical-align: top;">Tearing or defacing this notice shall be subject to punishment</span>
        <span style="display: inline; font-size: 18px; margin-left: 303px; text-align: left; vertical-align: top;">according to law.</span>
    </div>
</div>

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
        filename: 'kp_form1_' + barangayCaseNumber + '.pdf', // Dynamic filename
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
    