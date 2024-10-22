<?php
session_start();
include '../connection.php';


if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'superadmin') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LTIA</title>
 
    <link rel="stylesheet" href="../assets/css/styles.min.css" />

</head>

<body class="bg-[#E8E8E7]">
    <!-- Sidebar -->
    <?php include "../sa_sidebar_header.php"; ?>
    <div class="p-4 sm:ml-44">
        <div class="rounded-lg mt-16">

            <p>fgdgf</p>

        </div>
    </div>
</body>

</html>