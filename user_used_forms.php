<?php
session_start();
include 'connection.php';




if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
  header("Location: login.php");
  exit;
}

$userID = $_SESSION['user_id'];

include 'lupon_handler.php';
if (!isset($_SESSION['language'])) {
  $_SESSION['language'] = 'english'; // Set default language to English
}

$folderName =  ($_SESSION['language'] === 'english') ? 'forms_english' : 'forms_tagalog';

?>


<!doctype html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lupon</title>
  <link rel="icon" type="image/x-icon" href="img/favicon.ico">
  

</head>

<body class="bg-[#E8E8E7]">

<?php include "user_sidebar_header.php"; ?>

  <div class="p-4 sm:ml-44 ">
  <div class="rounded-lg mt-16">


      <div class="card overflow-hidden">
        <div class="card-body p-4">
          <div class="d-flex align-items-center">
            <img src="img/cluster.png" alt="Logo" style="max-width: 120px; max-height: 120px; margin-right: 10px;" class="align-middle">
            <div>
              <h5 class="card-title mb-2 fw-semibold">Department of the Interior and Local Government</h5>
            </div>
          </div>
          <br>
          <h5 class="card-title mb-9 fw-semibold"><?php echo ucfirst($_SESSION['language']); ?> Forms</h5>


          <!-- Language Selection Buttons -->
          <button type="button" onclick="setLanguage('english')" class="btn <?php echo ($_SESSION['language'] === 'english') ? 'bg-gray-800 hover:bg-gray-700 px-3 py-2 rounded-md text-white' : 'bg-gray-300 hover:bg-gray-200 px-3 py-2 rounded-md text-black'; ?> m-1">English</button>

          

          <button type="button" onclick="setLanguage('tagalog')" class="btn <?php echo ($_SESSION['language'] === 'tagalog') ? 'bg-gray-800 hover:bg-gray-700 px-3 py-2 rounded-md text-white' : 'bg-gray-300 hover:bg-gray-200 px-3 py-2 rounded-md text-black'; ?> m-1">Tagalog</button>



          <script>
            // Function to set language via AJAX
            function setLanguage(language) {
              // Send AJAX request to update language session variable
              $.ajax({
                url: 'update_language.php',
                method: 'POST',
                data: {
                  language: language
                },
                success: function(response) {
                  // Reload the page to reflect language changes
                  location.reload();
                },
                error: function(xhr, status, error) {
                  // Handle error
                  console.error(error);
                }
              });
            }
          </script>
          <br>


          <div class="form-buttons">


          </div>

        </div>
        <a href="user_lupon.php" class="btn btn-dark">Back to Lupon</a>
      </div>

      <h6>Forms Used</h6>

      <!-- Single input for selecting the year -->
      <input type="number" class="form-control mb-2" id="yearInput" min="2000" placeholder="Search Year">

      <!-- Display KP Columns -->
      <div class="row">
        <?php
        // Get the current user's session formUsed and user_id
        $userID = $_SESSION['user_id'];

        // Query to fetch distinct formUsed values and form IDs for the current user from the luponforms table
        $query = "SELECT id, formUsed, made_date FROM luponforms WHERE user_id = :userID ORDER BY made_date DESC";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Initialize array to store forms for each KP column
        $kpForms = array_fill(1, 6, array());
        // Initialize array to store counters for each year and KP column
        $counters = array();

        // Organize forms into respective KP columns
        foreach ($results as $row) {
          $formID = $row['id'];
          $formUsed = $row['formUsed'];
          $madeDate = $row['made_date'];
          $year = date('Y', strtotime($madeDate));

          // Initialize counter for the current year and KP column if not set
          if (!isset($counters[$year][$formUsed])) {
            $counters[$year][$formUsed] = 1;
          } else {
            // Increment counter for the current year and KP column
            $counters[$year][$formUsed]++;
          }

          // Store form in respective KP column
          $kpForms[$formUsed][] = array('formID' => $formID, 'madeDate' => $madeDate, 'counter' => $counters[$year][$formUsed]);
        }

        // Display forms in KP columns
        for ($i = 1; $i <= 6; $i++) {
          echo '<div class="col-md-2 mb-3" id="kpColumn_' . $i . '">';
          echo '<h6>KP ' . $i . '</h6>';

          // Display buttons in the column
          foreach ($kpForms[$i] as $form) {
            $formID = $form['formID'];
            $formattedDate = date('Y', strtotime($form['madeDate']));
            $counter = $form['counter'];
            $buttonText = 'KP Form ' . $i . ' (' . $formattedDate . ')';

            // Append counter if it's greater than 1
            if ($counter > 1) {
              $buttonText .= ' (' . $counter . ')';
            }

            $buttonID = 'formButton_' . $formID;

            echo '<button class="open-form btn btn-success w-100 mb-1" id="' . $buttonID . '" data-form-id="' . $formID . '" data-form-used="' . $i . '"><i class="fas fa-file-alt"></i> ' . $buttonText . ' </button>';
          }

          echo '</div>';
        }
        ?>
      </div>

      <script>
        // JavaScript to handle button clicks and redirection with formUsed and formID
        var buttons = document.querySelectorAll('.open-form');
        buttons.forEach(function(button) {
          button.addEventListener('click', function() {
            var formID = this.getAttribute('data-form-id'); // Get the formID
            var formUsed = this.getAttribute('data-form-used');
            var folderName = '<?php echo $folderName; ?>'; // PHP variable for folder name

            // Redirect to the appropriate form page with formID added to the URL
            window.location.href = folderName + '/kp_form' + formUsed + '.php?formID=' + formID;
          });
        });

        // JavaScript to handle search functionality
        document.getElementById("yearInput").addEventListener("input", function() {
          var searchYear = this.value.trim();
          var buttons = document.querySelectorAll(".open-form");

          buttons.forEach(function(button) {
            var buttonText = button.textContent;
            var buttonYear = buttonText.match(/\b\d{4}\b/g); // Extract all 4-digit numbers (years) from the button text

            // Check if the search year matches any extracted year from the button text
            if (searchYear === '' || (buttonYear && buttonYear.includes(searchYear))) {
              button.style.display = "block";
              document.getElementById("kpColumn_" + button.getAttribute("data-form-used")).style.display = "block";
            } else {
              button.style.display = "none";
            }
          });
        });


        // Show all buttons when the page is loaded
        window.onload = function() {
          var buttons = document.querySelectorAll(".open-form");
          buttons.forEach(function(button) {
            button.style.display = "block";
          });
        };
      </script>

    </div>
  </div>

</body>

</html>