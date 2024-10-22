<?php
session_start();

include 'connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
  header("Location: login.php");
  exit;
}

include 'admin_func.php';


$action_submitted = isset($_GET['search']);
$currentMunicipalityID = $_SESSION['municipality_id'] ?? null;
// Prepare the search query if search form is submitted
if ($action_submitted) {
  $search_query = $_GET['search'];
  $searchUsersQuery = "SELECT u.id, u.username, u.first_name, u.last_name, u.email, u.contact_number, b.barangay_name 
                    FROM users u 
                    LEFT JOIN barangays b ON u.barangay_id = b.id 
                    WHERE u.verified = 1 
                    AND u.municipality_id = ? 
                    AND (u.first_name LIKE '%$search_query%' 
                        OR u.last_name LIKE '%$search_query%' 
                        OR b.barangay_name LIKE '%$search_query%')";

  $searchUsersStatement = $conn->prepare($searchUsersQuery);
  $searchUsersStatement->execute([$currentMunicipalityID]);
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Secretaries Corner</title>
  
  <link rel="icon" type="image/x-icon" href="img/favicon.ico">

  <style>
    .searchInput {
      display: flex;
      align-items: center;
    }

    .searchInput input[type="text"] {
      flex: 1;
    }

    .searchInput input[type="submit"] {
      margin-left: 5px;
      /* Adjust the margin as needed */
    }
  </style>

</head>

<body class="bg-[#E8E8E7]">

  <?php include "admin_sidebar_header.php"; ?>

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

          <h5 class="card-title mb-9 fw-semibold">Secretaries Corner</h5>
          <hr>
          <b>
            <br>

            <form method="GET" action="" class="searchInput">
              <input type="text" class="form-control" name="search" id="search" placeholder="Search by Name or Barangay Name">
              <input type="submit" class="bg-gray-800 hover:bg-gray-700 px-3 py-2 ml-2 rounded-md text-white" value="Search">
            </form>


            <?php // Your code before the table structure
            $verifiedUsersQuery = "SELECT id, username, first_name, last_name, email, contact_number, barangay_id 
                        FROM users 
                        WHERE verified = 1 
                        AND municipality_id = ?";

            $verifiedUsersStatement = $conn->prepare($verifiedUsersQuery);
            $verifiedUsersStatement->execute([$currentMunicipalityID]);
            ?>




            <table class="table table-striped">
              <thead class="thead-dark">
                <tr>
                  <th>Username</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Contact No.</th>
                  <th>Barangay Name</th>
                  <th>Actions</th>
                </tr>
              </thead>

              <?php
              echo '<tbody>';

              if ($action_submitted) {
                while ($verifiedUser = $searchUsersStatement->fetch(PDO::FETCH_ASSOC)) {
                  // Fetch barangay name for the current user if the key exists
                  $barangayName = $verifiedUser['barangay_name'] ?? '';
                  if (array_key_exists('barangay_id', $verifiedUser)) {
                    $barangayNameQuery = "SELECT barangay_name FROM barangays WHERE id = ?";
                    $barangayStatement = $conn->prepare($barangayNameQuery);
                    $barangayStatement->execute([$verifiedUser['barangay_id']]);
                    $barangayName = $barangayStatement->fetchColumn();
                  }

                  // Displaying table rows for search results
                  echo '<tr>';
                  echo '<td>' . $verifiedUser['username'] . '</td>';
                  echo '<td>' . $verifiedUser['first_name'] . ' ' . $verifiedUser['last_name'] . '</td>';
                  echo '<td>' . $verifiedUser['email'] . '</td>';
                  echo '<td>' . $verifiedUser['contact_number'] . '</td>';
                  echo '<td>' . $barangayName . '</td>';
                  echo '<td>';
                  // Your actions/buttons for search results
                  echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
                  echo '<input type="hidden"  name="user_id" value="' . $verifiedUser['id'] . '">';
                  echo '<button class="bg-green-500 hover:bg-green-400 px-3 py-2 ml-2 rounded-md text-white" type="submit" name="action" value="unverify">Lock</button>';
                  echo '</form>';
                  echo '</td>';
                  echo '<td>';
                  // Your actions/buttons for search results
                  echo '<form method="post" class="form-control" action="admin_viewreport.php">';
                  echo '<input type="hidden" name="user_id" value="' . $verifiedUser['id'] . '">';
                  // Fetch barangay_id and include it as a hidden input
                  $barangayIdQuery = "SELECT barangay_id FROM users WHERE id = ?";
                  $barangayStatement = $conn->prepare($barangayIdQuery);
                  $barangayStatement->execute([$verifiedUser['id']]);
                  $barangayId = $barangayStatement->fetchColumn();
                  echo '<input type="hidden" name="barangay_id" value="' . $barangayId . '">';
                  echo '<button class="btn btn-success m-1" type="submit" name="viewreport">View Report</button>';
                  echo '</form>';
                  echo '</td>';
                  echo '</tr>';
                }
              } else {

                while ($verifiedUser = $verifiedUsersStatement->fetch(PDO::FETCH_ASSOC)) {
                  // Fetch barangay name for the current user if the key exists
                  $barangayName = '';
                  if (isset($verifiedUser['barangay_id'])) {
                    $barangayNameQuery = "SELECT barangay_name FROM barangays WHERE id = ?";
                    $barangayStatement = $conn->prepare($barangayNameQuery);
                    $barangayStatement->execute([$verifiedUser['barangay_id']]);
                    $barangayName = $barangayStatement->fetchColumn();
                  }
                  // Displaying table rows for verified users
                  echo '<tr>';
                  echo '<td>' . $verifiedUser['username'] . '</td>';
                  echo '<td>' . $verifiedUser['first_name'] . ' ' . $verifiedUser['last_name'] . '</td>';
                  echo '<td>' . $verifiedUser['email'] . '</td>';
                  echo '<td>' . $verifiedUser['contact_number'] . '</td>';
                  echo '<td>' . $barangayName . '</td>';
                  echo '<td>';
                  // Your actions/buttons for verified users
                  echo '<form method="post"  action="' . $_SERVER['PHP_SELF'] . '">';
                  echo '<input type="hidden" name="user_id" value="' . $verifiedUser['id'] . '">';
                  echo '<button class="bg-red-500 hover:bg-red-400 px-3 py-2 ml-2 rounded-md text-white" type="submit" name="action" value="unverify">Lock</button>';
                  echo '</form>';
                  echo '</td>';
                  echo '<td>';
                  // Your actions/buttons for verified users
                  echo '<form method="post"  action="admin_viewreport.php">';
                  echo '<input type="hidden" name="user_id" value="' . $verifiedUser['id'] . '">';
                  // Fetch barangay_id and include it as a hidden input
                  $barangayIdQuery = "SELECT barangay_id FROM users WHERE id = ?";
                  $barangayStatement = $conn->prepare($barangayIdQuery);
                  $barangayStatement->execute([$verifiedUser['id']]);
                  $barangayId = $barangayStatement->fetchColumn();
                  echo '<input type="hidden" name="barangay_id" value="' . $barangayId . '">';
                  echo '<button class="bg-blue-500 hover:bg-blue-400 px-3 py-2 ml-2 rounded-md text-white" type="submit" name="viewreport">View Report</button>';
                  echo '</form>';
                  echo '</td>';
                  echo '</tr>';
                }
              }
              // Closing table structure
              echo '</tbody>';
              echo '</table>';
              echo '</div>';
              echo '</div>';
              ?>
              </tbody>
            </table>
          </b>

        </div>
      </div>

    </div>

  </div>

</body>

</html>