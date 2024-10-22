<?php
include 'connection.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$errors = [];

$questions = [
    1 => "What is the name of your pet?",
    2 => "What is your mother's maiden name?",
    3 => "What city were you born in?",
    4 => "What is your favorite book?"
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $userID = $_SESSION['user_id'];

    $answer1 = $_POST['answer1'];
    $answer2 = $_POST['answer2'];
    $answer3 = $_POST['answer3'];

    $get_answers_query = "SELECT answer1, answer2, answer3 FROM security WHERE user_id = :user_id";
    $stmt = $conn->prepare($get_answers_query);
    $stmt->bindParam(':user_id', $userID);
    $stmt->execute();
    $security_answers = $stmt->fetch(PDO::FETCH_ASSOC);

    if (
        $security_answers &&
        password_verify($answer1, $security_answers['answer1']) &&
        password_verify($answer2, $security_answers['answer2']) &&
        password_verify($answer3, $security_answers['answer3'])
    ) {
        $_SESSION['verification_complete'] = true;
        header("Location: reset_pass.php");
        exit;
    } else {
        $get_user_data_query = "SELECT attempt_count, restrict_end FROM users WHERE id = :user_id";
        $stmt = $conn->prepare($get_user_data_query);
        $stmt->bindParam(':user_id', $userID);
        $stmt->execute();
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

        $wrong_attempt_limit = 5;

        if ($user_data['attempt_count'] >= $wrong_attempt_limit - 1) {
            if ($user_data['restrict_end'] && strtotime($user_data['restrict_end']) > time()) {
                $errors[] = "You have reached the maximum attempts. Please try again after the restriction period ends, or contact your Admin to reset your password.";
            } else {
                $errors[] = "You have reached the maximum attempts. Your account is restricted for 5 days.";
                $restrict_end = date('Y-m-d H:i:s', strtotime('+5 days'));
                $update_attempts_query = "UPDATE users SET attempt_count = 0, restrict_end = :restrict_end WHERE id = :user_id";
                $stmt = $conn->prepare($update_attempts_query);
                $stmt->bindParam(':restrict_end', $restrict_end);
                $stmt->bindParam(':user_id', $userID);
                $stmt->execute();
            }
        } else {
            $attempts_left = $wrong_attempt_limit - $user_data['attempt_count'];
            $errors[] = "One or more answers are incorrect. You have {$attempts_left} attempts left.";
            $new_attempts = $user_data['attempt_count'] + 1;
            $update_attempts_query = "UPDATE users SET attempt_count = :attempts WHERE id = :user_id";
            $stmt = $conn->prepare($update_attempts_query);
            $stmt->bindParam(':attempts', $new_attempts);
            $stmt->bindParam(':user_id', $userID);
            $stmt->execute();
        }
    }
}

// Display security questions
if (isset($_SESSION['user_id'])) {
    $userID = $_SESSION['user_id'];

    $get_questions_query = "SELECT question1, question2, question3 FROM security WHERE user_id = :user_id";
    $stmt = $conn->prepare($get_questions_query);
    $stmt->bindParam(':user_id', $userID);
    $stmt->execute();
    $security_row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$security_row) {
        $errors[] = "Security questions not found for this user.";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Verify Account</title>
  <link rel="stylesheet" href="assets/css/styles.min.css" />
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
    <b><h5 class="card-title mb-9 fw-semibold">Verify Account</h5></b>
</div>

<?php
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
    ?>

<b>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <?php if (isset($security_row) && !empty($security_row)) : ?>
            <label><?php echo $questions[$security_row['question1']]; ?></label>
            <input type="text" class="form-control" name="answer1" required><br>

            <label><?php echo $questions[$security_row['question2']]; ?></label>
            <input type="text" class="form-control" name="answer2" required><br>

            <label><?php echo $questions[$security_row['question3']]; ?></label>
            <input type="text" class="form-control" name="answer3" required><br>

            <b>  <p><a href="logout.php">Cancel</a></p>

            <input type="submit" class="btn btn-primary w-100" value="Verify Answers">
        <?php endif; ?>
    </form>     
    

    <script>
    window.addEventListener('beforeunload', function(event) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'logout.php', false);
        xhr.send();
    });
</script>



       </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>