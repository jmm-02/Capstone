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
$formUsed = 3; // Assuming $formUsed value is set elsewhere in your code


$id = $_GET['formID'] ?? '';
if (!empty($id)){
    $backButton = '../user_used_forms.php';
}
else{
    $backButton = '../user_lupon.php';
}
if (!empty($id)) {
    $query = "SELECT made_date, lupon1, lupon2, lupon3, brgysec FROM luponforms WHERE id = :id";
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
        $existingLupon2 = $row['lupon2'];
        $existingLupon3 = $row['lupon3'];

        $existingbrgysec = $row['brgysec'];

    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data
    $madeDate = createDateFromInputs($_POST['made_day'], $_POST['made_month'], $_POST['made_year']);
    $lupon1 = $_POST['lupon1'] ?? '';
    $lupon2 = $_POST['lupon2'] ?? '';
    $lupon3 = $_POST['lupon3'] ?? '';

    $brgysec = $_POST['brgysec'] ?? '';


    // Insert or update data in the database
    $sql = "INSERT INTO luponforms (user_id, formUsed, made_date, lupon1, lupon2, lupon3, brgysec) VALUES (?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE lupon1 = VALUES(lupon1), lupon2 = VALUES(lupon2), lupon3 = VALUES(lupon3), brgysec = VALUES(brgysec)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$userID, $formUsed, $madeDate, $lupon1, $lupon2, $lupon3, $brgysec]);

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
    <title>KP Form 3 Tagalog</title>
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
p {
    line-height: 1.5; /* This creates double line spacing for paragraph elements */
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
            

            </div>      <h5> <b style="font-family: 'Times New Roman', Times, serif;">Pormularyo ng KP Blg. 3 </b></h5>

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
            <?php
            $months = [
                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
            ];

            $currentYear = date('Y');
            ?>

<form method="POST">
                <div style="text-align: right; font-family: 'Times New Roman', Times, serif;">
    <input type="text" name="made_day" placeholder="day" size="5" style="text-align: center; border: none; border-bottom: 1px solid black; text-align: center; width: 30px; font-size: 18px; font-family: 'Times New Roman', Times, serif;" value="<?php echo $existingMadeDay ?? ''; ?>" required>,
    <select name="made_month" style="text-align: center; height: 30px; border: none; border-bottom: 1px solid black;  font-size: 18px; font-family: 'Times New Roman', Times, serif;">
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option value="<?php echo $existingMadeMonth; ?>" <?php echo ($m === $existingMadeMonth) ? 'selected' : ''; ?>><?php echo $existingMadeMonth; ?></option>
        <?php else: ?>
            <option value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>
                <input type="number" name="made_year" placeholder="year" style="width: 60px; border: none; border-bottom: 1px solid black; font-size: 18px; font-family: 'Times New Roman', Times, serif;" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingMadeYear) ? $existingMadeYear : date('Y'); ?>">
</div><br><br>

                <script>
                    var yearInput = document.getElementById('year');

                    yearInput.addEventListener('keyup', function(event) {
                        if (event.keyCode === 38) {
                            event.preventDefault();
                            var year = parseInt(yearInput.value);
                            yearInput.value = year + 1;
                        }
                    });

                    yearInput.addEventListener('keyup', function(event) {
                        if (event.keyCode === 40) {
                            event.preventDefault();
                            var year = parseInt(yearInput.value);
                            yearInput.value = year - 1;
                        }
                    });
                </script>

<h3 style="text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif;"> <b style= "font-size: 18px;">
PAABISO NG PAGHIHIRANG</b>
                <div style="text-align: left;">
<br><br><br>                
<input type="text" id="lupon1" placeholder="" name="lupon1" list="nameList" value="<?php echo $existingLupon ?? ''; ?>" required style="width:250px; height: 20px; border: none;  font-size: 18px; font-family: 'Times New Roman', Times, serif; border-bottom: 1px solid black; outline: none; size= 1;"></p>
<textarea id="lupon2" placeholder="" name="lupon2" required style="width:250px; height: 60px; border: none;  font-size: 18px; font-family: 'Times New Roman', Times, serif; border-bottom: 1px solid black; outline: none; resize: vertical;"><?php echo $existingLupon2 ?? ''; ?></textarea></p>   

    <datalist id="nameList">
        <?php foreach ($linkedNames as $name): ?>
            <option value="<?php echo $name; ?>">
        <?php endforeach; ?>
    </datalist>


                <br><p style="text-align: justify; font-size: 18px; font-family: 'Times New Roman', Times, serif;">Ginoo/Gng:</p>
                <p style=" text-align: justify; font-size: 18px; text-indent: 2em; font-family: 'Times New Roman', Times, serif;"> Ipinababatid sa iyo na ikaw ay hinihirang ng Punong Barangay bilang kasapi ng Lupong Tagapamayapa, na magkakabisa sa sandaling makapanumpa sa tungkulin, at hanggang ang bagong Lupon ay mabuo sa ikatlong taon kasunod ng iyong pakakahirang. Maari kang manumpa sa iyong tungkulin sa harap ng Punong Barangay sa 
                <input type="text" id="lupon3" name="lupon3" value="<?php echo $existingLupon3 ?? ''; ?>" required style="text-align: justify; font-size: 18px; font-family: 'Times New Roman', Times, serif; width: 30%; border: none; border-bottom: 1px solid black; margin-right: 0;">.
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

            <div style="position: relative;"><br>

        <p style="text-align: center; margin-left: 400px; margin-right: auto;  font-size: 18px; font-family: 'Times New Roman', Times, serif;">Tapat na Sumasainyo, </p>
    <body>
    <p class="important-warning-text" style="text-align: center; font-size: 18px; margin-left: 400px; margin-right: auto;">
    <input type="text" id="brgysec" name="brgysec" style="border: none; text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif; border-bottom: 1px solid black; outline: none;" size="25" value="<?php echo $existingbrgysec ?? ''; ?>" required>
    <p style="margin-left: 400px; margin-top: 20px;  font-size: 18px; font-family: 'Times New Roman', Times, serif;">Kalihim ng Barangay
    </p>
    </div>
    </div>
   
    <?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
   
    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button" style="position: fixed; right: 20px; top: 130px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                </form>
                    
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
            filename: 'kp_form3_' + barangayCaseNumber + '.pdf', // Dynamic filename
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