<?php
session_start();
include 'connection.php';

$userID = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
$stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch the user's security questions from the database
$stmt = $conn->prepare("SELECT question1, question2, question3 FROM security WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if LGU logo is uploaded
  if (isset($_FILES['lgulogo']) && $_FILES['lgulogo']['error'] === UPLOAD_ERR_OK) {
    // Get the uploaded LGU logo information
    $lgulogo_name = $_FILES['lgulogo']['name'];
    $lgulogo_tmp_name = $_FILES['lgulogo']['tmp_name'];

    // Move the uploaded LGU logo to the "lgu_logo" folder
    move_uploaded_file($lgulogo_tmp_name, 'lgu_logo/' . $lgulogo_name);

    // Update the LGU logo filename in the database for the current user
    $stmt = $conn->prepare("UPDATE users SET lgu_logo = :lgulogo_name WHERE id = :user_id");
    $stmt->bindParam(':lgulogo_name', $lgulogo_name);
    $stmt->bindParam(':user_id', $userID);
    $stmt->execute();

    // Optionally, you can show a success message
    echo "LGU Logo saved successfully!";
  }

  // Check if KP logo is uploaded
  if (isset($_FILES['kplogo']) && $_FILES['kplogo']['error'] === UPLOAD_ERR_OK) {
    // Get the uploaded KP logo information
    $kplogo_name = $_FILES['kplogo']['name'];
    $kplogo_tmp_name = $_FILES['kplogo']['tmp_name'];

    // Move the uploaded KP logo to the "city_logo" folder
    move_uploaded_file($kplogo_tmp_name, 'city_logo/' . $kplogo_name);

    // Update the KP logo filename in the database for the current user
    $stmt = $conn->prepare("UPDATE users SET city_logo = :kplogo_name WHERE id = :user_id");
    $stmt->bindParam(':kplogo_name', $kplogo_name);
    $stmt->bindParam(':user_id', $userID);
    $stmt->execute();

    // Optionally, you can show a success message
    echo "KP Logo saved successfully!";
  }
}

function uploadFile($file, $directory)
{
  $allowed_types = array('image/jpeg', 'image/png');
  $max_size = 5 * 1024 * 1024; // 5MB

  if (in_array($file['type'], $allowed_types) && $file['size'] <= $max_size) {
    $filename = uniqid() . '_' . $file['name'];
    $destination = $directory . '/' . $filename;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
      return $filename;
    }
  }

  return false;
}

?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Settings</title>

  <link rel="icon" type="image/x-icon" href="img/favicon.ico">

  <style>
    .card {
      box-shadow: 0 0 0.3cm rgba(0, 0, 0, 0.2);
      border-radius: 15px;
    }
  </style>

</head>

<body class="bg-[#E8E8E7]">

  <?php include "user_sidebar_header.php"; ?>

  <div class="p-4 sm:ml-44 ">
    <div class="rounded-lg mt-16">

      <!-- Row 1 -->
      <div class="row">
        <div class="col-lg-4 d-flex align-items-strech">
          <div class="card w-100">
            <div class="card-body">
              <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                <div class="mb-3 mb-sm-0">
                  <div class="d-flex align-items-center prof-container">

                    <img
                      src="profile_pictures/<?php echo $user['profile_picture'] ?: 'defaultpic.jpg'; ?>?t=<?php echo time(); ?>"
                      alt=""
                      class="d-block ui-w-80"
                      style="max-width: 120px; max-height: 120px; margin-right: 10px;"
                      class="align-middle">

                    <input
                      type="file"
                      id="fileInput"
                      name="profile_pic"
                      style="display: none;">

                    <button
                      type="button"
                      id="uploadButton"
                      class="bg-blue-500 hover:bg-blue-400 px-3 py-2 rounded-md text-white">
                      Upload a picture
                    </button>

                  </div>
                  <br>
                  <h5 class="card-title mb-9 fw-semibold">Account Settings</h5>
                  <hr>
                  <?php if (!empty($message)) { ?>
                    <p class="text-success"><?php echo $message; ?></p>
                  <?php } ?>
                  <?php if (!empty($error)) { ?>
                    <p class="text-danger"><?php echo $error; ?></p>
                  <?php } ?>
                  <!-- ################################################################### -->
                  <form id="userSettingsForm" method="post" action="general_handler.php">

                    <div class="form-group">
                      <label for="first_name">Username:</label>
                      <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>">
                    </div>

                    <div class="form-group">
                      <label for="first_name">First Name:</label>
                      <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>">
                    </div>

                    <div class="form-group">
                      <label for="last_name">Last Name:</label>
                      <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user['last_name']; ?>">
                    </div>

                    <div class="form-group">
                      <label for="contact_number">Contact Number:</label>
                      <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo $user['contact_number']; ?>">
                    </div>

                    <div class="form-group">
                      <label for="email">Email:</label>
                      <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>">
                    </div>

                    <div class="form-group">
                      <label for="new_password">New Password (Leave empty to keep current password):</label>
                      <input type="password" class="form-control" pattern=".{8,}" title="Password must be at least 8 characters long" id="new_password" name="new_password" placeholder="">
                    </div>

                    <input type="hidden" name="active_tab" value="general"><br>
                    <button
                      type="submit"
                      name="general_settings"
                      class="bg-green-500 hover:bg-green-400 px-3 py-2 rounded-md text-white">
                      Save Changes
                    </button>
                  </form>
                  <!-- ################################################################### -->
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="row">
            <div class="col-lg-12">
              <!-- Yearly Breakup -->
              <div class="card overflow-hidden">
                <div class="card-body p-4">
                  <h5 class="card-title mb-9 fw-semibold">Update Security Settings</h5>
                  <hr>

                  <!-- ################################################################### -->

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
                      <button type="submit" class="bg-green-500 hover:bg-green-400 px-3 py-2 rounded-md text-white" name="security_settings">Save Security Settings</button>
                      <input type="hidden" name="active_tab" value="security">
                    </div>
                  </form>
                  <!-- ################################################################### -->
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <form id="lgulogoForm" enctype="multipart/form-data" action="user_setting.php" method="POST">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title mb-9 fw-semibold">Upload LGU Logo</h5>
                <hr>
                <div class="d-flex align-items-center justify-content-between">
                  <input type="file" id="lgulogoInput" name="lgulogo" style="display: none;">
                  <img id="lgulogoPreview" src="lgu_logo/<?php echo $user['lgu_logo'] ?: 'defaultpic.jpg'; ?>" alt="LGU Logo" style="max-width: 120px; max-height: 120px; margin-right: 10px;">
                  <button type="button" id="uploadLGUButton" class="bg-green-500 hover:bg-green-400 px-3 py-2 rounded-md text-white">Upload</button>
                  <button type="submit" id="saveLGUButton" class="bg-blue-500 hover:bg-blue-400 px-3 py-2 rounded-md text-white">Save</button>
                </div>
              </div>
            </div>
          </form>

          <form id="kplogoForm" enctype="multipart/form-data" action="user_setting.php" method="POST">
            <div class="card mt-3">
              <div class="card-body">
                <h5 class="card-title mb-9 fw-semibold">Upload KP Logo</h5>
                <hr>
                <div class="d-flex align-items-center justify-content-between">
                  <input type="file" id="kplogoInput" name="kplogo" style="display: none;">
                  <img id="kplogoPreview" src="city_logo/<?php echo $user['city_logo'] ?: 'defaultpic.jpg'; ?>" alt="KP Logo" style="max-width: 120px; max-height: 120px; margin-right: 10px;">
                  <button type="button" id="uploadKPButton" class="bg-green-500 hover:bg-green-400 px-3 py-2 rounded-md text-white">Upload</button>
                  <button type="submit" id="saveKPButton" class="bg-blue-500 hover:bg-blue-400 px-3 py-2 rounded-md text-white">Save</button>
                </div>

              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function() {

        // Profile Picture upload
        const profileFileInput = document.getElementById('fileInput');
        const profileUploadButton = document.getElementById('uploadButton');
        const profilePic = document.getElementById('profilePic');

        profileUploadButton.addEventListener('click', function() {
          profileFileInput.click();
        });

        profileFileInput.addEventListener('change', function() {
          const file = this.files[0];
          if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
              profilePic.setAttribute('src', e.target.result);
            };
            reader.readAsDataURL(file);

            const formData = new FormData();
            formData.append('profile_pic', file);

            fetch('upload_pic.php', {
                method: 'POST',
                body: formData
              })
              .then(response => {
                if (!response.ok) {
                  throw new Error('Network response was not ok.');
                }
                return response.text();
              })
              .then(data => {
                console.log('Profile Picture Upload successful:', data);
              })
              .catch(error => {
                console.error('Profile Picture Upload Error:', error);
              });
          }
        });

        // LGU Logo upload
        const lguFileInput = document.getElementById('lgulogoInput');
        const lguUploadButton = document.getElementById('uploadLGUButton');
        const lguSaveButton = document.getElementById('saveLGUButton');
        const lguLogoPreview = document.getElementById('lgulogoPreview');

        lguUploadButton.addEventListener('click', function() {
          lguFileInput.click();
        });

        lguFileInput.addEventListener('change', function() {
          const file = this.files[0];
          if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
              lguLogoPreview.setAttribute('src', e.target.result);
            };
            reader.readAsDataURL(file);
          }
        });

        lguSaveButton.addEventListener('click', function() {
          const file = lguFileInput.files[0];
          if (file) {
            const formData = new FormData();
            formData.append('lgulogo', file);

            fetch('user_setting.php', {
                method: 'POST',
                body: formData
              })
              .then(response => {
                if (!response.ok) {
                  throw new Error('Network response was not ok.');
                }
                return response.text();
              })
              .then(data => {
                console.log('LGU Logo Save successful:', data);
                // Scroll to the "#account-general" section
                document.querySelector("#account-general").scrollIntoView();
              })
              .catch(error => {
                console.error('LGU Logo Save Error:', error);
              });
          }
        });

        // KP Logo upload
        const kpFileInput = document.getElementById('kplogoInput');
        const kpUploadButton = document.getElementById('uploadKPButton');
        const kpSaveButton = document.getElementById('saveKPButton');
        const kpLogoPreview = document.getElementById('kplogoPreview');

        kpUploadButton.addEventListener('click', function() {
          kpFileInput.click();
        });

        kpFileInput.addEventListener('change', function() {
          const file = this.files[0];
          if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
              kpLogoPreview.setAttribute('src', e.target.result);
            };
            reader.readAsDataURL(file);
          }
        });

        kpSaveButton.addEventListener('click', function() {
          const file = kpFileInput.files[0];
          if (file) {
            const formData = new FormData();
            formData.append('kplogo', file);

            fetch('user_setting.php', {
                method: 'POST',
                body: formData
              })
              .then(response => {
                if (!response.ok) {
                  throw new Error('Network response was not ok.');
                }
                return response.text();
              })
              .then(data => {
                console.log('KP Logo Save successful:', data);
                // Scroll to the "#account-general" section
                document.querySelector("#account-general").scrollIntoView();
              })
              .catch(error => {
                console.error('KP Logo Save Error:', error);
              });
          }
        });
      });
    </script>

  </div>

</body>

</html>