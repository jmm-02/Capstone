<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
  header("Location: login.php");
  exit;
}

$userID = $_SESSION['user_id'];

# function to get all unarchived cases from the database
function getAllUnarchive($conn, $userID)
{
  $query = "SELECT * FROM complaints WHERE UserID = :userID AND IsArchived = 1";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':userID', $userID);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

# always get unarchive cases when the page is rendered
$result = getAllUnarchive($conn, $userID);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $inputData = json_decode(file_get_contents('php://input'), true);

  if (isset($inputData['selected_id']) && is_array($inputData['selected_id'])) {
    $unarchiveIDs = $inputData['selected_id'];

    // Prepare the query to unarchive multiple rows
    $unarchiveQuery = "UPDATE complaints SET IsArchived = 0 WHERE id IN (" . implode(",", array_map('intval', $unarchiveIDs)) . ")";
    $stmt = $conn->prepare($unarchiveQuery);

    if ($stmt->execute()) {
      $updatedResult = getAllUnarchive($conn, $userID);  // Fetch updated data
      echo json_encode($updatedResult);  // Return updated data in JSON
      exit;
    }
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Archives</title>
  <link rel="icon" type="image/x-icon" href="img/favicon.ico">

  <script>
    async function sendData(selectedIds) {

      const response = await fetch("", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          selected_id: selectedIds
        })
      });

      const result = await response.json();

      // Clear previous table content
      const tableBody = document.querySelector("tbody"); // Get the actual element
      tableBody.innerHTML = '';

      // Populate table with new data
      result.forEach(row => {
        const newRow = `
              <tr>                 
                <td>${row.CNum}</td>
                <td>${row.ForTitle}</td>
                <td>${row.CNames}</td>
                <td>${row.RspndtNames}</td>
                <td>${row.Mdate}</td>
                <td><input type="checkbox" class="case-checkbox" value="${row.id}"></td>
              </tr>`;
        tableBody.innerHTML += newRow;
      });

      if (result.length === 0) {
        document.getElementById('unarchiveButtonSection').classList.add('hidden');
      }

    }
  </script>

  <script>
    // Handle form submission for unarchiving multiple rows
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('unarchiveSelected').addEventListener('click', function(event) {
        event.preventDefault();

        // Get all selected checkboxes
        const checkboxes = document.querySelectorAll('.case-checkbox:checked');
        const selectedIds = Array.from(checkboxes).map(checkbox => checkbox.value);

        if (selectedIds.length > 0) {
          if (navigator.onLine) {
            sendData(selectedIds); // Send selected IDs
          } else {
            localStorage.setItem('unarchiveIds', JSON.stringify(selectedIds));
            alert('No internet. Your request will be executed once the internet is restored.');
          }
        } else {
          alert('Please select at least one case to unarchive.');
        }
      });

      // Sync function when back online
      function syncWhenOnline() {
        const unarchiveIds = JSON.parse(localStorage.getItem('unarchiveIds'));
        if (unarchiveIds && unarchiveIds.length > 0) {
          sendData(unarchiveIds);
          localStorage.removeItem('unarchiveIds');
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

  <div class="p-4 sm:ml-44">
    <div class="rounded-lg mt-16">

      <!--  Row 1 -->
      <div class="card">
        <div class="card-body">

          <h5 class="card-title mb-9 fw-semibold">Barangay Complaint Archives</h5>

          <input type="text" class="form-control" name="search" id="searchUnarchive" placeholder="Search by Case No., Title, Complainants, or Respondents" onkeyup="searchTable()" class="searchInput" style="flex: 1; margin-right: 5px;">


          <br>
          <table id="UnarchiveTable" class="table table-striped">
            <thead class="thead-dark">
              <tr>
                <th>No.</th>
                <th>Title</th>
                <th>Complainants</th>
                <th>Respondents</th>
                <th>Date</th>
                <th>Unarchive</th>
              </tr>
            </thead>
            <tbody>

              <?php foreach ($result as $row) { ?>
                <tr>
                  <td><?php echo $row['CNum']; ?></td>
                  <td><?php echo $row['ForTitle']; ?></td>
                  <td><?php echo $row['CNames']; ?></td>
                  <td><?php echo $row['RspndtNames']; ?></td>
                  <td><?php echo $row['Mdate']; ?></td>
                  <td><input type="checkbox" class="case-checkbox" value="<?php echo $row['id']; ?>"></td>
                </tr>
              <?php } ?>

            </tbody>
          </table>

          <section id="unarchiveButtonSection" class="w-full flex justify-end">
            <button id="unarchiveSelected" class="p-2 bg-red-400 text-white rounded-md">Unarchive</button>
          </section>

        </div>
      </div>
    </div>
  </div>

  <script>
    function searchTable() {
      // Declare variables
      let input = document.getElementById('searchUnarchive');
      let filter = input.value.toLowerCase();
      let table = document.getElementById('UnarchiveTable');
      let tr = table.getElementsByTagName('tr');

      // Loop through all table rows, excluding the header
      for (let i = 1; i < tr.length; i++) {
        let td = tr[i].getElementsByTagName('td');
        let rowText = '';

        // Concatenate all text content from each cell
        for (let j = 0; j < td.length - 1; j++) {
          rowText += td[j].textContent || td[j].innerText;
        }

        // If the row matches the search term, show it, otherwise hide it
        if (rowText.toLowerCase().indexOf(filter) > -1) {
          tr[i].style.display = '';
        } else {
          tr[i].style.display = 'none';
        }
      }
    }
  </script>

</body>

</html>