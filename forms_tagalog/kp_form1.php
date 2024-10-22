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
    <title>KP Form 1 Tagalog</title>
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
        max-width: 100%; /* Adjust as needed */
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

    <a href="<?php echo $backButton; ?>">
        <button class="btn common-button" style="position:fixed; right: 20px; top: 177px;">
            <i class="fas fa-arrow-left"></i> Back
        </button>
    </a>
               
                </div>      <h5> <b style="font-family: 'Times New Roman', Times, serif;">Pormularyo ng KP Blg. 1</b></h5>

<div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
<div style="display:inline-block;text-align: center;">
<img class="profile-img" src="<?php echo $profilePicture; ?>" alt="Profile Picture" style="height: 80px; width: 80px;">
<img class="profile-img" src="<?php echo $lgulogo; ?>" alt="Lgu Logo" style="height: 80px; width: 80px;">
<img class="profile-img" src="<?php echo $citylogo; ?>" alt="City Logo" style="height: 80px; width: 80px;">

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

                <form method="POST">
<div class="e" style="font-size: 18px; text-align: right; margin-right:40px;"> <br>
        
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
                <input type="number" name="made_year" placeholder="year" style="width: 55px; border: none; border-bottom: 1px solid black; font-size: 18px; font-family: 'Times New Roman', Times, serif;" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingMadeYear) ? $existingMadeYear : date('Y'); ?>">



                <h3 style="text-align: center;"><b style="font-size: 18px;font-family: 'Times New Roman', Times, serif;">PAABISO TUNGKOL SA PAGBUO NG LUPON</b></h3>
                <div style="text-align: left;">
                    <p style="text-align: justify; font-size: 18px; margin-top: 0;">Sa lahat ng mga Kasapi ng Barangay at lahat ng iba pang kinauukulan:</p>
                    <p style="text-align: justify; font-size: 18px; text-indent: 1.5em;">Sa pagtalima sa Seksyon 1 (a. Kabanata 7, Pamagat Isa, Aklat III ng kodigo ng Pamahalaang lokal ng 1991 (Batas ng Republika Blg. 7160), ng Batas ng Katarungang Pambarangay, ang paabiso ay dito’y ibinibigay upang bumuo ng Lupong Tagapamayapa ng Barangay na ito. Ang mga taong isasaalangalang ko para sa paghirang ay ang mga sumusunod:</p>
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

    </div>

            <script>
function openAndLoadForm(formSrc, punongBarangayValue, luponChairmanValue) {
        const iframe = document.getElementById('kp-form-iframe');
        iframe.src = `${formSrc}?punong_barangay=${punongBarangayValue}&lupon_chairman=${luponChairmanValue}`;

        const modal = document.getElementById('kp-form-modal');
        modal.style.display = 'block';
    }

    
    document.getElementById('open-kp-form1').addEventListener('click', function() {
        // forms/kp_form1.php before
        openAndLoadForm('kp_form1.php', '<?= strtoupper($apptNames['punong_barangay'] ?? '') ?>', '<?= strtoupper($apptNames['lupon_chairman'] ?? '') ?>');
    });

                function resetFields() {

            document.getElementById('day').value = "";
        

            var inputs = document.querySelectorAll('.paper div[style="display: flex;"] input[type="text"]');

                inputs.forEach(function(input) {
            input.value = "";
                });
            }
            </script>


                <p style="text-align: justify; text-indent: 1.5em; font-size:18px;">Sila ay pinipili batay sa kanilang kaangkupan para sa tungkulin ng pagkakasundo na isinaalang-alang ang kanilang katapatan, walang kinikilingan, kalayaan ng pag-iisip, pagkamakatarungan, reputasyon sa pagkamatapat batay sa kanilang edad, katayuang pang lipunan, pagkamatiyaga, pagkamaparaan, madaling makibagay, malawak ang pag-iisip at iba pang kaugnay na dahilan. Ayon sa batas, iyon lamang tunay na naninirahan o nagtratrabaho sa barangay na hindi hayagang inaalisan ng karapatan ng batas ang nararapat na hirangin bilang kasapi ng Lupon.</p>

              
                    <p style="text-align: justify; text-indent: 1.5em; font-size:18px;">
                    Ang lahat ng tao ay inaanyayahan na kagyat na ipabatid sa aking ang kanilang pagsalungat kaya o pag-iindorso sa sinuman o lahat ng mga pinanukalang mga kasapi o magrekomenda sa akin ng iba pang mga tao na hindi kabilang sa talaan ni hindi lalampas ng 
    <select name="received_month" style="text-align: center; height: 30px; border: none; border-bottom: 1px solid black;  font-size: 18px; font-family: 'Times New Roman', Times, serif;">
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option value="<?php echo $existingReceivedMonth; ?>" <?php echo ($m === $existingReceivedMonth) ? 'selected' : ''; ?>><?php echo $existingReceivedMonth; ?></option>
        <?php else: ?>
            <option value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
                    <input type="text" name="received_day" placeholder="araw" size="5" style="text-align: center; border: none; border-bottom: 1px solid black; text-align: center; width: 38px; font-size: 18px; font-family: 'Times New Roman', Times, serif;" value="<?php echo $existingReceivedDay ?? ''; ?>" required>
    <input type="number" name="received_year" placeholder="year" style="width: 54px; border: none; border-bottom: 1px solid black; font-size: 18px; font-family: 'Times New Roman', Times, serif;" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingReceivedYear) ? $existingReceivedYear : date('Y'); ?>">

                    </p>
             
                    <?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
   
    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button" style="position: fixed; right: 20px; top: 130px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                </form>

                <?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

    
    <body>
    <br>
    <p class="important-warning-text" style="font-family: 'Times New Roman', Times, serif; text-align: center; font-size: 18px; margin-left: 450px; margin-right: auto;">
    <input type="text" id="positionInput" name="pngbrgy" style="font-family: 'Times New Roman', Times, serif; border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 18px;" size="25" value="<?= $existingPngbrgy ?? strtoupper($linkedNames['punong_barangay']) ?>">
    Punong Barangay
</p>

                    <div><br><br>
                    <i><p class="important-warning-text" style="text-align: justify; font-size: 18px;text-indent: 1.5em;">
                    MAHALAGA: 
                    Ang paabisong ito ay kinakailangang ipaskel sa tatlong (3) hayag na lugar sa <p  style="text-align: justify; font-size: 18px;text-indent: 1.5em;"> barangay ng di kukulangin sa 
            
                    tatlong (3) linggo.
                    </p>
                    <p class="important-warning-text" style="text-align: justify; font-size: 18px; text-indent: 1.5em;">
                    BABALA:  Ang pagpunit o pagsira ng pabatid na ito ay sasailalim ng parusa nang naaayon sa <p  style="text-align: justify; font-size: 18px;text-indent: 1.5em;"> batas.
                    </p></i>
                    <br>
                    </div>
        </div>
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