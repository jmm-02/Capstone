<?php
session_start();

include '../connection.php'; // Ensure this file is using a PDO connection

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID from the session

try {
    // Step 1: Retrieve the municipality_id from the logged-in user's record
    $query = "SELECT municipality_id FROM users WHERE id = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    
    $user_row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user_row && isset($user_row['municipality_id'])) {
        $municipality_id = $user_row['municipality_id'];
        
        // Step 2: Use the municipality_id to fetch the corresponding municipality_name
        $query = "SELECT municipality_name FROM municipalities WHERE id = :municipality_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':municipality_id', $municipality_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $municipality_row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Step 3: Set the municipality name for use in the form
        if ($municipality_row && isset($municipality_row['municipality_name'])) {
            $municipality_name = $municipality_row['municipality_name'];
        } else {
            $municipality_name = 'No municipality found for this user';
        }
        // Step 4: Fetch barangays associated with this municipality
        $query = "SELECT id, barangay_name FROM barangays WHERE municipality_id = :municipality_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':municipality_id', $municipality_id, PDO::PARAM_INT);
        $stmt->execute();
        $barangays = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $municipality_name = 'No municipality ID found for this user';
        $barangays = []; // Empty array if no barangays found
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

try {
  // Fetch the `barangay_id` based on the selected barangay name
  $query = "SELECT id FROM barangays WHERE barangay_name = :barangay_name";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':barangay_name', $selected_barangay_name, PDO::PARAM_STR);
  $stmt->execute();
  $barangay_row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($barangay_row && isset($barangay_row['id'])) {
      $barangay_id = $barangay_row['id'];

      // Fetch the `mov_id` from the `mov` table based on the `barangay_id`
      $query = "SELECT id FROM mov WHERE barangay_id = :barangay_id LIMIT 1";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':barangay_id', $barangay_id, PDO::PARAM_INT);
      $stmt->execute();
      $mov_row = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($mov_row && isset($mov_row['id'])) {
          $mov_id = $mov_row['id']; // Retrieved `mov_id`
      } else {
          $mov_id = null; // No `mov_id` found
      }
  } else {
      $mov_id = null; // No `barangay_id` found
  }
} catch (PDOException $e) {
  echo "Error fetching mov_id: " . $e->getMessage();
}

?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Secretaries Corner</title>
<style>
/* CSS to ensure alerts fit well within the table cells */
.alert {
    display: flex;           /* Use flex to center content */
    align-items: center;    /* Vertically center the content */
    justify-content: center; /* Horizontally center the content */
    padding: 0.5rem 1rem;   /* Adjust padding for better spacing */
    margin: 0;              /* Remove margin to prevent overflow */
    border-radius: 0.25rem; /* Optional: make the corners rounded */
    font-size: 0.875rem;    /* Optional: adjust font size for better readability */
}

.file-column {
    overflow: hidden;       /* Prevent overflow of alert */
    text-overflow: ellipsis; /* Add ellipsis if text is too long */
    white-space: nowrap;    /* Prevent wrapping */
}

</style>
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

 <script>
$(document).ready(function () {
    // Handle barangay selection
    $('#barangay_select').on('change', function () {
        var selectedBarangayName = $(this).val();
        $('#selected_barangay').val(selectedBarangayName);

        if (selectedBarangayName) {
            $.ajax({
                url: 'fetch_files.php',
                method: 'POST',
                data: { barangay_name: selectedBarangayName },
                dataType: 'json',
                success: function (data) {
                console.log('Returned data:', data);

                // Check if there is an error in the response
                if (data.error) {
                    alert(data.error); // Display the error message
                    return;
                }

                // Extract barangay_id and mov_id from the response
                var barangayId = data.barangay_id;
                var movId = data.mov_id;

                // Log the IDs for debugging
                console.log('Barangay ID:', barangayId);
                console.log('MOV ID:', movId);

                // Populate the input fields
                $('#barangay_id').val(barangayId); // Set barangay_id input
                $('#mov_id').val(movId); // Set mov_id input

                // Handle each PDF file from the returned data
                var fileTypes = [
                'IA_1a', 'IA_1b', 'IA_2a', 'IA_2b', 'IA_2c', 'IA_2d', 'IA_2e', 'IB_1forcities', 'IB_1aformuni', 'IB_1bformuni', 'IB_2', 'IB_3', 'IB_4', 'IC_1', 'IC_2', 'ID_1', 'ID_2', 'IIA', 'IIB_1', 'IIB_2', 'IIC', 'IIIA', 'IIIB', 'IIIC_1forcities', 'IIIC_1forcities2', 'IIIC_1forcities3', 'IIIC_2formuni1', 'IIIC_2formuni2', 'IIIC_2formuni3', 'IIID', 'IV_forcities', 'IV_muni', 'V_1', 'threepeoplesorg'
                ];

                // Clear previous file columns
                $('.file-column').html('');

                fileTypes.forEach(function (type) {
                    var fileColumn = $('.file-column[data-type="' + type + '"]');

                    // Check for the specific PDF file types
                    var fileKey = type + '_pdf_File';
                    if (data[fileKey]) {
                        var filePath = 'movfolder/' + data[fileKey];
                        $('.view-pdf[data-type="' + type + '"]').attr('data-file', filePath).show();
                        fileColumn.html('<button type="button" class="btn btn-primary view-pdf" data-type="' + type + '" data-file="' + filePath + '">View</button>'); // Add view button to the file column
                    } else {
                        fileColumn.html('<div class="alert alert-warning mb-0">No uploaded file</div>');
                    }
                });

                // Handle rates
                if (data.rates) {
                    console.log('Rates:', data.rates);
                    // Set rates in input fields, adjust names to match your input field names
                    $('input[name="IA_1a_pdf_rate"]').val(data.rates.IA_1a_pdf_rate);
                    $('input[name="IA_1b_pdf_rate"]').val(data.rates.IA_1b_pdf_rate);
                    $('input[name="IA_2a_pdf_rate"]').val(data.rates.IA_2a_pdf_rate);
                    $('input[name="IA_2b_pdf_rate"]').val(data.rates.IA_2b_pdf_rate);
                    $('input[name="IA_2c_pdf_rate"]').val(data.rates.IA_2c_pdf_rate);
                    $('input[name="IA_2d_pdf_rate"]').val(data.rates.IA_2d_pdf_rate);
                    $('input[name="IA_2e_pdf_rate"]').val(data.rates.IA_2e_pdf_rate);
                    $('input[name="IB_1forcities_pdf_rate"]').val(data.rates.IB_1forcities_pdf_rate);
                    $('input[name="IB_1aformuni_pdf_rate"]').val(data.rates.IB_1aformuni_pdf_rate);
                    $('input[name="IB_1bformuni_pdf_rate"]').val(data.rates.IB_1bformuni_pdf_rate);
                    $('input[name="IB_2_pdf_rate"]').val(data.rates.IB_2_pdf_rate);
                    $('input[name="IB_3_pdf_rate"]').val(data.rates.IB_3_pdf_rate);
                    $('input[name="IB_4_pdf_rate"]').val(data.rates.IB_4_pdf_rate);
                    $('input[name="IC_1_pdf_rate"]').val(data.rates.IC_1_pdf_rate);
                    $('input[name="IC_2_pdf_rate"]').val(data.rates.IC_2_pdf_rate);
                    $('input[name="ID_1_pdf_rate"]').val(data.rates.ID_1_pdf_rate);
                    $('input[name="ID_2_pdf_rate"]').val(data.rates.ID_2_pdf_rate);
                    $('input[name="IIA_pdf_rate"]').val(data.rates.IIA_pdf_rate);
                    $('input[name="IIB_1_pdf_rate"]').val(data.rates.IIB_1_pdf_rate);
                    $('input[name="IIB_2_pdf_rate"]').val(data.rates.IIB_2_pdf_rate);
                    $('input[name="IIC_pdf_rate"]').val(data.rates.IIC_pdf_rate);
                    $('input[name="IIIA_pdf_rate"]').val(data.rates.IIIA_pdf_rate);
                    $('input[name="IIIB_pdf_rate"]').val(data.rates.IIIB_pdf_rate);
                    $('input[name="IIIC_1forcities_pdf_rate"]').val(data.rates.IIIC_1forcities_pdf_rate);
                    $('input[name="IIIC_1forcities2_pdf_rate"]').val(data.rates.IIIC_1forcities2_pdf_rate);
                    $('input[name="IIIC_1forcities3_pdf_rate"]').val(data.rates.IIIC_1forcities3_pdf_rate);
                    $('input[name="IIIC_2formuni1_pdf_rate"]').val(data.rates.IIIC_2formuni1_pdf_rate);
                    $('input[name="IIIC_2formuni2_pdf_rate"]').val(data.rates.IIIC_2formuni2_pdf_rate);
                    $('input[name="IIIC_2formuni3_pdf_rate"]').val(data.rates.IIIC_2formuni3_pdf_rate);
                    $('input[name="IIID_pdf_rate"]').val(data.rates.IIID_pdf_rate);
                    $('input[name="IV_forcities_pdf_rate"]').val(data.rates.IV_forcities_pdf_rate);
                    $('input[name="IV_muni_pdf_rate"]').val(data.rates.IV_muni_pdf_rate);
                    $('input[name="V_1_pdf_rate"]').val(data.rates.V_1_pdf_rate);
                    $('input[name="threepeoplesorg_pdf_rate"]').val(data.rates.threepeoplesorg_pdf_rate);

                    // Add similar lines for other rates as necessary
                }

                // Handle remarks
                if (data.remarks) {
                    console.log('Remarks:', data.remarks);
                    // Set remarks in input fields, adjust names to match your input field names
                    $('textarea[name="IA_1a_pdf_remark"]').val(data.remarks.IA_1a_pdf_remark);
                    $('textarea[name="IA_1b_pdf_remark"]').val(data.remarks.IA_1b_pdf_remark);
                    $('textarea[name="IA_2a_pdf_remark"]').val(data.remarks.IA_2a_pdf_remark);
                    $('textarea[name="IA_2b_pdf_remark"]').val(data.remarks.IA_2b_pdf_remark);
                    $('textarea[name="IA_2c_pdf_remark"]').val(data.remarks.IA_2c_pdf_remark);
                    $('textarea[name="IA_2d_pdf_remark"]').val(data.remarks.IA_2d_pdf_remark);
                    $('textarea[name="IA_2e_pdf_remark"]').val(data.remarks.IA_2e_pdf_remark);
                    $('textarea[name="IB_1forcities_pdf_remark"]').val(data.remarks.IB_1forcities_pdf_remark);
                    $('textarea[name="IB_1aformuni_pdf_remark"]').val(data.remarks.IB_1aformuni_pdf_remark);
                    $('textarea[name="IB_1bformuni_pdf_remark"]').val(data.remarks.IB_1bformuni_pdf_remark);
                    $('textarea[name="IB_2_pdf_remark"]').val(data.remarks.IB_2_pdf_remark);
                    $('textarea[name="IB_3_pdf_remark"]').val(data.remarks.IB_3_pdf_remark);
                    $('textarea[name="IB_4_pdf_remark"]').val(data.remarks.IB_4_pdf_remark);
                    $('textarea[name="IC_1_pdf_remark"]').val(data.remarks.IC_1_pdf_remark);
                    $('textarea[name="IC_2_pdf_remark"]').val(data.remarks.IC_2_pdf_remark);
                    $('textarea[name="ID_1_pdf_remark"]').val(data.remarks.ID_1_pdf_remark);
                    $('textarea[name="ID_2_pdf_remark"]').val(data.remarks.ID_2_pdf_remark);
                    $('textarea[name="IIA_pdf_remark"]').val(data.remarks.IIA_pdf_remark);
                    $('textarea[name="IIB_1_pdf_remark"]').val(data.remarks.IIB_1_pdf_remark);
                    $('textarea[name="IIB_2_pdf_remark"]').val(data.remarks.IIB_2_pdf_remark);
                    $('textarea[name="IIC_pdf_remark"]').val(data.remarks.IIC_pdf_remark);
                    $('textarea[name="IIIA_pdf_remark"]').val(data.remarks.IIIA_pdf_remark);
                    $('textarea[name="IIIB_pdf_remark"]').val(data.remarks.IIIB_pdf_remark);
                    $('textarea[name="IIIC_1forcities_pdf_remark"]').val(data.remarks.IIIC_1forcities_pdf_remark);
                    $('textarea[name="IIIC_1forcities2_pdf_remark"]').val(data.remarks.IIIC_1forcities2_pdf_remark);
                    $('textarea[name="IIIC_1forcities3_pdf_remark"]').val(data.remarks.IIIC_1forcities3_pdf_remark);
                    $('textarea[name="IIIC_2formuni1_pdf_remark"]').val(data.remarks.IIIC_2formuni1_pdf_remark);
                    $('textarea[name="IIIC_2formuni2_pdf_remark"]').val(data.remarks.IIIC_2formuni2_pdf_remark);
                    $('textarea[name="IIIC_2formuni3_pdf_remark"]').val(data.remarks.IIIC_2formuni3_pdf_remark);
                    $('textarea[name="IIID_pdf_remark"]').val(data.remarks.IIID_pdf_remark);
                    $('textarea[name="IV_forcities_pdf_remark"]').val(data.remarks.IV_forcities_pdf_remark);
                    $('textarea[name="IV_muni_pdf_remark"]').val(data.remarks.IV_muni_pdf_remark);
                    $('textarea[name="V_1_pdf_remark"]').val(data.remarks.V_1_pdf_remark);
                    $('textarea[name="threepeoplesorg_pdf_remark"]').val(data.remarks.threepeoplesorg_pdf_remark);

                    // Add similar lines for other remarks as necessary
                }
            },

                error: function (xhr, status, error) {
                    console.log('Error fetching files:', xhr.responseText);
                }
            });
        } else {
            // If no barangay is selected, clear all file columns and input fields
            $('.file-column').html('<div class="alert alert-info mb-0">Select barangay</div>');
            $('#barangay_id').val(''); // Clear barangay_id input
            $('#mov_id').val(''); // Clear mov_id input
            $('textarea[name="IA_1a_pdf_remark"]').val('');
            $('textarea[name="IA_1b_pdf_remark"]').val('');
            $('input[name="IA_1a_pdf_rate"]').val('');
            $('input[name="IA_1b_pdf_rate"]').val('');
        }
    });

    // Handle PDF viewing inside the modal
    $(document).on('click', '.view-pdf', function () {
        var file = $(this).data('file'); // Get the file URL
        console.log('PDF URL:', file); // Debug the file path

        if (file) {
            // Set the source of the iframe in the modal to the PDF URL
            $('#pdfViewer').attr('src', file);

            // Show the modal by removing the hidden class
            $('#large-modal').removeClass('hidden');
        } else {
            alert('No file available to view.');
        }
    });

    // Close the modal when the close button is clicked
    $('[data-modal-hide="large-modal"]').on('click', function () {
        $('#large-modal').addClass('hidden'); // Hide the modal
        $('#pdfViewer').attr('src', ''); // Clear the iframe src when modal is closed
    });
});

</script>


</head>

<body class="bg-[#E8E8E7]">
  <?php include "../admin_sidebar_header.php"; ?>

  <div class="p-4 sm:ml-44 ">
    <div class="rounded-lg mt-16">
    <div class="card">
    <div class="card-body">
    <div class="flex justify-between items-center mb-4">
    <div class="flex items-center">
        <div class="dilglogo">
            <img src="../img/cluster.png" alt="Logo" style="max-width: 120px; max-height: 120px; margin-right: 10px;" class="align-middle">
        </div>
        <div class="ml-4">
            <h1 class="text-xl font-bold">
                Lupong Tagapamayapa Incentives Award (LTIA)
            </h1>
            <hr class="my-2">
            <h2 class="text-lg font-semibold">
                Municipality of <?php echo htmlspecialchars($municipality_name); ?>
            </h2>
        </div>
    </div>

            <div class="menu">
              <ul class="flex space-x-4">
              <li>
                  <button class="bg-gray-800 hover:bg-gray-700 px-3 py-2 rounded-md text-white flex items-center" onclick="location.href='#';" style="margin-left: 0;">
                  <i class="ti ti-file-analytics mr-2">  </i>
                      Summary
                  </button>
                </li>
                <li>
                  <button class="bg-gray-800 hover:bg-gray-700 px-3 py-2 rounded-md text-white flex items-center" onclick="location.href='admin_dashboard.php';" style="margin-left: 0;">
                  <i class="ti ti-building-community mr-2"> </i> 
                      Back
                  </button>
                </li>
              </ul>
            </div>
          </div>
          <h2 class="text-left text-2xl font-semibold">FORM 1</h2>
          <div class="form-group mt-4">
                    <label for="barangay_select" class="block text-lg font-medium text-gray-700">Select Barangay</label>
                        <select id="barangay_select" name="barangay" class="form-control">
                            <option value="">Select Barangay</option>
                            <?php foreach ($barangays as $barangay): ?>
                                <option value="<?php echo htmlspecialchars($barangay['barangay_name']); ?>">
                                    <?php echo htmlspecialchars($barangay['barangay_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
    <form method="post" action="adminevaluate_handler.php" enctype="multipart/form-data">
    <input type="hidden" id="selected_barangay" name="selected_barangay" value="" />
    <!-- Example form input for mov_id -->
    <input type="text" id="mov_id" name="mov_id"> <!-- Display fetched mov_id -->
    <input type="text" id="barangay_id" name="barangay_id"> <!-- I want the barangay_id fetch here -->
    <!-- mov_id is fetched here -->



    <table class="table table-bordered">
            <thead>
              <tr>
                <th>CRITERIA</th>
                <th>Assigned Points</th>
                <th>File</th>
                <th>Rate</th>
                <th>Remarks</th>
              </tr>
            </thead>
            <tbody>
              <tr>
            <td><b>I. EFFICIENCY IN OPERATION</b>

            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
        <td><b>A. Observance of Settlement Procedure and Settlement Deadlines</b>
        </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>
            <details>
                <summary><b>1. a) Proper Recording of Every Dispute/Complaint - Evaluation Criteria</b></summary>
                <p><br>
                    <b>Scoring Details:</b> <br><br>
                    <b>5 points</b> - Submitted/presented the record book or logbook reflecting all the required details.<br>
                    <b>2.5 points</b> - Submitted/presented the record book or logbook reflecting some of the necessary details.<br>
                    <b>0 points</b> - No presented record book or logbook.<br><br>

                    <b>Note:</b> Check if the record contains the following:
                    <ul>
                    <li>Docket number</li>
                    <li>Names of the parties</li>
                    <li>Date and time filed</li>
                    <li>Nature of the case</li>
                    <li>Disposition</li>
                    </ul>
                </p>
                </details>
        </td>
            <td>5</td>
            <td class="file-column" data-type="IA_1a">
              <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
               </td>
            <td>  
            <hr class="my-1">
              <input type="number" value="" name="IA_1a_pdf_rate" placeholder="Ratings">
            <div class="error-message" style="color: red; display: none;">Please enter a number between 0 and 5.</div>
          </td>
            <td><textarea name="IA_1a_pdf_remark" placeholder="Remarks"></textarea></td>
          </tr>
          <tr>
            <td><details>
        <summary><b>b) Sending of Notices/Summons to Parties within the Prescribed Period (within the next working day upon receipt of complaint)</b></summary>
        <p><br>
          <b>Scoring Details:</b> <br><br>
          <b>5 points</b> - Submitted/presented 80-100% of summons with complete and accurate information issued within the prescribed period.<br>
          <b>3 points</b> - Submitted/presented 50-79% of summons with complete and accurate information issued within the prescribed period.<br>
          <b>2 points</b> - Submitted/presented 1-49% of summons with complete and accurate information issued within the prescribed period.<br>
          <b>0 points</b> - Have not submitted/presented any summons/notices.<br><br>

          <b>Note:</b> Scores will be given only when file copies of the summons issued within the next working day are stamped with the date and time of receipt.
        </p>
      </details>

        </td>
            <td>5</td>
            <td class="file-column" data-type="IA_1b">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td>
            <input type="number" value="" name="IA_1b_pdf_rate" placeholder="Ratings">
          <div class="error-message" style="color: red; display: none;">Please enter a number between 0 and 5.</div>
            </td>
            <td><textarea name="IA_1b_pdf_remark" placeholder="Remarks"></textarea></td>
                    </tr>
          <tr>
  <td>
  <details>
  <summary><b>2. Settlement and Award Period (with at least 10 settled cases within the assessment period)</b></summary>
  <p><br>
    <b>10 points</b> – 80-100% of cases were resolved using any mode of ADR (supported by minutes of proceedings) within the prescribed period.<br><br>
    <b>8 points</b> – 60-79% of cases were resolved using any mode of ADR (supported by minutes of proceedings) within the prescribed period.<br><br>
    <b>6 points</b> – 40-59% of cases were resolved using any mode of ADR (supported by minutes of proceedings) within the prescribed period.<br><br>
    <b>4 points</b> – 20-39% of cases were resolved using any mode of ADR (supported by minutes of proceedings) within the prescribed period.<br><br>
    <b>2 points</b> – 1-19% of cases were resolved using any mode of ADR (supported by minutes of proceedings) within the prescribed period.<br><br>
    <b>0 points</b> – 0 cases were resolved using any mode of ADR (supported by minutes of proceedings) within the prescribed period.
  </p>

</details>

  </td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
</tr>
               <tr>
                <td>a) Mediation (within 15 days from initial confrontation with the Lupon Chairman)</td>
                <td>2</td>
                <td class="file-column" data-type="IA_2a">
              <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
          </td>
            <td><input type="number" value="" name="IA_2a_pdf_rate" min="0" max="2" class="score-input" placeholder="Ratings"></td>
            <td><textarea name="IA_2a_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <td>b) Conciliation (15 days from initial confrontation with the Pangkat)</td>
                <td>2</td>
                <td class="file-column" data-type="IA_2b">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
            </td>
            <td><input type="number" value="" name="IA_2b_pdf_rate" min="0" max="2" class="score-input" placeholder="Ratings"></td>
            <td><textarea name="IA_2b_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <td>c) Conciliation (15 days from initial confrontation with the Pangkat)</td>
                <td>2</td>
                <td class="file-column" data-type="IA_2c">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IA_2c_pdf_rate" min="0" max="2" class="score-input" placeholder="Ratings"></td>
            <td><textarea name="IA_2c_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <td>d) Arbitration (within 10 days from the date of the agreement to arbitrate)</td>
                <td>2</td>
                <td class="file-column" data-type="IA_2d">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IA_2d_pdf_rate" min="0" max="2" class="score-input" placeholder="Ratings"></td>
            <td><textarea name="IA_2d_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <td>e) Conciliation beyond 46 days but not more than 60 days on a clearly meritorious case</td>
                <td>2</td>
                <td class="file-column" data-type="IA_2e">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IA_2e_pdf_rate" min="0" max="2" class="score-input" placeholder="Ratings"></td>
            <td><textarea name="IA_2e_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <th>B. Systematic Maintenance of Records</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
              <tr>
                <td><b>1. Record of Cases </b></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>For Cities - computer database with searchable case information</td>
                <td>2</td>
                <td class="file-column" data-type="IB_1forcities">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
                </td>
            <td><input type="number" value="" name="IB_1forcities_pdf_rate" min="0" max="2" class="score-input" placeholder="Ratings"></td>
            <td><textarea name="IB_1forcities_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <td>For Municipalities:</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>a. Manual Records</td>
                <td>1</td>
                <td class="file-column" data-type="IB_1aformuni">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IB_1aformuni_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="IB_1aformuni_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <td>b. Digital Record Filing</td>
                <td>1</td>
                <td class="file-column" data-type="IB_1bformuni">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IB_1bformuni_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="IB_1bformuni_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <td>2. Copies of Minutes of Lupon meetings with attendance sheets and notices</td>
                <td>1</td>
                <td class="file-column" data-type="IB_2">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IB_2_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="IB_2_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <td>3. Copies of reports submitted to the Court and to the DILG on file</td>
                <td>1</td>
                <td class="file-column" data-type="IB_3">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IB_3_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="IB_3_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <td>4. All records are kept on file in a secured filing cabinet(s)</td>
                <td>1</td>
                <td class="file-column" data-type="IB_4">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IB_4_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="IB_4_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <th>C. Timely Submissions to the Court and the DILG</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
              <tr>
                <td>
                <details>
                <summary><b>1. To the Court: Submitted/presented copies of settlement agreement to the Court</b></summary>
                <p><br>
                  <b>Criteria Description:</b> <br>
                  Copies of the settlement agreement must be submitted to the Court within the following periods: 
                  <ul>
                    <li>After the lapse of the ten-day period repudiating the mediation/conciliation settlement agreement</li>
                    <li>Or within five (5) calendar days from the date of the arbitration award</li>
                  </ul>
                  <br>
                  
                  <b>Scoring Details:</b> <br><br>
                  <b>5.0 points</b> - 80%-100% of the settlement agreements were submitted on time.<br>
                  <b>4.0 points</b> - 60%-79% of the settlement agreements were submitted on time.<br>
                  <b>3.0 points</b> - 40%-59% of the settlement agreements were submitted on time.<br>
                  <b>2.0 points</b> - 20%-39% of the settlement agreements were submitted on time.<br>
                  <b>1.0 point</b> - 1%-19% of the settlement agreements were submitted on time.<br>
                  <b>0 points</b> - 0% of the reports were submitted on time.<br><br>

                  <b>Note:</b> Timeliness is critical. Submission is considered on time only if it adheres strictly to the ten-day period after mediation/conciliation or five (5) days post-arbitration award.
                </p>
               </details>
                </td>
                <td>5</td>
                <td class="file-column" data-type="IC_1">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IC_1_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="IC_1_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <td><details>
                <summary><b>2. To the DILG (Monthly): Submission of required report to the DILG</b></summary>
                <p><br>
                  2 points - Submitted/presented the required report to the DILG within the prescribed period<br>
                  1 point - Submitted/presented a partial report to the DILG within the prescribed period<br>
                  0 point - The required report to the DILG was not submitted or was submitted beyond the prescribed period
                </p>
              </details>
              </td>
                <td>2</td>
                <td class="file-column" data-type="IC_2">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
            </td>
            <td><input type="number" value="" name="IC_2_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="IC_2_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <th>D. Conduct of monthly meetings for administration of the Katarungang Pambarangay (KP)</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
              <tr>
                <td>
                <details>
              <summary><b>Notice of Meeting</b></summary>
              <p><br>
                <b>2.0 points</b> - Minimum of 12 meetings with KP-related matters, complete details, each Lupon member must sign (indicating their name, date, and time of receipt) when receiving notices of the meeting.<br>
                <b>1.0 point</b> - Anything beyond the compliance document, with incomplete details.<br>
                <b>0 point</b> - No data presented.
              </p>
            </details>
                    </td>
                <td>2</td>
                <td class="file-column" data-type="ID_1">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="ID_1_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="ID_1_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <td>
                <details>
                <summary><b>Minutes of the Meeting</b></summary>
                <p><br>
                  <b>Number of months with KP-related meetings with minutes and attendance sheets conducted:</b><br><br>
                  <b>8.0 points</b> - 12 months.<br>
                  <b>6.0 points</b> - 9-11 months.<br>
                  <b>4.0 points</b> - 6-8 months.<br>
                  <b>2.0 points</b> - 3-5 months.<br>
                  <b>1.0 point</b> - 1-2 months.<br>
                  <b>0 point</b> - No meeting.
                </p>
              </details>

                </td>
                <td>8</td>
                <td class="file-column" data-type="ID_2">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="ID_2_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="ID_2_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <th>II. EFFECTIVENESS IN SECURING THE SETTLEMENT OF INTERPERSONAL DISPUTE OBJECTIVE OF THE KATARUNGANG PAMBARANGAY</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
              <tr>
                <td>
                <details>
                <summary><b>A. Quantity of settled cases against filed</b></summary>
                <p><br>
                  <b>With a minimum of 10 cases settled, the percentage of cases received by the Lupon resulting in settlement:</b><br><br>
                  <b>10.0 points</b> - 100%.<br>
                  <b>8.0 points</b> - 80%-99%.<br>
                  <b>6.0 points</b> - 60%-79%.<br>
                  <b>4.0 points</b> - 40%-59%.<br>
                  <b>2.0 points</b> - 1%-39%.<br>
                  <b>0 point</b> - 0%.
                </p>
              </details>
                    </td>
                <td>10</td>
                <td class="file-column" data-type="IIA">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IIA_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="IIA_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <td>
                <details>
                <summary><b>B. Quality of Settlement of Cases</b></summary>
                <p><br>
                  <b>1 point</b> - for non-recurrence and zero cases repudiated (out of the total number of settled cases).<br>
                  <b>0 point</b> - at least one (1) case repudiated (out of the total number of settled cases).
                </p>
              </details>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>1. Zero cases repudiated</td>
                <td>1</td>
                <td class="file-column" data-type="IIB_1">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IIB_1_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="IIB_1_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <td>2. Non-recurrence of cases settled</td>
                <td>1</td>
                <td class="file-column" data-type="IIB_2">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IIB_2_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="IIB_2_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <td>
                <details>
              <summary><b>At least 80% compliance with the terms of settlement or award after the cases have been settled </b></summary>
              <p><br>
                <b>8 points</b> - 80%-100% compliance with the terms of settlement or award.<br>
                <b>6 points</b> - 70%-79% compliance with the terms of settlement or award.<br>
                <b>4 points</b> - 60%-69% compliance with the terms of settlement or award.<br>
                <b>2 points</b> - 50%-51% compliance with the terms of settlement or award.<br>
                <b>1 point</b> - 49% and below compliance with the terms of settlement or award.
              </p>
            </details>
                </td>
                <td>8</td>
                <td class="file-column" data-type="IIC">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IIC_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="IIC_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <th>III. CREATIVITY AND RESOURCEFULNESS OF THE LUPONG TAGAPAMAYAPA</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
              <tr>
                <td>
                <details>
              <summary><b>A. Settlement Technique Utilized by the Lupon</b></summary>
              <p><br>
                <b>10 points</b> – Five or more settlement techniques utilized.<br>
                <b>8 points</b> – At least four settlement techniques utilized.<br>
                <b>6 points</b> – At least three settlement techniques utilized.<br>
                <b>4 points</b> – At least two settlement techniques utilized.<br>
                <b>2 points</b> – At least one settlement technique utilized.<br>
                <b>0 points</b> – No report submitted.
              </p>
              <p><b>Note:</b> Settlement techniques to be considered are those that are within the KP process and procedures.</p>
            </details>
                </td>
                <td>10</td>
                <td class="file-column" data-type="IIIA">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IIIA_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="IIIA_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <td>
                <details>
                <summary><b>B. Coordination with Concerned Agencies Relating to Disputes Filed</b></summary>
                <p><br>
                  <b>5 points</b> – With proof of coordination relative to the filed disputes.<br>
                  <b>0 points</b> – Without proof of coordination relative to the filed disputes.
                </p>
              </details>
                </td>
                <td>5</td>
                <td class="file-column" data-type="IIIB">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IIIB_pdf_rate" placeholder="Ratings" ></td>
            <td><textarea name="IIIB_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <td>C. Sustained information drive to promote Katarungang Pambarangay</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>1. For Cities</td>
                <td></td>
              </tr>
              <tr>
                <td>
                  <ul>
                    <li>IEC materials developed</li>
                  </ul>
                </td>
                <td>2</td>
                <td class="file-column" data-type="IIIC_1forcities">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IIIC_1forcities_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="IIIC_1forcities_pdf_remark" placeholder="Remarks"></textarea></td>
            </tr>
              <tr>
                <td>
                  <ul>
                    <li>IEC activities conducted</li>
                  </ul>
                </td>
                <td>1</td>
                <td class="file-column" data-type="IIIC_1forcities2">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IIIC_1forcities2_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="IIIC_1forcities2_pdf_remark" placeholder="Remarks"></textarea></td>
            </tr>
              <tr>
                <td>
                  <ul>
                    <li>Innovative Campaign Strategy</li>
                  </ul>
                </td>
                <td>2</td>
                <td class="file-column" data-type="IIIC_1forcities3">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IIIC_1forcities3_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="IIIC_1forcities3_pdf_remark" placeholder="Remarks"></textarea></td>
            </tr>
              <tr>
                <td>2. For Municipalities</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>
                  <ul>
                    <li>IEC materials developed</li>
                  </ul>
                </td>
                <td>2</td>
                <td class="file-column" data-type="IIIC_2formuni1">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IIIC_2formuni1_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="IIIC_2formuni1_pdf_remark" placeholder="Remarks"></textarea></td>
            </tr>
              <tr>
                <td>
                  <ul>
                    <li>IEC activities conducted</li>
                  </ul>
                </td>
                <td>2</td>
                <td class="file-column" data-type="IIIC_2formuni2">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IIIC_2formuni2_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="IIIC_2formuni2_pdf_remark" placeholder="Remarks"></textarea></td>
            </tr>
              <tr>
                <td>
                  <ul>
                    <li>Innovative Campaign Strategy</li>
                  </ul>
                </td>
                <td>1</td>
                <td class="file-column" data-type="IIIC_2formuni3">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IIIC_2formuni3_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="IIIC_2formuni3_pdf_remark" placeholder="Remarks"></textarea></td>
            </tr>
              <tr>
                <td><details>
              <summary><b>D. KP Training or Seminar Participated Within the Assessment Period</b></summary>
              <p><br>
                Organized skills training participated by the Lupong Tagapamayapa. Trainings or seminars should cover the following, and the Lupon should be able to articulate during validation their learnings therefrom:
                <ul>
                  <li>1) General/basic orientation or review of the KP system</li>
                  <li>2) Skills training on conduct of KP proceedings (e.g., relevant ADR systems, KP case management)</li>
                  <li>3) Advanced knowledge on laws, policies, and standards in relation to the KP system (e.g., gender and human rights, criminal/civil justice)</li>
                </ul>
                <b>10 points</b> = At least 6 qualified trainings/seminars.<br>
                <b>8 points</b> = At least 5 qualified trainings/seminars.<br>
                <b>6 points</b> = At least 4 qualified trainings/seminars.<br>
                <b>4 points</b> = At least 3 qualified trainings/seminars.<br>
                <b>2 points</b> = At least 2 qualified trainings/seminars.<br>
                <b>0 points</b> = No qualified information on training/seminar.
              </p>
            </details>
            </td>
                <td>10</td>
                <td class="file-column" data-type="IIID">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IIID_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="IIID_pdf_rate_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <th>IV. AREA OR FACILITY FOR KP ACTIVITIES</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
              <tr>
                <td><b>Building structure or space:</b></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>For Cities - the office or space should be exclusive for KP matters</td>
                <td></td>
                <td class="file-column" data-type="IV_forcities">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IV_forcities_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="IV_forcities_pdf_remark" placeholder="Remarks"></textarea></td>
            </tr>
              <tr>
                <td>For Municipalities - KP office or space may be shared or used for other Barangay matters.</td>
                <td></td>
                <td class="file-column" data-type="IV_muni">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="IV_muni_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="IV_muni_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <th>V. FINANCIAL OR NON-FINANCIAL SUPPORT</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
              <tr>
                <td>1. From City, Municipal, Provincial or NGAs</td>
                <td>2</td>
                <td class="file-column" data-type="V_1">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="V_1_pdf_rate" placeholder="Ratings"></td>
            <td><textarea name="V_1_pdf_remark" placeholder="Remarks"></textarea></td>
              </tr>
              <tr>
                <td>3 From People's Organizations, NGOs or Private Sector</td>
                <td>1</td>
                <td class="file-column" data-type="threepeoplesorg">
        <span class="alert alert-info">Select barangay</span> <!-- Default message if no barangay selected -->
    </td>
            <td><input type="number" value="" name="threepeoplesorg_rate" placeholder="Ratings"></td>
            <td><textarea name="threepeoplesorg_remark" placeholder="Remarks"></textarea></td>
              </tr>
            </tbody>
          </table>
      <input type="submit" value="Okay" class="btn btn-dark mt-3" />
    </form>
        </div>
      </div>
    </div>
  </div>

<!-- Main modal for PDF viewing -->
<div id="large-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto fixed inset-0 z-50 justify-center items-center w-full h-full">
    <div class="relative p-4 w-full max-w-6xl h-[85%]">
        <!-- Modal content -->
        <div class="relative bg-white shadow rounded-lg h-full dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">PDF Viewer</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="large-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4 h-full">
                <iframe id="pdfViewer" src="" class="w-full h-full rounded-md border"></iframe>
            </div>
        </div>
    </div>
</div>
    </div>
  </div>

</body>
</html>
