<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
  header("Location: login.php");
  exit;
}
#######################################################
$userID = $_SESSION['user_id'];
$barangayID = $_SESSION['barangay_id'];

function caseNumGenerator($conn, $userID)
{
  // Get the last used Case Number
  $query = "SELECT CNum AS lastCaseNumber FROM complaints WHERE UserID = :userID ORDER BY Mdate DESC LIMIT 1";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
  $stmt->execute();

  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $lastCaseNumber = $row ? $row['lastCaseNumber'] : null;

  if (!$lastCaseNumber) {
    $caseNum = '01-000-' . date('my');
    return $caseNum;
  } else {
    // Extract the parts of the last case number
    $parts = explode('-', $lastCaseNumber);

    if (count($parts) === 3) {
      $currentMonthYear = date('my');

      // If current month/year is the same as last case, increment blotter number
      if ($parts[2] === $currentMonthYear) {
        $blotterNumber = intval($parts[0]) + 1;
      } else {
        // Reset blotter number if month/year has changed
        $blotterNumber = 1;
      }

      // Format the case number
      $caseNum = sprintf('%02d', $blotterNumber) . '-' . $parts[1] . '-' . $currentMonthYear;
      return $caseNum;
    } else {
      // Handle unexpected format of $lastCaseNumber
      $caseNum = '01-000-' . date('my');
      return $caseNum;
    }
  }
}

// run always
$caseNum = caseNumGenerator($conn, $userID);

$_SESSION['test'] = $caseNum;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


  $inputData = json_decode(file_get_contents('php://input'), true);

  $forTitle = $inputData['ForTitle'];
  $complainants = $inputData['CNames'];
  $respondents = $inputData['RspndtNames'];
  $complaintDesc = $inputData['CDesc'];
  $petition = $inputData['Petition'];
  $madeDate = $inputData['Mdate'];
  $receivedDate = $inputData['RDate'];
  $caseType = $inputData['CType'];
  $caseNum = $inputData['CNum'];
  $complainantAddress = $inputData['CAddress'];
  $respondentAddress = $inputData['RAddress'];

  // Insert the complaint into the 'complaints' table with default values
  $stmt = $conn->prepare("INSERT INTO complaints (UserID, BarangayID, CNum, ForTitle, CNames, RspndtNames, CDesc, Petition, Mdate, RDate, CType, CStatus, CMethod, CAddress, RAddress) VALUES (:userID, :barangayID, :caseNum, :forTitle, :complainants, :respondents, :complaintDesc, :petition, :madeDate, :receivedDate, :caseType, 'Unsettled', 'Pending', :complainantAddress, :respondentAddress)"); // Updated query to include address fields
  $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
  $stmt->bindParam(':barangayID', $barangayID, PDO::PARAM_INT);
  $stmt->bindParam(':caseNum', $caseNum, PDO::PARAM_STR);
  $stmt->bindParam(':forTitle', $forTitle, PDO::PARAM_STR);
  $stmt->bindParam(':complainants', $complainants, PDO::PARAM_STR);
  $stmt->bindParam(':respondents', $respondents, PDO::PARAM_STR);
  $stmt->bindParam(':complaintDesc', $complaintDesc, PDO::PARAM_STR);
  $stmt->bindParam(':petition', $petition, PDO::PARAM_STR);
  $stmt->bindParam(':madeDate', $madeDate, PDO::PARAM_STR);
  $stmt->bindParam(':receivedDate', $receivedDate, PDO::PARAM_STR);
  $stmt->bindParam(':caseType', $caseType, PDO::PARAM_STR);
  $stmt->bindParam(':complainantAddress', $complainantAddress, PDO::PARAM_STR); // New line to bind complainant address
  $stmt->bindParam(':respondentAddress', $respondentAddress, PDO::PARAM_STR); // New line to bind respondent address

  if ($stmt->execute()) {
    // Get the ID of the last inserted complaint
    $lastInsertedId = $conn->lastInsertId();

    // Insert into case_progress table for the new complaint with default values
    $stmtCaseProgress = $conn->prepare("INSERT INTO case_progress (complaint_id, current_hearing) VALUES (:complaintId, '0')");
    $stmtCaseProgress->bindParam(':complaintId', $lastInsertedId, PDO::PARAM_INT);

    if ($stmtCaseProgress->execute()) {

      $caseNum = caseNumGenerator($conn, $userID);

      echo json_encode(['casenum' => $caseNum, 'status' => 'success', 'message' => 'Complaint Submitted Successfully!']);
      exit;
    } else {
      $caseNum = caseNumGenerator($conn, $userID);
      echo json_encode(['casenum' => $caseNum, 'status' => 'failed', 'message' => 'Failed to Insert to case_progress table. Contact Devs.']);
      exit;
    }
  } else {
    $caseNum = caseNumGenerator($conn, $userID);
    echo json_encode(['casenum' => $caseNum, 'status' => 'failed', 'message' => 'Failed to Submit Complaint. Contact Devs.']);
    exit;
  }
}
#######################################################



?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>complaint</title>
  <link rel="icon" type="image/x-icon" href="img/favicon.ico">


  <style>
    .select2-container--default .select2-selection--single {
      background-color: #fff;
      /* Set the background color to match other input types */
      border: 1px solid #ced4da;
      /* Set the border color */
      border-radius: 4px;
      /* Set border radius if needed */
      height: calc(2.25rem + 2px);
      /* Set the height to match other input types */
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
      top: 5px;
      /* Adjust the arrow position if needed */
    }


    .card {
      box-shadow: 0 0 0.3cm rgba(0, 0, 0, 0.2);
      border-radius: 15px;

    }
  </style>

  <script>
    // Send data via POST using fetch API
    async function sendData(ForTitle, CNames, RspndtNames, CDesc, Petition, Mdate, RDate, CType, CNum, CAddress, RAddress) {
      try {
        const response = await fetch("", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            ForTitle: ForTitle,
            CNames: CNames,
            RspndtNames: RspndtNames,
            CDesc: CDesc,
            Petition: Petition,
            Mdate: Mdate,
            RDate: RDate,
            CType: CType,
            CNum: CNum,
            CAddress: CAddress,
            RAddress: RAddress
          })
        });

        const result = await response.json();

        if (result.message && result.message != '') {

          document.getElementById('message').textContent = result.message;
          document.getElementById('message').classList.remove('hidden');
          document.getElementById('message').classList.add('flex');

          if (result.status === 'success') {
            document.getElementById('message').classList.add('bg-green-300');
          }
          if (result.status === 'failed') {
            document.getElementById('message').classList.add('bg-red-300');
          }

          // empty input value
          // document.querySelector('select[name="ForTitle"]').value = '';
          document.querySelector('input[name="CNames"]').value = '';
          document.querySelector('input[name="RspndtNames"]').value = '';
          document.querySelector('input[name="CDesc"]').value = '';
          document.querySelector('input[name="Petition"]').value = '';
          // document.querySelector('input[name="Mdate"]').value = '';
          document.querySelector('input[name="RDate"]').value = '';
          // document.querySelector('select[name="CType"]').value = '';
          document.querySelector('input[name="CNum"]').value = result.casenum;
          document.querySelector('input[name="CAddress"]').value = '';
          document.querySelector('input[name="RAddress"]').value = '';

        }

      } catch (error) {
        console.error("Error:", error);
      }
    }

    // Handle form submission
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('formAddComplaint');
      form.onsubmit = function(event) {
        event.preventDefault();

        const ForTitle = document.querySelector('select[name="ForTitle"]').value;
        const CNames = document.querySelector('input[name="CNames"]').value;
        const RspndtNames = document.querySelector('input[name="RspndtNames"]').value;
        const CDesc = document.querySelector('input[name="CDesc"]').value;
        const Petition = document.querySelector('input[name="Petition"]').value;
        const Mdate = document.querySelector('input[name="Mdate"]').value;
        const RDate = document.querySelector('input[name="RDate"]').value;
        const CType = document.querySelector('select[name="CType"]').value;
        const CNum = document.querySelector('input[name="CNum"]').value;
        const CAddress = document.querySelector('input[name="CAddress"]').value;
        const RAddress = document.querySelector('input[name="RAddress"]').value;

        if (navigator.onLine) {
          sendData(ForTitle, CNames, RspndtNames, CDesc, Petition, Mdate, RDate, CType, CNum, CAddress, RAddress);
        } else {
          localStorage.setItem('complaintData', JSON.stringify({
            ForTitle,
            CNames,
            RspndtNames,
            CDesc,
            Petition,
            Mdate,
            RDate,
            CType,
            CNum,
            CAddress,
            RAddress
          }));
          alert('No internet. Your request will be executed once the internet is restored.');
        }
      };

      function syncWhenOnline() {
        const complaintData = JSON.parse(localStorage.getItem('complaintData'));
        if (complaintData) {
          sendData(complaintData.ForTitle, complaintData.CNames, complaintData.RspndtNames, complaintData.CDesc, complaintData.Petition, complaintData.Mdate, complaintData.RDate, complaintData.CType, complaintData.CNum, complaintData.CAddress, complaintData.RAddress);
          localStorage.removeItem('complaintData');
        }
      }

      if (navigator.onLine) {
        syncWhenOnline();
      }

      window.addEventListener('online', syncWhenOnline);

    });
  </script>

</head>

<body class="bg-[#E8E8E7]">

  <?php include "user_sidebar_header.php"; ?>

  <div class="p-4 sm:ml-44 ">
    <div class="rounded-lg mt-16">


      <!--  Row 1 -->
      <div class="card">
        <div class="card-body">

          <div class="d-flex align-items-center">
            <img src="img/cluster.png" alt="Logo" style="max-width: 120px; max-height: 120px; margin-right: 10px;" class="align-middle">
            <div>
              <h5 class="card-title mb-2 fw-semibold">Department of the Interior and Local Government</h5>
            </div>
          </div>
          <br>

          <h5 class="card-title mb-9 fw-semibold">Add complaintData</h5>
          <b>

            <p id="message" class="hidden p-3 rounded-md text-white"></p>

            <form id="formAddComplaint">
              <b>
                <div class="row justify-content-between text-left">
                  <div class="form-group col-sm-6 flex-column d-flex">
                    <label class="form-control-label px-3">Case No.<span class="text-danger">*</span></label>
                    <!-- Set the Case Number input field value -->
                    <input type="text" class="form-control" id="CNum" name="CNum" placeholder="MMYY - Case No." value="<?php echo $caseNum; ?>" onblur="validate(1)">
                  </div>
                  <div class="form-group col-sm-6 flex-column d-flex">
                    <label class="form-control-label px-3">For:<span class="text-danger">*</span></label>
                    <select class="form-control" id="ForTitle" name="ForTitle" onblur="validate(2)" required>
                      <option value="">Select Title</option>
                      <option value="">Others</option>
                    </select>
                  </div>

                </div>

                <div class="row justify-content-between text-left">
                  <div class="form-group col-sm-6 flex-column d-flex">
                    <label class="form-control-label px-3">Complainants:<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="CNames" name="CNames" placeholder="Enter name of complainants" onblur="validate(3)" required>
                  </div>
                  <div class="form-group col-sm-6 flex-column d-flex">
                    <label class="form-control-label px-3">Respondents:<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="RspndtNames" name="RspndtNames" placeholder="Enter name of respondents" onblur="validate(4)" required>
                  </div>
                </div>
                <div class="row justify-content-between text-left">
                  <div class="form-group col-sm-6 flex-column d-flex">
                    <label class="form-control-label px-3">Address of Complainants:<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="CAddress" name="CAddress" placeholder="Enter address of complainants" onblur="validate(9)" required>
                  </div>
                  <div class="form-group col-sm-6 flex-column d-flex">
                    <label class="form-control-label px-3">Address of Respondents:<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="RAddress" name="RAddress" placeholder="Enter address of respondents" onblur="validate(10)" required>
                  </div>
                </div>

                <div class="row justify-content-between text-left">
                  <div class="form-group col-12 flex-column d-flex">
                    <label class="form-control-label px-3">complaintData:<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="CDesc" name="CDesc" placeholder="" onblur="validate(5)" required>
                  </div>
                </div>
                <div class="row justify-content-between text-left">
                  <div class="form-group col-12 flex-column d-flex">
                    <label class="form-control-label px-3">Petition:<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="Petition" name="Petition" placeholder="" onblur="validate(6)" required>
                  </div>
                </div>
                <div class="row justify-content-between text-left">
                  <div class="form-group col-sm-6 flex-column d-flex">
                    <label class="form-control-label px-3">Made:<span class="text-danger">*</span></label>
                    <input type="datetime-local" class="form-control" id="Mdate" name="Mdate" onblur="validate(7)" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
                  </div>

                  <div class="form-group col-sm-6 flex-column d-flex">
                    <label class="form-control-label px-3">Received:</label>
                    <input type="date" class="form-control" id="RDate" name="RDate" onblur="validate(8)">
                  </div>
                </div>

                <div class="row justify-content-between text-left">
                  <div class="form-group col-sm-6 flex-column d-flex">
                    <label class="form-control-label px-3">Case Type:<span class="text-danger">*</span></label>
                    <select name="CType" class="form-select">
                      <option value="Civil">Civil</option>
                      <option value="Criminal">Criminal</option>
                      <option value="Others">Others</option>
                    </select>
                  </div>
                </div><br>
                <div class="form-group col-2">
                  <input type="submit" name="submitaddcomplaint" value="Submit" class="bg-blue-500 hover:bg-blue-400 px-3 py-2 rounded-md text-white">
                </div>
              </b>
            </form>
          </b>
        </div>
      </div>

    </div>

  </div>
  </div>

  <script>
    $(document).ready(function() {
      var suggestions = [
        "Tumults and other disturbances of public order; Tumltuous disturbances or interruption liable to cause disturbance (Art. 153)",
        "Unlawful use of means of publication and unlawful utterances (Art. 154)",
        "Alarms and Scandals (Art.155)",
        "Using false certificates (Art. 175)",
        "Using fictitious names and concealing true names (Art. 178)",
        "Illegal use of uniform and insignias (Art. 179)",
        "Physical injuries inflicted in a tumultuous affray (Art. 252)",
        "Giving assistance to suicide (Art. 253)",
        "Responsibility of participants in a duel (Art. 260)",
        "Less serious physical injuries [which shall incapacitate the offended party for labor for ten (10) days or more, or shall require medical assistance for the same period] (Art. 265]",
        "Slight physical injuries and maltreatment (Art. 266)",
        "Unlawful arrest (Art. 269)",
        "Inducing a minor to abandon his home (Art. 271)",
        "Abandonment of persons in danger and abandonment of one's own victim (Art. 275)",
        "Abandoning a minor (Art. 276)",
        "Abandonment of minor by a person entrusted with his custody; indifference of parents (Art. 277)",
        "Qualified trespass to dwelling (Art. 280)",
        "Other forms of trespass (Art. 281)",
        "Light threats (Art. 283)",
        "Other light threats (Art. 285)",
        "Grave coercion (Art. 286)",
        "Light coercions and unjust taxation (Art. 287)",
        "Other similar coercions (Compulsory purchase of merchandise and payment of wages by means of tokens) (Art. 288)",
        "Discovering secrets through the seizure of correspondence (Art. 290)",
        "Revealing secrets with abuse of office (if secrets are not revealed) (Art.291)",
        "Theft (Art. 309)",
        "Altering boundaries or landmarks (Art. 313)",
        "Swindling or Estafa (Art. 315)",
        "Other forms of swindling (Art. 316)",
        "Swindling a minor (Art. 317)",
        "Other deceits (Art. 318)",
        "Removal, sale or pledge of mortgaged property (Art. 319)",
        "Special cases of malicious mischief (Art. 328)",
        "Other mischief (Art. 327, in relation to Art. 329)",
        "Simple seduction (Art. 338)",
        "Acts of lasciviousness with the consent of the offended party (Art. 339)",
        "Threatening to publish and offer to prevent such publication for compensation (Art. 356)",
        "Prohibited publication of acts referred to in the course of official proceedings (Art. 357)",
        "Slander (Oral Defamation) (Art. 356)",
        "Slander by Deed (Art. 359)",
        "Incriminating Innocent Person (Art. 363)",
        "Intriguing against honor (Art. 364)",
        "Reckless imprudence and Simple negligence (Art. 365)",
        "Violation of B.P. NO. 22 or the Bouncing Checks Law",
        "Nuisance (Art. 694 of the Civil Code in the relation to Art. 695, for local ordinance with penal sanctions)",
        "Violation of P.D. No. 1612 or the Anti-Fencing Law",
        "Violation of Republic Act No. 11313 or 'The Safe Spaces Act' Gender-based sexual harassment in streets and public spaces.",
        "Others",
        "dasdsad",
        "Sample tagalog1",
        "Sample tagalog2",
        "Sample tagalog3",
      ];

      // Initialize Select2
      $('#ForTitle').select2({
        placeholder: 'Select or start typing...',
        data: suggestions.map(function(item) {
          return {
            id: item,
            text: item
          };
        }),
        tags: true,
        createTag: function(params) {
          var term = $.trim(params.term);
          if (term === '') {
            return null;
          }
          return {
            id: term,
            text: term,
            newTag: true
          };
        },
        tokenSeparators: [','],
        closeOnSelect: false
      });

      // Add a click event listener to the "Other" option
      $('#ForTitle').on('select2:select', function(e) {
        var selectedValue = e.params.data.id;
        if (selectedValue === 'Other') {
          // Clear the selected value
          $(this).val(null).trigger('change');
          // Enable typing for the "Other" case
          $(this).select2('open');
        }
      });

      // Handle keyup event to update the input value with the typed text
      $('#ForTitle').on('keyup', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          var value = $(this).val();
          // Add the typed text as a tag
          if (value.trim() !== '') {
            $(this).append(new Option(value, value, true, true)).trigger('change');
          }
          // Clear the input
          $(this).val(null);
        }
      });
    });
  </script>
</body>

</html>