<?php
session_start();

include '../connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
  header("Location: login.php");
  exit;
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Secretaries Corner</title>

  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
  
</head>

<body class="bg-[#E8E8E7]">

  <?php include "../admin_sidebar_header.php"; ?>

  <div class="p-4 sm:ml-44 ">
    <div class="rounded-lg mt-16">
    <div class="card">
    <div class="card-body">
          <div class="flex justify-between items-center mb-4">
            <div class="flex items-center">
              <div class="dilglogo">
              <img src="../img/cluster.png" alt="Logo" style="max-width: 120px; max-height: 120px; margin-right: 10px;" class="align-middle">
              </div>
              <h1 class="text-xl font-bold ml-4">Lupong Tagapamayapa Incentives Award (LTIA)</h1>
            </div>
            <div class="menu">
              <ul class="flex space-x-4">
                <li>
                  <button class="bg-gray-800 hover:bg-gray-700 px-3 py-2 rounded-md text-white flex items-center" onclick="location.href='adminform2evaluate.php';" style="margin-left: 0;">
                  <i class="ti ti-building-community mr-2"> </i> 
                      Barangays
                  </button>
                </li>

              </ul>
            </div>
          </div>


          <footer class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full">
              <path fill="#0099ff" fill-opacity="1" d="M0,224L30,224C60,224,120,224,180,208C240,192,300,160,360,149.3C420,139,480,149,540,160C600,171,660,181,720,154.7C780,128,840,64,900,58.7C960,53,1020,107,1080,117.3C1140,128,1200,96,1260,69.3C1320,43,1380,21,1410,10.7L1440,0L1440,320L1410,320C1380,320,1320,320,1260,320C1200,320,1140,320,1080,320C1020,320,960,320,900,320C840,320,780,320,720,320C660,320,600,320,540,320C480,320,420,320,360,320C300,320,240,320,180,320C120,320,60,320,30,320L0,320Z"></path>
            </svg>
            <div class="absolute right-0 bottom-0 mb-4 mr-4">
              <img src="images/ltialogo.png" alt="LTIA Logo" class="h-20" /> <!-- Adjust height as needed -->
            </div>
          </footer>

        </div>
      </div>
    </div>
  </div>
</body>
      
   

    </div>
  </div>

</body>
</html>
