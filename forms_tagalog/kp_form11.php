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
$formUsed = 11;


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
$existOfficer = '';

$id = $_GET['formID'] ?? '';

if (!empty($id)) {
    // Fetch data based on the provided formID
    $query = "SELECT received_date, officer FROM hearings WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $rowCount = $stmt->rowCount();

    if ($rowCount > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // Extract and format the timestamp values
     
        $receivedDate = new DateTime($row['received_date']);
       
        $existingReceivedDay = $receivedDate->format('j');
        $existingReceivedMonth = $receivedDate->format('F');
        $existingReceivedYear = $receivedDate->format('Y');

        $existOfficer = $row['officer'];

    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs

    $receivedDay = $_POST['received_day'] ?? '';
    $receivedMonth = $_POST['received_month'] ?? '';
    $receivedYear = $_POST['received_year'] ?? '';
    $officer = $_POST['officer'];

    $receivedDate = createDateFromInputs($receivedDay, $receivedMonth, $receivedYear);

    // Check if there's an existing form_used = 14 within the current_hearing of the complaint_id
    $query = "SELECT * FROM hearings WHERE complaint_id = :complaintId AND form_used = :formUsed AND hearing_number = :currentHearing";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':complaintId', $complaintId);
    $stmt->bindParam(':formUsed', $formUsed);
    $stmt->bindParam(':currentHearing', $currentHearing);
    $stmt->execute();
    $existingForm14Count = $stmt->rowCount();



    $query = "INSERT INTO hearings (complaint_id, hearing_number, form_used, received_date, officer)
              VALUES (:complaintId, :currentHearing, :formUsed, :receivedDate, :officer)
              ON DUPLICATE KEY UPDATE
              hearing_number = VALUES(hearing_number),
              form_used = VALUES(form_used),
              received_date = VALUES(received_date),
                        officer = VALUES(officer)";


     $stmt = $conn->prepare($query);
    $stmt->bindParam(':complaintId', $complaintId);
    $stmt->bindParam(':currentHearing', $currentHearing);
    $stmt->bindParam(':formUsed', $formUsed);
    $stmt->bindParam(':receivedDate', $receivedDate);
    $stmt->bindParam(':officer', $officer);
    
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

// Prepare a new query to fetch 'punong_barangay', 'lupon_chairman', and 'name1' to 'name20' based on 'user_id'
$luponQuery = "SELECT name1, name2, name3, name4, name5, name6, name7, name8, name9, name10,
                        name11, name12, name13, name14, name15, name16, name17, name18, name19, name20
                    FROM lupons
                    WHERE user_id = :user_id AND appoint = 0";
$luponStmt = $conn->prepare($luponQuery);
$luponStmt->bindParam(':user_id', $_SESSION['user_id']);
$luponStmt->execute();

// Fetch the lupon data
$luponData = $luponStmt->fetch(PDO::FETCH_ASSOC);

// Check if lupon data is fetched successfully
if ($luponData) {
    $names = [];
    for ($i = 1; $i <= 20; $i++) {
        $name = $luponData["name$i"];
        if (!empty($name)) {
            $names[] = $name;
        }
    }
} else {
    // If no data found, you can handle it accordingly (e.g., provide default values or display an error message)
    $names = [];
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
    <title>KP Form 11 Tagalog</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

    <style>
        
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
    </style>
</head>
<body>
    <br>
    <div class="container">
        <div class="paper" id="paperContent">
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
            <h5> <b style="font-family: 'Times New Roman', Times, serif;"> Pormularyo ng KP Blg. 11 </b></h5>
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
    'Enero', 'Pebrero', 'Marso', 'Abril', 'Mayo', 'Hunyo', 'Hulyo', 'Agosto', 'Setyembre', 'Oktubre', 'Nobyembre', 'Disyembre'
];

$currentYear = date('Y');
?>

<br><br>

<div class="form-group" style="text-align: justify; font-family: 'Times New Roman', Times, serif;" >
    <div class="input-field" style="float: right; width: 50%;">
        <!-- case num here -->
        <p style="text-align: left; margin-left:30px; font-size: 18px;">Usaping Brgy Blg. <span style="min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
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

       

   

                <h3 style="text-align: center;"><b style="font-size: 18px;font-family: 'Times New Roman', Times, serif;">PAABISO  SA NAPILING KASAPI NG PANGKAT</b></h3>

     
<div class="e" style="font-size: 18px; text-align: right; margin-right:40px; font-family: 'Times New Roman', Times, serif;">
              <?php
// Get the current date
$currentDate = date('F d, Y');

$buwanArray = [
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
];

// Replace the month in English with its Tagalog equivalent
$tagalogDate = strtr($currentDate, $buwanArray);

// Print the formatted date
echo $tagalogDate;
?>

            </div>

            <div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px; font-family: 'Times New Roman', Times, serif;">
                <div class="label"></div>
                <div class="input-field">
                    <p style="font-size:18px;"> KAY: <input style="font-size:18px; border:none; border-bottom:1px solid black;" type="text" name="to" id="to" size="30"> </p>
            </div>
            </div>


                <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px; font-size:18px; font-family: 'Times New Roman', Times, serif;"> 
                <p style="font-size:18px; font-family: 'Times New Roman', Times, serif;"> Sa pamamagitan ng paabisong ito, ikaw ay pinasasabihan  na napili kang kasapi ng Pangkat ng Tagapagkasundo upang   matiwasay na pagkasunduin  ang alitan sa pagitan ng panig na usaping nasasaad sa itaas. </p>
                </div>
                <br><br>

                <p class="important-warning-text" style="text-align: center; font-size: 18px; margin-left: 440px; margin-right: auto;">
    <span style="min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;font-family: 'Times New Roman', Times, serif;">
        <?php echo !empty($punong_barangay) ? $punong_barangay : '&nbsp;'; ?>
    </span></p>
    <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: center; margin-left: 520px; font-family: 'Times New Roman', Times, serif;  font-size: 18px; font-weight: normal; white-space: nowrap; max-width: 200px;">Punong Barangay/ <br>Tagapangulo ng Lupon</label>
               


            <form method="POST" style="font-family: 'Times New Roman', Times, serif;">
                <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px; font-size:18px;"> Tinanggap ngayong ika-<input style="height:33px; text-align:center; font-size: 18px; font-family: 'Times New Roman', Times, serif; width: 44px; margin-right: 5px; padding-bottom: 0; border: none; border-bottom: 1px solid black;"type="text" name="received_day" placeholder="day" size="5" value="<?php echo $existingReceivedDay ?? ''; ?>" required>  araw ng
                <select name="month" style="font-size: 18px; text-align: center; border: none; border-bottom: 1px solid black; padding: 0; margin: 0; height: 30px; line-height: normal; box-sizing: border-box;" required>
    <?php foreach ($tagalogMonths as $englishMonth => $tagalogMonth): ?>
        <option value="<?php echo $englishMonth; ?>" <?php echo (strcasecmp($englishMonth, date('F')) === 0) ? 'selected' : ''; ?>><?php echo $tagalogMonth; ?></option>
    <?php endforeach; ?>
                                    </select>,
        <input style="font-family: 'Times New Roman', Times, serif; font-size: 18px; border: none;  border-bottom: 1px solid black;" type="number" name="received_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingReceivedYear) ? $existingReceivedYear : date('Y'); ?>" required>
    
                </div>
                <br>
                <br>
                <br>
                <div>

                <p class="important-warning-text" style="font-family: 'Times New Roman', Times, serif;  text-align: center; font-size: 18px; margin-left: 470px; margin-right: auto;">
<input style="text-align:center;border:none; border-bottom: 1px solid black; font-size: 18px;" type="text" name="officer" size="25" value="<?php echo $existOfficer; ?>" required list="officerList"> Kasapi ng Pangkat</p>
<datalist id="officerList">
    <?php foreach ($names as $name): ?>
        <option value="<?php echo $name; ?>">
    <?php endforeach; ?>
</datalist>
                    </p>
    </div>

    <?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button col-md-2" style="position:fixed; right: 20px; top: 130px;">


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

    var pdfContent = document.querySelector('.paper');

    // Use html2pdf to generate a PDF
    html2pdf(pdfContent, {
        margin: 10, // Set the margin to 10mm on all sides
        filename: document.title.replace(/\s/g, '_') + '.pdf', // Use the page title as the filename
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' } // Set A4 as the format and portrait as the orientation
    }).then(function (pdf) {
        // Use FileSaver.js or other libraries to save the PDF
        saveAs(pdf, document.title.replace(/\s/g, '_') + '.pdf');
        
        // Show the download button after PDF generation
        downloadButton.style.display = 'inline-block';

        // Show the Save button after PDF generation
        saveButton.style.display = 'inline-block';

        // Show the other buttons after PDF generation
        buttonsToHide.forEach(function (button) {
            button.style.display = 'inline-block';
        });
    });
});
</script>



                <?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                
            </div>
        </div>

</body>
<br>
<div class="blank-page">        
       
          
</div>
</html>
