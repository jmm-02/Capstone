<?php
session_start();
include 'connection.php';
//include 'superadmin-navigation.php';


// Check if the user is a superadmin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'superadmin') {
  header("Location: login.php");
  exit;
}

$searchedMunicipality = '';

// Handling search functionality
if (isset($_POST['search'])) {
  $searchedMunicipality = $_POST['municipality']; // Get the searched municipality
  $stmt = $conn->prepare("SELECT u.id, u.municipality_id, u.first_name, u.last_name, u.contact_number, u.email, m.municipality_name FROM users u
                            INNER JOIN municipalities m ON u.municipality_id = m.id
                            WHERE u.user_type = 'admin' AND m.municipality_name LIKE :municipality");
  $stmt->bindValue(':municipality', '%' . $searchedMunicipality . '%', PDO::PARAM_STR);
  $stmt->execute();
  $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
  // Fetch all municipalities if no search is performed
  $stmt = $conn->prepare("SELECT u.id, u.municipality_id, u.first_name, u.last_name, u.contact_number, u.email, m.municipality_name FROM users u
                            INNER JOIN municipalities m ON u.municipality_id = m.id
                            WHERE u.user_type = 'admin'");
  $stmt->execute();
  $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registered Municipalities</title>
  <link rel="icon" type="image/x-icon" href="img/favicon.ico">
  <link rel="stylesheet" href="assets/css/styles.min.css" />

</head>

<body class="bg-[#E8E8E7]">

  <?php include "sa_sidebar_header.php"; ?>

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

          <h5 class="card-title mb-9 fw-semibold">Registered Municipalities</h5>
          <hr>
          <b>
            <br>

            <form method="GET" action="" class="searchInput">
              <div style="display: flex; align-items: center;">
                <input type="text" name="municipality" class="form-control" placeholder="Search Municipality" value="<?php echo $searchedMunicipality; ?>">
                <br><button type="submit" class="bg-gray-800 ml-2 hover:bg-gray-700 px-3 py-2 rounded-md text-white" name="search">Search
                </button>
                <input type="submit" class="bg-white border-1 ml-2 border-black text-black px-3 py-2 rounded-md " name="clear" value="Clear" formnovalidate>
              </div>
            </form>

            <br>


            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="municipality-column" style="padding: 8px; background-color: #d3d3d3;">Municipality</th>
                  <th class="admin-column" style="padding: 8px; background-color: #d3d3d3;">Admin</th>
                  <th class="contact-column" style="padding: 8px; background-color: #d3d3d3;">Contact Number</th>
                  <th class="email-column" style="padding: 8px; background-color: #d3d3d3;">Email</th>
                  <th class="actions-column" style="padding: 8px; background-color: #d3d3d3;">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($user as $row) { ?>
                  <tr>
                    <td><?php echo $row['municipality_name']; ?></td>
                    <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                    <td><?php echo $row['contact_number']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                      <a href="sa_manageregisteredmuni.php?admin_id=<?php echo $row['id']; ?>" class="btn btn-primary m1">
                        <i class="fas fa-cog"></i> Manage
                      </a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </b>
        </div>
      </div>
    </div>
  </div>

</body>

</html>