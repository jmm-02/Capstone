<?php

session_start();
include 'connection.php';

$userID = $_SESSION['user_id'];

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
  header("Location: login.php");
  exit;
}

// Fetch today's date logs by default
$query = "SELECT user_id, timestamp, activity FROM user_logs WHERE user_id = :user_id AND DATE(timestamp) = CURDATE() ORDER BY timestamp DESC";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $inputData = json_decode(file_get_contents('php://input'), true);

  $selectedDate = $inputData['selected_date'];

  $query = "SELECT user_id, timestamp, activity FROM user_logs WHERE user_id = :user_id AND DATE(timestamp) = :selected_date ORDER BY timestamp DESC";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
  $stmt->bindParam(':selected_date', $selectedDate, PDO::PARAM_STR); // Bind as string
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Return the result as JSON
  echo json_encode($result);
  exit;
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Logs</title>

  <link rel="icon" type="image/x-icon" href="img/favicon.ico">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <script>
    // Send data via POST using fetch API
    async function sendData(selectedDate) {
      try {
        const response = await fetch("", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            selected_date: selectedDate
          })
        });

        const result = await response.json();

        // Clear previous table content
        const tableBody = document.querySelector("tbody");
        tableBody.innerHTML = '';

        // Populate table with new data
        result.forEach(row => {
          const newRow = `<tr>
                                <td>${row.timestamp}</td>
                                <td>${row.activity}</td>
                          </tr>`;
          tableBody.innerHTML += newRow;
        });

      } catch (error) {
        console.error("Error:", error);
      }
    }

    // Handle form submission
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('formUserLog');
      form.onsubmit = function(event) {
        event.preventDefault();
        const selectedDate = document.querySelector('input[name="selected_date"]').value;

        if (navigator.onLine) {
          sendData(selectedDate);
        } else {
          localStorage.setItem('selectedDate', selectedDate);
          alert('No internet. Data will be inserted once the internet is restored.');
        }
      };

      function syncWhenOnline() {
        const selectedDate = localStorage.getItem('selectedDate');
        if (selectedDate) {
          sendData(selectedDate);
          localStorage.removeItem('selectedDate');
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
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-9 fw-semibold">User Activity Logs</h5>

          <form id="formUserLog">

            <div class="d-flex">
              <input type="date" class="form-control" name="selected_date" id="selected_date">
              <input type="submit" class="bg-gray-800 hover:bg-gray-700 ml-2 px-3 py-2 rounded-md text-white" value="Go" class="ml-2">
            </div>
          </form>

          <table class="table table-striped">
            <thead class="thead-dark">
              <tr>
                <th>Timestamp</th>
                <th>Activity</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($result as $row) { ?>

                <tr>
                  <td><?php echo $row['timestamp'] ?></td>
                  <td><?php echo $row['activity'] ?></td>
                </tr>

              <?php  } ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>

</html>