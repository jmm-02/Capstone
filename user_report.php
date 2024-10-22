<?php
session_start();
include 'connection.php';


if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
  header("Location: login.php");
  exit;
}

include 'count_lupon.php';
include 'report_handler.php';

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reports</title>
  
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

      <!--  Row 1 -->
      <div class="row">
        <div class="col-lg-7 d-flex align-items-strech">
          <div class="card w-100">
            <div class="card-body">
              <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                <div class="mb-3 mb-sm-0">

                  <div class="d-flex align-items-center">
                    <img src="img/cluster.png" alt="Logo" style="max-width: 120px; max-height: 120px; margin-right: 10px;" class="align-middle">
                    <div>
                      <h5 class="card-title mb-2 fw-semibold">Department of the Interior and Local Government</h5>
                    </div>
                  </div>

                  <br>

                  <h5 class="card-title mb-9 fw-semibold">Report Overview</h5>
                  <a href="user_add_report.php" class="btn btn-primary">(+) Add existing Report</a>

                  <div class="flex items-center gap-x-2 my-2">
                    <form method="POST">
                      <b><!-- Dropdown to select year -->
                        <div style="display: inline-block;">
                          <label for="selected_year">Select Year:</label>
                          <select name="selected_year" id="selected_year" class="form-select">
                            <?php foreach ($years as $year) : ?>
                              <option value="<?php echo $year['year']; ?>"><?php echo $year['year']; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </b>
                      <input type="submit" class="bg-gray-500 hover:bg-gray-400 px-3 py-2 rounded-md text-white" name="submit_annual" value="Select">
                    </form>
                    <form method="POST">
                      <b>
                        <div style="display: inline-block;">
                          <!-- Dropdown to select month -->
                          <label for="selected_month">Select Month:</label>
                          <select name="selected_month" id="selected_month" class="form-select">
                            <?php foreach ($months as $month) : ?>
                              <option value="<?php echo $month['month_year']; ?>"><?php echo $month['month_year']; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </b>
                      <input type="submit" class="bg-gray-500 hover:bg-gray-400 px-3 py-2 rounded-md text-white" name="submit_monthly" value="Select">
                    </form>
                  </div>

                  <hr>

                  <h5 class="card-title mb-2 fw-semibold">Annual Report (<?php echo isset($selected_year) ? $selected_year : date('F, Y'); ?>)</h5>
                  <hr>
                  <h5 class="card-title mb-2 fw-semibold">Monthly Report (<?php echo isset($selected_month) ? $selected_month : date('F, Y'); ?>)</h5>
                  <hr>

                  <div>

                    <form method="POST">
                      <b>
                        <b>NATURE OF CASES</b>
                        <div class="row">
                          <div class="col-md-3 mb-3">
                            <label for="criminal">Criminal:</label>
                            <input type="number" class="form-control" id="criminal" name="criminal" readonly
                              value="<?php echo ($selected_month && $selected_month !== date('F Y')) ? $s_criminal : $criminalCount; ?>">
                          </div>
                          <div class="col-md-3 mb-3">
                            <label for="civil">Civil:</label>
                            <input type="number" class="form-control" id="civil" name="civil" readonly
                              value="<?php echo ($selected_month && $selected_month !== date('F Y')) ? $s_civil : $civilCount; ?>">
                          </div>
                          <div class="col-md-3 mb-3">
                            <label for="others">Others:</label>
                            <input type="number" class="form-control" id="others" name="others" readonly
                              value="<?php echo ($selected_month && $selected_month !== date('F Y')) ? $s_others : $othersCount; ?>">
                          </div>
                          <div class="col-md-3 mb-3">
                            <label for="totalNature">Total:</label>
                            <input type="number" class="form-control" id="totalNature" name="totalNature" readonly
                              value="<?php echo ($selected_month && $selected_month !== date('F Y')) ? $s_totalNature : $natureSum; ?>">
                          </div>
                        </div>

                        <hr>

                        <b>ACTION TAKEN - SETTLED</b>
                        <div class="row">
                          <div class="col-md-3 mb-3">
                            <label for="mediation">Mediation:</label>
                            <input type="number" class="form-control" id="mediation" name="mediation" readonly
                              value="<?php if ($selected_month && $selected_month !== date('F Y')) {
                                        echo $s_mediation; // Display the selected month's value
                                      } else {
                                        echo $mediationCount;
                                      } ?>">
                          </div>
                          <div class="col-md-3 mb-3">
                            <label for="conciliation">Conciliation:</label>
                            <input type="number" class="form-control" id="conciliation" name="conciliation" readonly
                              value="<?php if ($selected_month && $selected_month !== date('F Y')) {
                                        echo $s_conciliation; // Display the selected month's value
                                      } else {
                                        echo $conciliationCount;
                                      } ?>">
                          </div>
                          <div class="col-md-3 mb-3">
                            <label for="arbit">Arbitration:</label>
                            <input type="number" class="form-control" id="arbit" name="arbit" readonly
                              value="<?php if ($selected_month && $selected_month !== date('F Y')) {
                                        echo $s_arbit; // Display the selected month's value
                                      } else {
                                        echo $arbitrationCount;
                                      } ?>">
                          </div>
                          <div class="col-md-3 mb-3">
                            <label for="totalSet">Total:</label>
                            <input type="number" class="form-control" id="totalSet" name="totalSet" readonly
                              value="<?php if ($selected_month && $selected_month !== date('F Y')) {
                                        echo $s_totalSet; // Display the selected month's value
                                      } else {
                                        echo $totalSettledCount;
                                      } ?>">
                          </div>
                        </div>
                        <hr>

                        <div>


                          <b>ACTION TAKEN - UNSETTLED</b>
                          <div class="row">
                            <div class="col-md-3 mb-3">
                              <label for="pending">Pending:</label>
                              <input type="number" class="form-control" id="pending" name="pending" readonly
                                value="<?php if ($selected_month && $selected_month !== date('F Y')) {
                                          echo $s_pending; // Display the selected month's value
                                        } else {
                                          echo $pendingCount;
                                        } ?>">
                            </div>
                            <div class="col-md-3 mb-3">
                              <label for="dismissed">Dismissed:</label>
                              <input type="number" class="form-control" id="dismissed" name="dismissed" readonly
                                value="<?php if ($selected_month && $selected_month !== date('F Y')) {
                                          echo $s_dismissed; // Display the selected month's value
                                        } else {
                                          echo $dismissedCount;
                                        } ?>">
                            </div>
                            <div class="col-md-3 mb-3">
                              <label for="repudiated">Repudiated:</label>
                              <input type="number" class="form-control" id="repudiated" name="repudiated" readonly
                                value="<?php if ($selected_month && $selected_month !== date('F Y')) {
                                          echo $s_repudiated; // Display the selected month's value
                                        } else {
                                          echo $repudiatedCount;
                                        } ?>">
                            </div>
                            <div class="col-md-3 mb-3">
                              <label for="certified">Certified to Court:</label>
                              <input type="number" class="form-control" id="certified" name="certified" readonly
                                value="<?php if ($selected_month && $selected_month !== date('F Y')) {
                                          echo $s_certified; // Display the selected month's value
                                        } else {
                                          echo $certifiedCount;
                                        } ?>">
                            </div>
                            <div class="col-md-3 mb-3">
                              <label for="dropped">Dropped/Withdrawn:</label>
                              <input type="number" class="form-control" id="dropped" name="dropped" readonly
                                value="<?php if ($selected_month && $selected_month !== date('F Y')) {
                                          echo $s_dropped; // Display the selected month's value
                                        } else {
                                          echo $droppedCount;
                                        } ?>">
                            </div>
                            <div class="col-md-3 mb-3">
                              <label for="totalUnset">Total:</label>
                              <input type="number" class="form-control" id="totalUnset" name="totalUnset" readonly
                                value="<?php if ($selected_month && $selected_month !== date('F Y')) {
                                          echo $s_totalUnset; // Display the selected month's value
                                        } else {
                                          echo $totalUnsetCount;
                                        } ?>">
                            </div>
                          </div>

                          <a href="user_view_report.php" class="btn btn-primary m-1">View Report</a>
                        </div>
                  </div>
                </div>
              </div>

            </div>
          </div></b>

        </div>
        <div class="col-lg-4">
          <div class="row">
            <div class="col-lg-12">
              <div class="card overflow-hidden">
                <div class="card-body p-4">
                  <h5 class="card-title mb-9 fw-semibold">Information</h5>
                  <hr><b>

                    <div class="form-group">
                      <label for="mayor">Mayor:</label>
                      <input type="text" class="form-control" id="mayor" name="mayor"
                        value="<?php if ($selected_month && $selected_month !== date('F Y')) {
                                  echo $s_mayor;
                                } else if ($selected_year && $selected_year !== date('Y')) {
                                  echo $mayor;
                                } else {
                                  echo $mayor;
                                } ?>">
                    </div>
                    <div class="form-group">
                      <label for="region">Region:</label>
                      <input type="text" class="form-control" id="region" name="region"
                        value="<?php if ($selected_month && $selected_month !== date('F Y')) {
                                  echo $s_region;
                                } else if ($selected_year && $selected_year !== date('Y')) {
                                  echo $region;
                                } else {
                                  echo $region;
                                } ?>">
                    </div>
                    <div class="form-group">
                      <label for="budget">Budget Allocated:</label>
                      <input type="text" class="form-control" id="budget" name="budget"
                        value="<?php if ($selected_month && $selected_month !== date('F Y')) {
                                  echo $s_budget;
                                } else if ($selected_year && $selected_year !== date('Y')) {
                                  echo $budget;
                                } else {
                                  echo $budget;
                                } ?>">
                    </div>

                    <div class="form-group">
                      <label for="popul">Population:</label>
                      <input type="text" class="form-control" id="popul" name="population"
                        value="<?php if ($selected_month && $selected_month !== date('F Y')) {
                                  echo $s_population;
                                } else if ($selected_year && $selected_year !== date('Y')) {
                                  echo $population;
                                } else {
                                  echo $population;
                                } ?>">
                    </div>
                    <div class="form-group">
                      <label for="landarea">Land Area:</label>
                      <input type="text" class="form-control" id="landarea" name="landarea"
                        value="<?php if ($selected_month && $selected_month !== date('F Y')) {
                                  echo $s_landarea;
                                } else if ($selected_year && $selected_year !== date('Y')) {
                                  echo $landarea;
                                } else {
                                  echo $landarea;
                                } ?>">
                    </div>

                    <div class="form-group">
                      <label for="totalc">Total No. of Cases:</label>
                      <input type="number" class="form-control" id="totalc" name="totalc" readonly
                        value="<?php if ($selected_month && $selected_month !== date('F Y')) {
                                  echo $s_totalc;
                                } else if ($selected_year && $selected_year !== date('Y')) {
                                  echo $natureSum;
                                } else {
                                  echo $natureSum;
                                } ?>">
                    </div>

                    <div class="form-group">
                      <label for="numlup">Number of Lupons:</label>
                      <input type="number" class="form-control" id="numlup" name="numlup" readonly
                        value="<?php if ($selected_month && $selected_month !== date('F Y')) {
                                  echo $s_numlup;
                                } else if ($selected_year && $selected_year !== date('Y')) {
                                  echo $numlup;
                                } else {
                                  echo $numlup;
                                } ?>">
                    </div>

                    <div class="form-group">
                      <label for="male">Male:</label>
                      <input type="number" class="form-control" id="male" name="male"
                        value="<?php if ($selected_month && $selected_month !== date('F Y')) {
                                  echo $s_male;
                                } else if ($selected_year && $selected_year !== date('Y')) {
                                  echo $male;
                                } else {
                                  echo $male;
                                } ?>">
                    </div>

                    <div class="form-group">
                      <label for="female">Female:</label>
                      <input type="number" class="form-control" id="female" name="female"
                        value="<?php if ($selected_month && $selected_month !== date('F Y')) {
                                  echo $s_female;
                                } else if ($selected_year && $selected_year !== date('Y')) {
                                  echo $female;
                                } else {
                                  echo $female;
                                } ?>">
                    </div><br>
                    <input type="submit" class="bg-gray-500 hover:bg-gray-400 px-3 py-2 rounded-md text-white" name="submit" value="Update">
                    </form>

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