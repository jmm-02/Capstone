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
$formUsed = 2; // Assuming $formUsed value is set elsewhere in your code


$id = $_GET['formID'] ?? '';

if (!empty($id)){
    $backButton = '../user_used_forms.php';
}
else{
    $backButton = '../user_lupon.php';
}

if (!empty($id)) {
    $query = "SELECT made_date, lupon1, brgysec, pngbrgy FROM luponforms WHERE id = :id";
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

        // Extract lupon1 and pngbrgy values
        $existingLupon = $row['lupon1'];
        $existingbrgysec = $row['brgysec'];

        $existingPngbrgy = $row['pngbrgy'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data
    $madeDate = createDateFromInputs($_POST['made_day'], $_POST['made_month'], $_POST['made_year']);
    $lupon1 = $_POST['lupon1'] ?? '';
    $brgysec = $_POST['brgysec'] ?? '';

    $pngbrgy = $_POST['pngbrgy'] ?? '';

    // Insert or update data in the database
    $sql = "INSERT INTO luponforms (user_id, formUsed, made_date, lupon1, brgysec, pngbrgy) VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE lupon1 = VALUES(lupon1), brgysec = VALUES(brgysec), pngbrgy = VALUES(pngbrgy)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$userID, $formUsed, $madeDate, $lupon1, $brgysec, $pngbrgy]);

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
    <title>KP Form 2 Tagalog</title>
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
        height: 29.7cm;
    }

    .paper[layout="landscape"] {
        width: 29.7cm;
        height: 21cm;
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

p {
    line-height: 1.5; /* This creates double line spacing for paragraph elements */
}
button {
    font-family: 'Arial', sans-serif; /* Example font-family */
    font-size: 16px; /* Example font-size */
    font-weight: bold; /* Example font-weight */
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
            
            <div style="text-align: left; font-family: 'Times New Roman', Times, serif;">
                <h5><b>Pormularyo ng KP Blg. 2</b></h5>
                <div style="position: relative; height: 1px; margin-right: 0px;">
   <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
<div style="display:inline-block;text-align: center;">
<img class="profile-img" src="<?php echo $profilePicture; ?>" alt="Profile Picture" style="height: 80px; width: 80px;">
<img class="profile-img" src="<?php echo $lgulogo; ?>" alt="Lgu Logo" style="height: 80px; width: 80px;">
<img class="profile-img" src="<?php echo $citylogo; ?>" alt="City Logo" style="height: 80px; width: 80px;">
<div style="text-align: center; font-family: 'Times New Roman', Times, serif;">
<br>
        <h5 style="text-align: center; font-size: 18px;">Republika ng Pilipinas</h5>
        <h5 style="text-align: center; font-size: 18px;">Lalawigan ng Laguna</h5>
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
        <h5 style="text-align: center; font-size: 18px;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
        <h5 style="text-align: center; font-size: 18px; margin-top: 5px; ">TANGGAPAN NG  LUPONG TAGAPAMAYAPA</h5>
            </div>
            <br>
            <br>
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
                
                <input type="text" name="made_day" placeholder="day" size="5" style="text-align: center; border: none; border-bottom: 1px solid black; text-align: center; width: 30px; font-size: 18px; font-family: 'Times New Roman', Times, serif;" value="<?php echo $existingMadeDay ?? ''; ?>" required>,</label>
                <input type="number" name="made_year" placeholder="year" style="width: 60px; border: none; border-bottom: 1px solid black; font-size: 18px; font-family: 'Times New Roman', Times, serif;" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingMadeYear) ? $existingMadeYear : date('Y'); ?>">

                <br>
<br><h3 style="text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif;"> <b style= "font-size: 18px;">
PAGHIRANG</b>
<br><br><br><p style="text-align: justify; font-size: 18px; margin-top: 0; font-family: 'Times New Roman', Times, serif;">PARA KAY:
    <input type="text" id="lupon1" name="lupon1" list="nameList" value="<?php echo $existingLupon ?? ''; ?>" required style="border: none; border-bottom: 1px solid black;">
    <datalist id="nameList">
        <?php foreach ($linkedNames as $name): ?>
            <option value="<?php echo $name; ?>">
        <?php endforeach; ?>
    </datalist>
</p>
                <p style="text-align: justify; font-size: 18px; text-indent: 2em; font-family: 'Times New Roman', Times, serif;">Bilang pag-alinsunod sa kabanata 7, Pamagat Isa, Aklat III, ng kodigo ng Pamahalaang lokal ng 1991 (Batas ng Republika Blg. 7160), ikaw ay hinihirang bilang KASAPI ng Lupong Tagapamayapa ng Barangay na ito na magkakabisa sa sandaling makapanumpa sa iyong tungkulin at hanggang ang bagong Lupon ay muling mabuo sa ikatlong taon kasunod ng iyong pagkakahirang.
                </p><br><br><br><br>
                </div>

            <script>
                function resetFields() {
                // Clear the value of the day input field
            document.getElementById('day').value = "";
        
                // Get all input elements within the specified div
            var inputs = document.querySelectorAll('.paper div[style="display: flex;"] input[type="text"]');
        
                // Clear the value of each input field
                inputs.forEach(function(input) {
            input.value = "";
                });
            }
            </script>

                <?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
   
                <?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
   
    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button" style="position: fixed; right: 20px; top: 130px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    <p class="important-warning-text" style="text-align: center; font-family: 'Times New Roman', Times, serif; font-size: 18px; margin-left: 450px; margin-right: auto;">
   <input type="text" id="positionInput" name="pngbrgy" style="font-family: 'Times New Roman', Times, serif; border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 18px;" size="25" value="<?= $existingPngbrgy ?? strtoupper($linkedNames['punong_barangay']) ?>">
    <br>    <p style="font-family: 'Times New Roman', Times, serif; text-align: center; font-size: 18px; margin-top: 15px; margin-left: 450px;">Punong Barangay</p>
</p>

<br><br><p style="text-align: justify; margin-left: 0;font-size: 18px;font-family: 'Times New Roman', Times, serif;">Pinatunayan:</p>
    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-right: 500px; margin-top: 30px; font-size: 18px; font-family: 'Times New Roman', Times, serif;">
    <input type="text" id="brgysec" name="brgysec" value="<?php echo $existingbrgysec ?? ''; ?>" style="border: none; text-align: center; border-bottom: 1px solid black; outline: none;font-size: 18px;font-family: 'Times New Roman', Times, serif;" size="25">
    <p style="font-family: 'Times New Roman', Times, serif; text-align: center; font-size: 18px; margin-top: 15px; margin-right: 490px;">Kalihim ng Barangay
    </p></p>
    </div>
    </div>
                </form>

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
            filename: 'kp_form2_' + barangayCaseNumber + '.pdf', // Dynamic filename
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
</div>        
</div>
</body>
</html>