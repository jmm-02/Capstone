<?php
session_start();

include 'connection.php';
//include 'admin-navigation.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
  header("Location: login.php");
  exit;
}

include 'admin_func.php';


$currentMunicipalityID = $_SESSION['municipality_id'] ?? null;

$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$accountRequestsQuery = "SELECT u.id, u.username, u.first_name, u.last_name, u.email, u.contact_number, b.barangay_name, u.verified 
                         FROM users u 
                         LEFT JOIN barangays b ON u.barangay_id = b.id 
                         WHERE u.verified = 0 
                         AND u.municipality_id = ? 
                         AND u.user_type = 'user'
                         AND (u.first_name LIKE ? OR u.last_name LIKE ? OR b.barangay_name LIKE ?)
                         ORDER BY b.barangay_name"; // Order by barangay_name for readability

$search_query_like = '%' . $search_query . '%';
$accountRequestsStatement = $conn->prepare($accountRequestsQuery);
$accountRequestsStatement->execute([$currentMunicipalityID, $search_query_like, $search_query_like, $search_query_like]);
$accountRequests = $accountRequestsStatement->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Account Requests</title>
  
  <link rel="icon" type="image/x-icon" href="img/favicon.ico">

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

          <h5 class="card-title mb-9 fw-semibold">Account Requests</h5>
          <hr>
          <b>
            <br>

            <form method="GET" action="" class="searchInput" style="display: flex; align-items: center;">
              <input type="text" class="form-control" name="search" id="search" placeholder="Search by Name or Barangay Name" class="searchInput">
              <input type="submit" class="bg-gray-800 hover:bg-gray-700 px-3 py-2 ml-2 rounded-md text-white" value="Search" class="refresh-button">
            </form>



            <?php
            echo '<div id="account-requests" style="display: block;">';

            if (!empty($accountRequests)) {
              echo '<table class="table table-striped">';
              echo '<thead class="thead-dark"><tr><th>Username</th><th>Secretary</th><th>Email</th><th>Contact No.</th><th>Barangay</th><th>Actions</th></tr></thead>';
              echo '<tbody>';

              foreach ($accountRequests as $user) {
                echo '<tr>';
                echo '<td>' . $user['username'] . '</td>';
                echo '<td>' . $user['first_name'] . ' ' . $user['last_name'] . '</td>';
                echo '<td>' . $user['email'] . '</td>';
                echo '<td>' . $user['contact_number'] . '</td>';
                echo '<td>' . $user['barangay_name'] . '</td>';
                echo '<td>';

                if (!isset($user['verified']) || !$user['verified']) {
                  echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';

                  echo '<input type="hidden" name="user_id" value="' . $user['id'] . '">';

                  echo '<button class="btn btn-success m-1 bg-green-500" type="submit" name="action" value="verify">Unlock</button>';
                  
                  echo '<button class="btn btn-danger m-1 bg-red-500" type="submit" name="action" value="deny">Deny</button>';
                  echo '</form>';
                } else {
                  echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
                  echo '<input type="hidden" name="user_id" value="' . $user['id'] . '">';
                  echo '<button class="btn btn-danger m-1" type="submit" name="action" value="unverify">Unverify</button>';
                  echo '</form>';
                }
                echo '<a href="admin_manage_acc_req.php?user_id=' . $user['id'] . '" class="btn btn-light m-1">Manage</a>';

                echo '</td>';
                echo '</tr>';
              }

              echo '</tbody>';
              echo '</table>';
            } else {
              echo '<p>There are no account requests as of the moment.</p>';
            }

            echo '</div>';
            ?>

          </b>

        </div>
      </div>
    </div>
  </div>
</body>

</html>