<?php
session_start();
include '../connection.php';


if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
  header("Location: login.php");
  exit;
}


?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LTIA</title>

  <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="js/tables.js" defer></script>

<body class="bg-[#E8E8E7]">
  <?php include "../user_sidebar_header.php"; ?>
  <div class="p-4 sm:ml-44 ">
    <div class="rounded-lg mt-16">
    <div class="card">
                <div class="card-body">
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center">
                            <div class="dilglogo">
                                <img src="images/dilglogo.png" alt="DILG Logo" class="h-20" /> <!-- Adjusted height here -->
                            </div>
                            <h1 class="text-xl font-bold ml-4">Lupong Tagapamayapa Incentives Award (LTIA)</h1>
                        </div>
                        <div class="menu">
                            <ul class="flex space-x-4">
                            <li>
                            <button class="bg-gray-800 hover:bg-gray-700 px-3 py-2 rounded-md text-white flex items-center" onclick="location.href='form2movview.php';" style="margin-left: 0;">
                    <i class="ti ti-file-upload mr-2"></i> <!-- Icon -->
                    Uploaded File
                  </button>
                        </li>             
                        <li>
                        <button class="bg-gray-800 hover:bg-gray-700 px-3 py-2 rounded-md text-white flex items-center" onclick="location.href='LTIAdashboard.php';" style="margin-left: 0;">
                    <i class="ti ti-arrow-left-dashed mr-2"></i>
                    Back
                        </li>             
                            </ul>
                        </div>
                    </div>
      <h2 class="text-left text-2xl font-semibold">FORM 1</h2>
      <h2 class="custom-h2"> </h2>

      <form method="post" action="form2MOVupload_handler.php" enctype="multipart/form-data">
        <div class="container mt-4">
        <table class="table table-bordered">
            <thead>
              <tr>
                <th>CRITERIA</th>
                <th>Means Of Verification</th>
              </tr>
              <tr>
                <th class="yellow">I. EFFICIENCY IN OPERATION</th>
                <th class="yellow"></th>
              </tr>
              <tr>
                <th>A. Observance of Settlement Procedure and Settlement Deadlines</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><b>1. a) Proper Recording of every dispute/complaint</b></td>
                <td><input type="file" id="IA_1a_pdf_File" name="IA_1a_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>b) Sending of Notices and Summons with complete and accurate information to the parties within the prescribed period (within the next working day upon receipt of complaint)</td>
                <td><input type="file" id="IA_1b_pdf_File" name="IA_1b_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>2. Settlement and Award Period (with at least 10 settled cases within the assessment period)</td>
                <td></td>
              </tr>
               <tr>
                <td>a) Mediation (within 15 days from initial confrontation with the Lupon Chairman)</td>
                <td><input type="file" id="IA_2a_pdf_File" name="IA_2a_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>b) Conciliation (15 days from initial confrontation with the Pangkat)</td>
                <td><input type="file" id="IA_2b_pdf_File" name="IA_2b_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>c) Conciliation (15 days from initial confrontation with the Pangkat)</td>
                <td><input type="file" id="IA_2c_pdf_File" name="IA_2c_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>d) Arbitration (within 10 days from the date of the agreement to arbitrate)</td>
                <td><input type="file" id="IA_2d_pdf_File" name="IA_2d_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>e) Conciliation beyond 46 days but not more than 60 days on a clearly meritorious case</td>
                <td><input type="file" id="IA_2e_pdf_File" name="IA_2e_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <th>B. Systematic Maintenance of Records</th>
                <th></th>
              </tr>
              <tr>
                <td><b>1. Record of Cases </b></td>
                <td></td>
              </tr>
              <tr>
                <td>For Cities - computer database with searchable case information</td>
                <td><input type="file" id="IB_1forcities_pdf_File" name="IB_1forcities_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>For Municipalities:</td>
                <td></td>
              </tr>
              <tr>
                <td>a. Manual Records</td>
                <td><input type="file" id="IB_1aformuni_pdf_File" name="IB_1aformuni_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>b. Digital Record Filing</td>
                <td><input type="file" id="IB_1bformuni_pdf_File" name="IB_1bformuni_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>2. Copies of Minutes of Lupon meetings with attendance sheets and notices</td>
                <td><input type="file" id="IB_2_pdf_File" name="IB_2_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>3. Copies of reports submitted to the Court and to the DILG on file</td>
                <td><input type="file" id="IB_3_pdf_File" name="IB_3_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>4. All records are kept on file in a secured filing cabinet(s)</td>
                <td><input type="file" id="IB_4_pdf_File" name="IB_4_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <th>C. Timely Submissions to the Court and the DILG</th>
                <th></th>
              </tr>
              <tr>
                <td>1. <b>To the Court:</b> Submitted/ presented copies of settlement agreement to the Court from the lapse of the ten-day period repudiating the mediation/ conciliation settlement agreement, or within five (5) calendar days from the date of the arbitration award</td>
                <td><input type="file" id="IC_1_pdf_File" name="IC_1_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>2. To the DILG (Quarterly)</td>
                <td><input type="file" id="IC_2_pdf_File" name="IC_2_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <th>D. Conduct of monthly meetings for administration of the Katarungang Pambarangay (KP)</th>
                <th></th>
              </tr>
              <tr>
                <td>1. Notice of Meeting</td>
                <td><input type="file" id="ID_1_pdf_File" name="ID_1_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>2. Minutes of the Meeting</td>
                <td><input type="file" id="ID_2_pdf_File" name="ID_2_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <th class="yellow">II. EFFECTIVENESS IN SECURING THE SETTLEMENT OF INTERPERSONAL DISPUTE OBJECTIVE OF THE KATARUNGANG PAMBARANGAY</th>
                <th class="yellow"></th>
              </tr>
              <tr>
                <td>A. Quantity of settled cases against filed</td>
                <td><input type="file" id="IIA_pdf_File" name="IIA_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>B. Quality of Settlement of Cases</td>
                <td></td>
              </tr>
              <tr>
                <td>1. Zero cases repudiated</td>
                <td><input type="file" id="IIB_1_pdf_File" name="IIB_1_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>2. Non-recurrence of cases settled</td>
                <td><input type="file" id="IIB_2_pdf_File" name="IIB_2_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>C. At least 80% compliance with the terms of settlement or award after the cases have been settled</td>
                <td><input type="file" id="IIC_pdf_File" name="IIC_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <th class="yellow">III. CREATIVITY AND RESOURCEFULNESS OF THE LUPONG TAGAPAMAYAPA</th>
                <th class="yellow"></th>
              </tr>
              <tr>
                <td>A. Settlement Technique utilized by the Lupon</td>
                <td><input type="file" id="IIIA_pdf_File" name="IIIA_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>B. Coordination with Concerned Agencies relating to disputes filed (PNP, DSWD, DILG, DAR, DENR, Office of the Prosecutor, Court, DOJ, CHR, etc.)</td>
                <td><input type="file" id="IIIB_pdf_File" name="IIIB_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>C. Sustained information drive to promote Katarungang Pambarangay</td>
                <td></td>
              </tr>
              <tr>
                <td>1. For Cities</td>
                <td></td>
              </tr>
              <tr>
                <td>
                  <ul>
                    <li>IEC materials developed</li>
                  </ul>
                </td>
                <td><input type="file" id="IIIC_1forcities_pdf_File" name="IIIC_1forcities_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>
                  <ul>
                    <li>IEC activities conducted</li>
                  </ul>
                </td>
                <td><input type="file" id="IIIC_1forcities2_pdf_File" name="IIIC_1forcities2_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>
                  <ul>
                    <li>Innovative Campaign Strategy</li>
                  </ul>
                </td>
                <td><input type="file" id="IIIC_1forcities3_pdf_File" name="IIIC_1forcities3_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>2. For Municipalities</td>
                <td></td>
              </tr>
              <tr>
                <td>
                  <ul>
                    <li>IEC materials developed</li>
                  </ul>
                </td>
                <td><input type="file" id="IIIC_2formuni1_pdf_File" name="IIIC_2formuni1_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>
                  <ul>
                    <li>IEC activities conducted</li>
                  </ul>
                </td>
                <td><input type="file" id="IIIC_2formuni2_pdf_File" name="IIIC_2formuni2_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>
                  <ul>
                    <li>Innovative Campaign Strategy</li>
                  </ul>
                </td>
                <td><input type="file" id="IIIC_2formuni3_pdf_File" name="IIIC_2formuni3_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>D. KP Training or seminar within the assessment period<br />
                  Organized skills training participated by the Lupong Tagapamayapa</td>
                <td><input type="file" id="IIID_pdf_File" name="IIID_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <th class="yellow">IV. AREA OR FACILITY FOR KP ACTIVITIES</th>
                <th class="yellow"></th>
              </tr>
              <tr>
                <td><b>Building structure or space:</b></td>
                <td></td>
              </tr>
              <tr>
                <td>For Cities - the office or space should be exclusive for KP matters</td>
                <td><input type="file" id="IV_forcities_pdf_File" name="IV_forcities_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>For Municipalities - KP office or space may be shared or used for other Barangay matters.</td>
                <td><input type="file" id="IV_muni_pdf_File" name="IV_muni_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <th class="yellow">V. FINANCIAL OR NON-FINANCIAL SUPPORT</th>
                <th class="yellow"></th>
              </tr>
              <tr>
                <td>1. From City, Municipal, Provincial or NGAs</td>
                <td><input type="file" id="V_1_pdf_File" name="V_1_pdf_File" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
              <tr>
                <td>3 From People's Organizations, NGOs or Private Sector</td>
                <td><input type="file" id="3peoplesorg" name="threepeoplesorg" accept=".pdf" onchange="validateFileType(this)" /></td>
              </tr>
            </tbody>
          </table>
        
          <input type="submit" value="Submit" class="btn btn-dark btn-block mt-5" style="height: 50px; width: 50%; background-color: #000000; color: #ffffff;" />
          </form>
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
    </div>
    </div>
    <style>
      .custom-h2 {
        font-size: 2rem;
        /* Adjust the font size */
        font-weight: bold;
        /* Make the text bold */
        color: #007bff;
        /* Bootstrap primary color (blue) */
        text-align: center;
        /* Center align the heading */
        text-transform: uppercase;
        /* Uppercase the text */
        padding: 10px 0;
        /* Add padding above and below */
        border-bottom: 2px solid #007bff;
        /* Add a blue underline */
        margin-bottom: 20px;
        /* Space below the heading */
      }

      .bg-info {
        background-color: #17a2b8 !important;
        /* Sky blue */
      }

      .table-responsive {
        margin-top: 20px;
      }

      /* Sky Blue for header and subheaders */
      .bg-skyblue {
        background-color: #87CEEB;
        /* Sky blue */
      }

      /* Yellow for Efficiency in Operation */
      .bg-yellow {
        background-color: #FFD700;
        /* Yellow */
      }

      /* Center text and add white color for sky blue headers */
      .text-white {
        color: white;
      }

      .table th,
      .table td {
        vertical-align: middle;
      }
      table tbody tr:hover {
      background-color: #f0f0f0; /* Change this color as desired */
      cursor: pointer; /* Optional: change cursor to pointer when hovering */
    }
    </style>
</body>

</html>