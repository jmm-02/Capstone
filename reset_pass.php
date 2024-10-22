<?php
include 'connection.php';
session_start();
$errors = [];

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
if (!isset($_SESSION['verification_complete']) || !$_SESSION['verification_complete']) {
    // If the verification is not complete, redirect to login or verification page
    header("Location: login.php"); // Redirect to login page
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_SESSION['user_id'];
    $new_password = $_POST['new_password'];

    // Check if the password meets certain criteria (e.g., minimum length)
    if (strlen($new_password) < 8) {
        $errors[] = "Password should be at least 8 characters long.";
    } else {
        // Hash the new password with bcrypt
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        // Update the user's password in the database
        $update_password_query = "UPDATE users SET password = :password WHERE id = :user_id";
        $stmt = $conn->prepare($update_password_query);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':user_id', $userID);
        $result = $stmt->execute();

        if ($result) {
            // Password updated successfully, redirect to login page
            header("Location: login.php");
            exit;
        } else {
            $errors[] = "Failed to update the password. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Reset Password</title>
    <link href="output.css" rel="stylesheet">
</head>

<body class="bg-[#EDF3FC] h-screen w-screen flex items-center justify-center ">

    <div class="bg-red-500 p-3 rounded-md bg-white shadow h-fit w-[30rem] flex flex-col items-center  gap-y-6">
        <h2 class="text-3xl ">Reset Password</h2>
        <?php
        // Display error messages
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p style='color: red;'>$error</p>";
            }
        }
        ?>
        <form class="w-full" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input class="h-[2.5rem] w-full outline-none border border-gray-400 px-2 mb-3" type="password" placeholder="New Password" name="new_password" required><br>
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <input class="w-full bg-blue-500 hover:bg-blue-400 rounded-[10rem] text-xl p-2 font-semibold text-white" type="submit" value="Reset Password">
        </form>
        <a href="forgot_pass.php" class="text-blue-500 w-full">Back to Forgot Password</a>
    </div>

</body>

</html>

<script>
    window.addEventListener('beforeunload', function(event) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'logout.php', false); // Update this URL to match your logout script
        xhr.send();
    });
</script>