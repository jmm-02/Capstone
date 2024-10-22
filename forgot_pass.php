<?php
include 'connection.php';

session_start(); // Starting the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];

  // Check if the email exists in 'users' table
  $check_email_query = "SELECT * FROM users WHERE email = :email";
  $stmt = $conn->prepare($check_email_query);
  $stmt->bindParam(':email', $email);
  $stmt->execute();
  $user_row = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$user_row) {
    echo "This email is not yet registered into the system. Please check your spelling.";
  } else {
    $userID = $user_row['id'];

    // Check if security questions exist for the user
    $check_security_query = "SELECT * FROM security WHERE user_id = :user_id";
    $stmt = $conn->prepare($check_security_query);
    $stmt->bindParam(':user_id', $userID);
    $stmt->execute();
    $security_row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$security_row) {
      echo "This user has not yet set their Security Questions, therefore unable to reset the password. Please request an admin to reset your password.";
    } else {
      // Storing user_id in session
      $_SESSION['user_id'] = $userID;

      // Redirecting without user_id in URL
      header("Location: verify_account.php");
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
  <title>Forgot Password</title>

  <link rel="stylesheet" href="assets/css/styles.min.css" />
  <link rel="icon" type="image/x-icon" href="img/favicon.ico">
  
  <script src="service-worker-registration.js"></script>
  
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                
                </a>
                <div class="text-center">
                  <img src="img/cluster.png" alt="Logo" style="max-width: 120px; max-height: 120px; margin-right: 10px;" class="align-middle"><br><br>
                  <b>
                    <h5 class="card-title mb-9 fw-semibold">Forgot Password</h5>
                  </b>
                </div>


                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <input type="email" class="form-control" placeholder="Email" name="email" required><br>
                  <input type="submit" class="btn btn-primary w-100" value="Search">
                </form>
              </div>
              <a href="login.php" style="padding: 2rem;">Back to Login</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

</body>

</html>