


<?php
include "connection.php";

$userID = $_SESSION['user_id'];

// to determine if modal must show or not
$stmt = $conn->prepare("SELECT * FROM security WHERE user_id = :userID");
$stmt->bindParam(':userID', $userID);
$stmt->execute();

$isModalHidden = ($stmt->rowCount() > 0) ? "hidden" : "flex";

// ----------------------


// Fetch the user's security questions from the database
$stmt = $conn->prepare("SELECT question1, question2, question3 FROM security WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmt->execute();
$securityQuestions = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if security questions exist for the user
if ($securityQuestions) {
  $question1 = $securityQuestions['question1'];
  $question2 = $securityQuestions['question2'];
  $question3 = $securityQuestions['question3'];
} else {
  // Set empty values if no questions are found
  $question1 = '';
  $question2 = '';
  $question3 = '';
}

?>


<div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="<?php echo $isModalHidden ?> overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
  <div class="relative p-4 w-full max-w-2xl max-h-full">
    <!-- Modal content -->
    <div class="relative bg-white border-1 border-gray-400 rounded-lg shadow shadow-xl shadow-black">
      <!-- Modal header -->
      <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
        <h3 class="text-xl font-semibold text-gray-900">
          Add Security Questions
        </h3>
      </div>
      <!-- Modal body -->
      <div class="p-4 md:p-5 space-y-4">


        <form id="securityForm" method="post" action="security_handler.php">
          <div class="tab-pane fade <?php echo !isset($_POST['security_settings']) ? 'active show' : ''; ?>" id="account-security">
            <h6>
              <?php if (!empty($message)) { ?>
                <p class="text-success"><?php echo $message; ?></p>
              <?php } ?>
              <?php if (!empty($error)) { ?>
                <p class="text-danger"><?php echo $error; ?></p>
              <?php } ?>
            </h6>
            <div class="form-group">
              <label for="question1">Security Question 1:</label>
              <select class="form-control" id="question1" name="question1" required>
                <option value="" <?php echo ($question1 == '') ? 'selected' : ''; ?>>Select a Question</option>
                <option value="1" <?php echo ($question1 == 1) ? 'selected' : ''; ?>>What is the name of your pet?</option>
                <option value="2" <?php echo ($question1 == 2) ? 'selected' : ''; ?>>What is your mother's maiden name?</option>
                <option value="3" <?php echo ($question1 == 3) ? 'selected' : ''; ?>>What city were you born in?</option>
                <option value="4" <?php echo ($question1 == 4) ? 'selected' : ''; ?>>What is your favorite book?</option>
              </select>
              <label for="answer1">Answer:</label>
              <input type="password" class="form-control" id="answer1" name="answer1" required>
            </div>
            <div class="form-group">
              <label for="question2">Security Question 2:</label>
              <select class="form-control" id="question2" name="question2" required>
                <option value="" <?php echo ($question2 == '') ? 'selected' : ''; ?>>Select a Question</option>
                <option value="1" <?php echo ($question2 == 1) ? 'selected' : ''; ?>>What is the name of your pet?</option>
                <option value="2" <?php echo ($question2 == 2) ? 'selected' : ''; ?>>What is your mother's maiden name?</option>
                <option value="3" <?php echo ($question2 == 3) ? 'selected' : ''; ?>>What city were you born in?</option>
                <option value="4" <?php echo ($question2 == 4) ? 'selected' : ''; ?>>What is your favorite book?</option>
              </select>
              <label for="answer2">Answer:</label>
              <input type="password" class="form-control" id="answer2" name="answer2" required>
            </div>
            <div class="form-group">
              <label for="question3">Security Question 3:</label>
              <select class="form-control" id="question3" name="question3" required>
                <option value="" <?php echo ($question3 == '') ? 'selected' : ''; ?>>Select a Question</option>
                <option value="1" <?php echo ($question3 == 1) ? 'selected' : ''; ?>>What is the name of your pet?</option>
                <option value="2" <?php echo ($question3 == 2) ? 'selected' : ''; ?>>What is your mother's maiden name?</option>
                <option value="3" <?php echo ($question3 == 3) ? 'selected' : ''; ?>>What city were you born in?</option>
                <option value="4" <?php echo ($question3 == 4) ? 'selected' : ''; ?>>What is your favorite book?</option>
              </select>
              <label for="answer3">Answer:</label>
              <input type="password" class="form-control" id="answer3" name="answer3" required>
            </div>
            <br>
            <button type="submit" class="bg-blue-500 hover:bg-blue-400 px-3 py-2 rounded-md text-white" name="security_settings">Save Security Settings</button>
            <input type="hidden" name="active_tab" value="security">
          </div>
        </form>

      </div>

    </div>
  </div>
</div>
