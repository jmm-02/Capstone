<?php
session_start();
include '../connection.php';

$linkedNames = $_SESSION['linkedNames'] ?? [];

$currentYear = date('Y'); // Get the current year
$currentMonth = date('F'); 
$currentDay = date('j');

include '../form_logo.php';
$cNum = $_SESSION['cNum'] ?? '';

$userID = $_SESSION['user_id'];
$formUsed = 5; // Assuming $formUsed value is set elsewhere in your code


$id = $_GET['formID'] ?? '';

if (!empty($id)){
    $backButton = '../user_used_forms.php';
}
else{
    $backButton = '../user_lupon.php';
}
if (!empty($id)) {
    $query = "SELECT made_date, received_date, lupon1, lupon2, brgysec FROM luponforms WHERE id = :id";
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

        // Extract lupon1 and pngbrgy values
        $existingLupon = $row['lupon1'];
        $existingLupon2 = $row['lupon2'];

        $existingbrgysec = $row['brgysec'];

    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data
    $madeDate = createDateFromInputs($_POST['made_day'], $_POST['made_month'], $_POST['made_year']);
    $receivedDate = createDateFromInputs($_POST['received_day'], $_POST['received_month'], $_POST['received_year']);

    $lupon1 = $_POST['lupon1'] ?? '';
    $lupon2 = $_POST['lupon2'] ?? '';

    $brgysec = $_POST['brgysec'] ?? '';


    // Insert or update data in the database
    $sql = "INSERT INTO luponforms (user_id, formUsed, made_date, received_date, lupon1, lupon2, brgysec) VALUES (?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE lupon1 = VALUES(lupon1), lupon2 = VALUES(lupon2), brgysec = VALUES(brgysec)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$userID, $formUsed, $madeDate, $receivedDate, $lupon1, $lupon2, $brgysec]);

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
    <title>KP Form 5 Tagalog</title>
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
               
                </div>      <h5> <b style="font-family: 'Times New Roman', Times, serif;">Pormularyo ng KP Blg. 5</b></h5>

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
                <input type="text" name="made_day" placeholder="day" size="5" style="text-align: center; border: none; border-bottom: 1px solid black; text-align: center; width: 30px; font-size: 18px; font-family: 'Times New Roman', Times, serif;" value="<?php echo $existingMadeDay ?? ''; ?>" required>
                <input type="number" name="made_year" placeholder="year" style="width: 60px; border: none; border-bottom: 1px solid black; font-size: 18px; font-family: 'Times New Roman', Times, serif;" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingMadeYear) ? $existingMadeYear : date('Y'); ?>">

<h3 style="text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif; font-weight: bold;">
<br>PANUNUMPA SA KATUNGKULAN</h3><br>
                <div style="text-align: left;">
                <p style="text-indent: 2em; text-align: justify; font-family: 'Times New Roman', Times, serif; font-size: 18px;"> Bilang pag-alinsunod sa Kabanata 7, Pamagat Isa, Aklat II, ng kodigo ng Pamahalaang Lokal ng 1991 (Batas ng Republika Blg. 7160), Ako si 

 <input type="text" id="lupon1" placeholder="" name="lupon1" list="nameList" value="<?php echo $existingLupon ?? ''; ?>" required style="width:250px; height: 20px; border: none;  font-size: 18px; font-family: 'Times New Roman', Times, serif; border-bottom: 1px solid black; outline: none; size= 1;">,</p>
    <datalist id="nameList">
        <?php foreach ($linkedNames as $name): ?>
            <option value="<?php echo $name; ?>">
        <?php endforeach; ?>
    </datalist>
                   <p style="text-align: justify; font-size: 18px; font-family: 'Times New Roman', Times, serif;">  , na karapat-dapat at karampatang hinirang na KASAPI ng Lupong Tagapamayapa ng Barangay na ito, ay taimtim na nanunumpa (o naninindigan) na tutuparin ko nang buong husay at katapatan, sa abot aking kakayahan, ang aking mga tungkulin at gawain bilang kasapi at bilang kasapi ng Pangkat ng Tagapagsundo, kung saan ako’y napili upang magligkod; na ako’y tunay na mananalig at magiging matapat sa Republika ng Pilipinas; na aking itataguyod at ipagtatanggol ang Saligang Batas; at susunding ang mga batas, mga utos na ayon sa batas, at mga atas na pinaiiral ng mga sadyang itinakdang may kapangyarihan nito; at kusang-loob kong babalikatin ang pananagutang ito nang walang anumang pasubali o hangaring umiwas.
                </p>
                </div>

        <div style="position: relative;"><br>
        <p style="text-align: justify; font-size: 18px; font-family: 'Times New Roman', Times, serif; text-indent: 2em;">
        KASIHAN NAWA  AKO NG  DIYOS.  (Laktawan ang huling pangungusap kung naninindigan).</p>

    <br>

    <p class="important-warning-text" style="text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif; margin-left: 450px; margin-right: auto;">
    <input type="text" id="lupon2" name="lupon2" list="nameList" value="<?php echo $existingLupon2 ?? ''; ?>" required style="font-size: 18px; width: 100%; border: none; border-bottom: 1px solid black; text-align: center; margin-right: 0;">
    <datalist id="nameList">
        <?php foreach ($linkedNames as $name): ?>
            <option value="<?php echo $name; ?>">
        <?php endforeach; ?>
    </datalist>
    <br><p style="font-size: 18px; font-family: 'Times New Roman', Times, serif; margin-top: 20px; margin-right: 140px;">Kasapi
    </p><br><br><br>
    
    <form method="POST">
                    <p style="text-align: justify; font-size: 18px; font-family: 'Times New Roman', Times, serif; text-indent: 2em;">
                        NILAGDAAN at PINANUMPAAN (o PINANININDIGAN) sa harap ko ngayong ika-
                       <input type="text" name="received_day" placeholder="araw" size="5" style="text-align: center; border: none; border-bottom: 1px solid black; text-align: center; width: 40px; font-size: 18px; font-family: 'Times New Roman', Times, serif;" value="<?php echo $existingReceivedDay ?? ''; ?>" required> ng
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
         
    <?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
   
    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button" style="position: fixed; right: 20px; top: 130px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    
   <br>
    <p class="important-warning-text" style="text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif; margin-left: 440px; margin-right: auto;">
    <input type="text" id="brgysec" name="brgysec" style="border: none; text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif; border-bottom: 1px solid black; outline: none;" size="25" value="<?php echo $existingbrgysec ?? strtoupper($linkedNames['punong_barangay']); ?>" required>
    <p style="font-size: 18px; font-family: 'Times New Roman', Times, serif; margin-top: 20px; margin-right: 90px;">Punong Barangay
</p>
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
            filename: 'kp_form5_' + barangayCaseNumber + '.pdf', // Dynamic filename
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