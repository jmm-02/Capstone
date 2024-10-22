<?php

session_start();
include 'connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'superadmin') {
  header("Location: login.php");
  exit;
}


$alaminos_muni = 'Alaminos';
$bay_muni = 'Bay';
$binan_muni = 'Binan';
$cabuyao_muni = 'Cabuyao';
$calamba_muni = 'Calamba';
$calauan_muni = 'Calauan';
$losbanos_muni = 'Los Baños';
$sanpablo_muni = 'San Pablo';
$sanpedro_muni = 'San Pedro';
$starosa_muni = 'Sta Rosa';

$stmt_munireport_query = "SELECT 
                            --  for criminal count
                              SUM(CASE WHEN municipality = :alaminos THEN criminal ELSE 0 END) AS alaminos_criminal_count,
                              SUM(CASE WHEN municipality = :bay THEN criminal ELSE 0 END) AS bay_criminal_count,    
                              SUM(CASE WHEN municipality = :binan THEN criminal ELSE 0 END) AS binan_criminal_count,
                              SUM(CASE WHEN municipality = :cabuyao THEN criminal ELSE 0 END) AS cabuyao_criminal_count,       
                              SUM(CASE WHEN municipality = :calamba THEN criminal ELSE 0 END) AS calamba_criminal_count,
                              SUM(CASE WHEN municipality = :calauan THEN criminal ELSE 0 END) AS calauan_criminal_count,   
                              SUM(CASE WHEN municipality = :losbanos THEN criminal ELSE 0 END) AS losbanos_criminal_count,
                              SUM(CASE WHEN municipality = :sanpablo THEN criminal ELSE 0 END) AS sanpablo_criminal_count,   
                              SUM(CASE WHEN municipality = :sanpedro THEN criminal ELSE 0 END) AS sanpedro_criminal_count,
                              SUM(CASE WHEN municipality = :starosa THEN criminal ELSE 0 END) AS starosa_criminal_count,  

                            --  for civil count
                              SUM(CASE WHEN municipality = :alaminos THEN civil ELSE 0 END) AS alaminos_civil_count,
                              SUM(CASE WHEN municipality = :bay THEN civil ELSE 0 END) AS bay_civil_count,    
                              SUM(CASE WHEN municipality = :binan THEN civil ELSE 0 END) AS binan_civil_count,
                              SUM(CASE WHEN municipality = :cabuyao THEN civil ELSE 0 END) AS cabuyao_civil_count,       
                              SUM(CASE WHEN municipality = :calamba THEN civil ELSE 0 END) AS calamba_civil_count,
                              SUM(CASE WHEN municipality = :calauan THEN civil ELSE 0 END) AS calauan_civil_count,   
                              SUM(CASE WHEN municipality = :losbanos THEN civil ELSE 0 END) AS losbanos_civil_count,
                              SUM(CASE WHEN municipality = :sanpablo THEN civil ELSE 0 END) AS sanpablo_civil_count,   
                              SUM(CASE WHEN municipality = :sanpedro THEN civil ELSE 0 END) AS sanpedro_civil_count,
                              SUM(CASE WHEN municipality = :starosa THEN civil ELSE 0 END) AS starosa_civil_count, 

                            --  for others count
                              SUM(CASE WHEN municipality = :alaminos THEN others ELSE 0 END) AS alaminos_others_count,
                              SUM(CASE WHEN municipality = :bay THEN others ELSE 0 END) AS bay_others_count,    
                              SUM(CASE WHEN municipality = :binan THEN others ELSE 0 END) AS binan_others_count,
                              SUM(CASE WHEN municipality = :cabuyao THEN others ELSE 0 END) AS cabuyao_others_count,       
                              SUM(CASE WHEN municipality = :calamba THEN others ELSE 0 END) AS calamba_others_count,
                              SUM(CASE WHEN municipality = :calauan THEN others ELSE 0 END) AS calauan_others_count,   
                              SUM(CASE WHEN municipality = :losbanos THEN others ELSE 0 END) AS losbanos_others_count,
                              SUM(CASE WHEN municipality = :sanpablo THEN others ELSE 0 END) AS sanpablo_others_count,   
                              SUM(CASE WHEN municipality = :sanpedro THEN others ELSE 0 END) AS sanpedro_others_count,
                              SUM(CASE WHEN municipality = :starosa THEN others ELSE 0 END) AS starosa_others_count,

                            --  for mediation count
                              SUM(CASE WHEN municipality = :alaminos THEN media ELSE 0 END) AS alaminos_media_count,
                              SUM(CASE WHEN municipality = :bay THEN media ELSE 0 END) AS bay_media_count,    
                              SUM(CASE WHEN municipality = :binan THEN media ELSE 0 END) AS binan_media_count,
                              SUM(CASE WHEN municipality = :cabuyao THEN media ELSE 0 END) AS cabuyao_media_count,       
                              SUM(CASE WHEN municipality = :calamba THEN media ELSE 0 END) AS calamba_media_count,
                              SUM(CASE WHEN municipality = :calauan THEN media ELSE 0 END) AS calauan_media_count,   
                              SUM(CASE WHEN municipality = :losbanos THEN media ELSE 0 END) AS losbanos_media_count,
                              SUM(CASE WHEN municipality = :sanpablo THEN media ELSE 0 END) AS sanpablo_media_count,   
                              SUM(CASE WHEN municipality = :sanpedro THEN media ELSE 0 END) AS sanpedro_media_count,
                              SUM(CASE WHEN municipality = :starosa THEN media ELSE 0 END) AS starosa_media_count,

                            --  for conciliation count
                              SUM(CASE WHEN municipality = :alaminos THEN concil ELSE 0 END) AS alaminos_concil_count,
                              SUM(CASE WHEN municipality = :bay THEN concil ELSE 0 END) AS bay_concil_count,    
                              SUM(CASE WHEN municipality = :binan THEN concil ELSE 0 END) AS binan_concil_count,
                              SUM(CASE WHEN municipality = :cabuyao THEN concil ELSE 0 END) AS cabuyao_concil_count,       
                              SUM(CASE WHEN municipality = :calamba THEN concil ELSE 0 END) AS calamba_concil_count,
                              SUM(CASE WHEN municipality = :calauan THEN concil ELSE 0 END) AS calauan_concil_count,   
                              SUM(CASE WHEN municipality = :losbanos THEN concil ELSE 0 END) AS losbanos_concil_count,
                              SUM(CASE WHEN municipality = :sanpablo THEN concil ELSE 0 END) AS sanpablo_concil_count,   
                              SUM(CASE WHEN municipality = :sanpedro THEN concil ELSE 0 END) AS sanpedro_concil_count,
                              SUM(CASE WHEN municipality = :starosa THEN concil ELSE 0 END) AS starosa_concil_count,

                            --  for arbitration count
                              SUM(CASE WHEN municipality = :alaminos THEN arbit ELSE 0 END) AS alaminos_arbit_count,
                              SUM(CASE WHEN municipality = :bay THEN arbit ELSE 0 END) AS bay_arbit_count,    
                              SUM(CASE WHEN municipality = :binan THEN arbit ELSE 0 END) AS binan_arbit_count,
                              SUM(CASE WHEN municipality = :cabuyao THEN arbit ELSE 0 END) AS cabuyao_arbit_count,       
                              SUM(CASE WHEN municipality = :calamba THEN arbit ELSE 0 END) AS calamba_arbit_count,
                              SUM(CASE WHEN municipality = :calauan THEN arbit ELSE 0 END) AS calauan_arbit_count,   
                              SUM(CASE WHEN municipality = :losbanos THEN arbit ELSE 0 END) AS losbanos_arbit_count,
                              SUM(CASE WHEN municipality = :sanpablo THEN arbit ELSE 0 END) AS sanpablo_arbit_count,   
                              SUM(CASE WHEN municipality = :sanpedro THEN arbit ELSE 0 END) AS sanpedro_arbit_count,
                              SUM(CASE WHEN municipality = :starosa THEN arbit ELSE 0 END) AS starosa_arbit_count,

                            --  for repudiated count
                              SUM(CASE WHEN municipality = :alaminos THEN repudiated ELSE 0 END) AS alaminos_repudiated_count,
                              SUM(CASE WHEN municipality = :bay THEN repudiated ELSE 0 END) AS bay_repudiated_count,    
                              SUM(CASE WHEN municipality = :binan THEN repudiated ELSE 0 END) AS binan_repudiated_count,
                              SUM(CASE WHEN municipality = :cabuyao THEN repudiated ELSE 0 END) AS cabuyao_repudiated_count,       
                              SUM(CASE WHEN municipality = :calamba THEN repudiated ELSE 0 END) AS calamba_repudiated_count,
                              SUM(CASE WHEN municipality = :calauan THEN repudiated ELSE 0 END) AS calauan_repudiated_count,   
                              SUM(CASE WHEN municipality = :losbanos THEN repudiated ELSE 0 END) AS losbanos_repudiated_count,
                              SUM(CASE WHEN municipality = :sanpablo THEN repudiated ELSE 0 END) AS sanpablo_repudiated_count,   
                              SUM(CASE WHEN municipality = :sanpedro THEN repudiated ELSE 0 END) AS sanpedro_repudiated_count,
                              SUM(CASE WHEN municipality = :starosa THEN repudiated ELSE 0 END) AS starosa_repudiated_count,

                            --  for dropped count
                              SUM(CASE WHEN municipality = :alaminos THEN dropped ELSE 0 END) AS alaminos_dropped_count,
                              SUM(CASE WHEN municipality = :bay THEN dropped ELSE 0 END) AS bay_dropped_count,    
                              SUM(CASE WHEN municipality = :binan THEN dropped ELSE 0 END) AS binan_dropped_count,
                              SUM(CASE WHEN municipality = :cabuyao THEN dropped ELSE 0 END) AS cabuyao_dropped_count,       
                              SUM(CASE WHEN municipality = :calamba THEN dropped ELSE 0 END) AS calamba_dropped_count,
                              SUM(CASE WHEN municipality = :calauan THEN dropped ELSE 0 END) AS calauan_dropped_count,   
                              SUM(CASE WHEN municipality = :losbanos THEN dropped ELSE 0 END) AS losbanos_dropped_count,
                              SUM(CASE WHEN municipality = :sanpablo THEN dropped ELSE 0 END) AS sanpablo_dropped_count,   
                              SUM(CASE WHEN municipality = :sanpedro THEN dropped ELSE 0 END) AS sanpedro_dropped_count,
                              SUM(CASE WHEN municipality = :starosa THEN dropped ELSE 0 END) AS starosa_dropped_count,
            
                            --  for pending count
                              SUM(CASE WHEN municipality = :alaminos THEN pending ELSE 0 END) AS alaminos_pending_count,
                              SUM(CASE WHEN municipality = :bay THEN pending ELSE 0 END) AS bay_pending_count,    
                              SUM(CASE WHEN municipality = :binan THEN pending ELSE 0 END) AS binan_pending_count,
                              SUM(CASE WHEN municipality = :cabuyao THEN pending ELSE 0 END) AS cabuyao_pending_count,       
                              SUM(CASE WHEN municipality = :calamba THEN pending ELSE 0 END) AS calamba_pending_count,
                              SUM(CASE WHEN municipality = :calauan THEN pending ELSE 0 END) AS calauan_pending_count,   
                              SUM(CASE WHEN municipality = :losbanos THEN pending ELSE 0 END) AS losbanos_pending_count,
                              SUM(CASE WHEN municipality = :sanpablo THEN pending ELSE 0 END) AS sanpablo_pending_count,   
                              SUM(CASE WHEN municipality = :sanpedro THEN pending ELSE 0 END) AS sanpedro_pending_count,
                              SUM(CASE WHEN municipality = :starosa THEN pending ELSE 0 END) AS starosa_pending_count,

                             --  for dismissed count
                              SUM(CASE WHEN municipality = :alaminos THEN dismissed ELSE 0 END) AS alaminos_dismissed_count,
                              SUM(CASE WHEN municipality = :bay THEN dismissed ELSE 0 END) AS bay_dismissed_count,    
                              SUM(CASE WHEN municipality = :binan THEN dismissed ELSE 0 END) AS binan_dismissed_count,
                              SUM(CASE WHEN municipality = :cabuyao THEN dismissed ELSE 0 END) AS cabuyao_dismissed_count,       
                              SUM(CASE WHEN municipality = :calamba THEN dismissed ELSE 0 END) AS calamba_dismissed_count,
                              SUM(CASE WHEN municipality = :calauan THEN dismissed ELSE 0 END) AS calauan_dismissed_count,   
                              SUM(CASE WHEN municipality = :losbanos THEN dismissed ELSE 0 END) AS losbanos_dismissed_count,
                              SUM(CASE WHEN municipality = :sanpablo THEN dismissed ELSE 0 END) AS sanpablo_dismissed_count,   
                              SUM(CASE WHEN municipality = :sanpedro THEN dismissed ELSE 0 END) AS sanpedro_dismissed_count,
                              SUM(CASE WHEN municipality = :starosa THEN dismissed ELSE 0 END) AS starosa_dismissed_count,

                            --  for certcourt count
                              SUM(CASE WHEN municipality = :alaminos THEN certcourt ELSE 0 END) AS alaminos_certcourt_count,
                              SUM(CASE WHEN municipality = :bay THEN certcourt ELSE 0 END) AS bay_certcourt_count,    
                              SUM(CASE WHEN municipality = :binan THEN certcourt ELSE 0 END) AS binan_certcourt_count,
                              SUM(CASE WHEN municipality = :cabuyao THEN certcourt ELSE 0 END) AS cabuyao_certcourt_count,       
                              SUM(CASE WHEN municipality = :calamba THEN certcourt ELSE 0 END) AS calamba_certcourt_count,
                              SUM(CASE WHEN municipality = :calauan THEN certcourt ELSE 0 END) AS calauan_certcourt_count,   
                              SUM(CASE WHEN municipality = :losbanos THEN certcourt ELSE 0 END) AS losbanos_certcourt_count,
                              SUM(CASE WHEN municipality = :sanpablo THEN certcourt ELSE 0 END) AS sanpablo_certcourt_count,   
                              SUM(CASE WHEN municipality = :sanpedro THEN certcourt ELSE 0 END) AS sanpedro_certcourt_count,
                              SUM(CASE WHEN municipality = :starosa THEN certcourt ELSE 0 END) AS starosa_certcourt_count,

                            --  for outside brgy count
                              SUM(CASE WHEN municipality = :alaminos THEN outsideBrgy ELSE 0 END) AS alaminos_outsideBrgy_count,
                              SUM(CASE WHEN municipality = :bay THEN outsideBrgy ELSE 0 END) AS bay_outsideBrgy_count,    
                              SUM(CASE WHEN municipality = :binan THEN outsideBrgy ELSE 0 END) AS binan_outsideBrgy_count,
                              SUM(CASE WHEN municipality = :cabuyao THEN outsideBrgy ELSE 0 END) AS cabuyao_outsideBrgy_count,       
                              SUM(CASE WHEN municipality = :calamba THEN outsideBrgy ELSE 0 END) AS calamba_outsideBrgy_count,
                              SUM(CASE WHEN municipality = :calauan THEN outsideBrgy ELSE 0 END) AS calauan_outsideBrgy_count,   
                              SUM(CASE WHEN municipality = :losbanos THEN outsideBrgy ELSE 0 END) AS losbanos_outsideBrgy_count,
                              SUM(CASE WHEN municipality = :sanpablo THEN outsideBrgy ELSE 0 END) AS sanpablo_outsideBrgy_count,   
                              SUM(CASE WHEN municipality = :sanpedro THEN outsideBrgy ELSE 0 END) AS sanpedro_outsideBrgy_count,
                              SUM(CASE WHEN municipality = :starosa THEN outsideBrgy ELSE 0 END) AS starosa_outsideBrgy_count,

                             --  for budget count
                              SUM(CASE WHEN municipality = :alaminos THEN budget ELSE 0 END) AS alaminos_budget_count,
                              SUM(CASE WHEN municipality = :bay THEN budget ELSE 0 END) AS bay_budget_count,    
                              SUM(CASE WHEN municipality = :binan THEN budget ELSE 0 END) AS binan_budget_count,
                              SUM(CASE WHEN municipality = :cabuyao THEN budget ELSE 0 END) AS cabuyao_budget_count,       
                              SUM(CASE WHEN municipality = :calamba THEN budget ELSE 0 END) AS calamba_budget_count,
                              SUM(CASE WHEN municipality = :calauan THEN budget ELSE 0 END) AS calauan_budget_count,   
                              SUM(CASE WHEN municipality = :losbanos THEN budget ELSE 0 END) AS losbanos_budget_count,
                              SUM(CASE WHEN municipality = :sanpablo THEN budget ELSE 0 END) AS sanpablo_budget_count,   
                              SUM(CASE WHEN municipality = :sanpedro THEN budget ELSE 0 END) AS sanpedro_budget_count,
                              SUM(CASE WHEN municipality = :starosa THEN budget ELSE 0 END) AS starosa_budget_count




                          FROM reports
                          WHERE municipality IN (:alaminos, :bay, :binan, :cabuyao, :calamba, :calauan, :losbanos, :sanpablo, :sanpedro, :starosa) AND YEAR(report_date) = YEAR(NOW())";

$stmt_munireport = $conn->prepare($stmt_munireport_query);
$stmt_munireport->bindParam(':alaminos', $alaminos_muni);
$stmt_munireport->bindParam(':bay', $bay_muni);
$stmt_munireport->bindParam(':binan', $binan_muni);
$stmt_munireport->bindParam(':cabuyao', $cabuyao_muni);
$stmt_munireport->bindParam(':calamba', $calamba_muni);
$stmt_munireport->bindParam(':calauan', $calauan_muni);
$stmt_munireport->bindParam(':losbanos', $losbanos_muni);
$stmt_munireport->bindParam(':sanpablo', $sanpablo_muni);
$stmt_munireport->bindParam(':sanpedro', $sanpedro_muni);
$stmt_munireport->bindParam(':starosa', $starosa_muni);
$stmt_munireport->execute();
$temp = $stmt_munireport->fetch(PDO::FETCH_ASSOC);

$criminalCountArray = [
  $temp['alaminos_criminal_count'],
  $temp['bay_criminal_count'],
  $temp['binan_criminal_count'],
  $temp['cabuyao_criminal_count'],
  $temp['calamba_criminal_count'],
  $temp['calauan_criminal_count'],
  $temp['losbanos_criminal_count'],
  $temp['sanpablo_criminal_count'],
  $temp['sanpedro_criminal_count'],
  $temp['starosa_criminal_count'],
];

$civilCountArray = [
  $temp['alaminos_civil_count'],
  $temp['bay_civil_count'],
  $temp['binan_civil_count'],
  $temp['cabuyao_civil_count'],
  $temp['calamba_civil_count'],
  $temp['calauan_civil_count'],
  $temp['losbanos_civil_count'],
  $temp['sanpablo_civil_count'],
  $temp['sanpedro_civil_count'],
  $temp['starosa_civil_count'],
];

$othersCountArray = [
  $temp['alaminos_others_count'],
  $temp['bay_others_count'],
  $temp['binan_others_count'],
  $temp['cabuyao_others_count'],
  $temp['calamba_others_count'],
  $temp['calauan_others_count'],
  $temp['losbanos_others_count'],
  $temp['sanpablo_others_count'],
  $temp['sanpedro_others_count'],
  $temp['starosa_others_count'],
];

$totalCountArray1 = [
  $temp['alaminos_criminal_count'] + $temp['alaminos_civil_count'] + $temp['alaminos_others_count'],
  $temp['bay_criminal_count'] + $temp['bay_civil_count'] + $temp['bay_others_count'],
  $temp['binan_criminal_count'] + $temp['binan_civil_count'] + $temp['binan_others_count'],
  $temp['cabuyao_criminal_count'] + $temp['cabuyao_civil_count'] + $temp['cabuyao_others_count'],
  $temp['calamba_criminal_count'] + $temp['calamba_civil_count'] + $temp['calamba_others_count'],
  $temp['calauan_criminal_count'] + $temp['calauan_civil_count'] + $temp['calauan_others_count'],
  $temp['losbanos_criminal_count'] + $temp['losbanos_civil_count'] + $temp['losbanos_others_count'],
  $temp['sanpablo_criminal_count'] + $temp['sanpablo_civil_count'] + $temp['sanpablo_others_count'],
  $temp['sanpedro_criminal_count'] + $temp['sanpedro_civil_count'] + $temp['sanpedro_others_count'],
  $temp['starosa_criminal_count'] + $temp['starosa_civil_count'] + $temp['starosa_others_count'],
];

$mediationCountArray = [
  $temp['alaminos_media_count'],
  $temp['bay_media_count'],
  $temp['binan_media_count'],
  $temp['cabuyao_media_count'],
  $temp['calamba_media_count'],
  $temp['calauan_media_count'],
  $temp['losbanos_media_count'],
  $temp['sanpablo_media_count'],
  $temp['sanpedro_media_count'],
  $temp['starosa_media_count'],
];

$conciliationCountArray = [
  $temp['alaminos_concil_count'],
  $temp['bay_concil_count'],
  $temp['binan_concil_count'],
  $temp['cabuyao_concil_count'],
  $temp['calamba_concil_count'],
  $temp['calauan_concil_count'],
  $temp['losbanos_concil_count'],
  $temp['sanpablo_concil_count'],
  $temp['sanpedro_concil_count'],
  $temp['starosa_concil_count'],
];

$arbitrationCountArray = [
  $temp['alaminos_arbit_count'],
  $temp['bay_arbit_count'],
  $temp['binan_arbit_count'],
  $temp['cabuyao_arbit_count'],
  $temp['calamba_arbit_count'],
  $temp['calauan_arbit_count'],
  $temp['losbanos_arbit_count'],
  $temp['sanpablo_arbit_count'],
  $temp['sanpedro_arbit_count'],
  $temp['starosa_arbit_count'],
];

$totalCountArray2 = [
  $temp['alaminos_media_count'] + $temp['alaminos_concil_count'] + $temp['alaminos_arbit_count'],
  $temp['bay_media_count'] + $temp['bay_concil_count'] + $temp['bay_arbit_count'],
  $temp['binan_media_count'] + $temp['binan_concil_count'] + $temp['binan_arbit_count'],
  $temp['cabuyao_media_count'] + $temp['cabuyao_concil_count'] + $temp['cabuyao_arbit_count'],
  $temp['calamba_media_count'] + $temp['calamba_concil_count'] + $temp['calamba_arbit_count'],
  $temp['calauan_media_count'] + $temp['calauan_concil_count'] + $temp['calauan_arbit_count'],
  $temp['losbanos_media_count'] + $temp['losbanos_concil_count'] + $temp['losbanos_arbit_count'],
  $temp['sanpablo_media_count'] + $temp['sanpablo_concil_count'] + $temp['sanpablo_arbit_count'],
  $temp['sanpedro_media_count'] + $temp['sanpedro_concil_count'] + $temp['sanpedro_arbit_count'],
  $temp['starosa_media_count'] + $temp['starosa_concil_count'] + $temp['starosa_arbit_count'],
];

$repudiatedCountArray = [
  $temp['alaminos_repudiated_count'],
  $temp['bay_repudiated_count'],
  $temp['binan_repudiated_count'],
  $temp['cabuyao_repudiated_count'],
  $temp['calamba_repudiated_count'],
  $temp['calauan_repudiated_count'],
  $temp['losbanos_repudiated_count'],
  $temp['sanpablo_repudiated_count'],
  $temp['sanpedro_repudiated_count'],
  $temp['starosa_repudiated_count'],
];

$droppedCountArray = [
  $temp['alaminos_dropped_count'],
  $temp['bay_dropped_count'],
  $temp['binan_dropped_count'],
  $temp['cabuyao_dropped_count'],
  $temp['calamba_dropped_count'],
  $temp['calauan_dropped_count'],
  $temp['losbanos_dropped_count'],
  $temp['sanpablo_dropped_count'],
  $temp['sanpedro_dropped_count'],
  $temp['starosa_dropped_count'],
];

$pendingCountArray = [
  $temp['alaminos_pending_count'],
  $temp['bay_pending_count'],
  $temp['binan_pending_count'],
  $temp['cabuyao_pending_count'],
  $temp['calamba_pending_count'],
  $temp['calauan_pending_count'],
  $temp['losbanos_pending_count'],
  $temp['sanpablo_pending_count'],
  $temp['sanpedro_pending_count'],
  $temp['starosa_pending_count'],
];

$dismissedCountArray = [
  $temp['alaminos_dismissed_count'],
  $temp['bay_dismissed_count'],
  $temp['binan_dismissed_count'],
  $temp['cabuyao_dismissed_count'],
  $temp['calamba_dismissed_count'],
  $temp['calauan_dismissed_count'],
  $temp['losbanos_dismissed_count'],
  $temp['sanpablo_dismissed_count'],
  $temp['sanpedro_dismissed_count'],
  $temp['starosa_dismissed_count'],
];

$certcourtCountArray = [
  $temp['alaminos_certcourt_count'],
  $temp['bay_certcourt_count'],
  $temp['binan_certcourt_count'],
  $temp['cabuyao_certcourt_count'],
  $temp['calamba_certcourt_count'],
  $temp['calauan_certcourt_count'],
  $temp['losbanos_certcourt_count'],
  $temp['sanpablo_certcourt_count'],
  $temp['sanpedro_certcourt_count'],
  $temp['starosa_certcourt_count'],
];

$outsideBrgyCountArray = [
  $temp['alaminos_outsideBrgy_count'],
  $temp['bay_outsideBrgy_count'],
  $temp['binan_outsideBrgy_count'],
  $temp['cabuyao_outsideBrgy_count'],
  $temp['calamba_outsideBrgy_count'],
  $temp['calauan_outsideBrgy_count'],
  $temp['losbanos_outsideBrgy_count'],
  $temp['sanpablo_outsideBrgy_count'],
  $temp['sanpedro_outsideBrgy_count'],
  $temp['starosa_outsideBrgy_count'],
];

$totalCountArray3 = [
  $temp['alaminos_repudiated_count'] + $temp['alaminos_dropped_count'] + $temp['alaminos_pending_count'] +
  $temp['alaminos_dismissed_count'] + $temp['alaminos_certcourt_count'] + $temp['alaminos_outsideBrgy_count'],

  $temp['bay_repudiated_count'] + $temp['bay_dropped_count'] + $temp['bay_pending_count'] +
  $temp['bay_dismissed_count'] + $temp['bay_certcourt_count'] + $temp['bay_outsideBrgy_count'],

  $temp['binan_repudiated_count'] + $temp['binan_dropped_count'] + $temp['binan_pending_count'] +
  $temp['binan_dismissed_count'] + $temp['binan_certcourt_count'] + $temp['binan_outsideBrgy_count'],

  $temp['cabuyao_repudiated_count'] + $temp['cabuyao_dropped_count'] + $temp['cabuyao_pending_count'] +
  $temp['cabuyao_dismissed_count'] + $temp['cabuyao_certcourt_count'] + $temp['cabuyao_outsideBrgy_count'],

  $temp['calamba_repudiated_count'] + $temp['calamba_dropped_count'] + $temp['calamba_pending_count'] +
  $temp['calamba_dismissed_count'] + $temp['calamba_certcourt_count'] + $temp['calamba_outsideBrgy_count'],

  $temp['calauan_repudiated_count'] + $temp['calauan_dropped_count'] + $temp['calauan_pending_count'] +
  $temp['calauan_dismissed_count'] + $temp['calauan_certcourt_count'] + $temp['calauan_outsideBrgy_count'],

  $temp['losbanos_repudiated_count'] + $temp['losbanos_dropped_count'] + $temp['losbanos_pending_count'] +
  $temp['losbanos_dismissed_count'] + $temp['losbanos_certcourt_count'] + $temp['losbanos_outsideBrgy_count'],

  $temp['sanpablo_repudiated_count'] + $temp['sanpablo_dropped_count'] + $temp['sanpablo_pending_count'] +
  $temp['sanpablo_dismissed_count'] + $temp['sanpablo_certcourt_count'] + $temp['sanpablo_outsideBrgy_count'],

  $temp['sanpedro_repudiated_count'] + $temp['sanpedro_dropped_count'] + $temp['sanpedro_pending_count'] +
  $temp['sanpedro_dismissed_count'] + $temp['sanpedro_certcourt_count'] + $temp['sanpedro_outsideBrgy_count'],

  $temp['starosa_repudiated_count'] + $temp['starosa_dropped_count'] + $temp['starosa_pending_count'] +
  $temp['starosa_dismissed_count'] + $temp['starosa_certcourt_count'] + $temp['starosa_outsideBrgy_count'],
];

$budgetCountArray = [
  $temp['alaminos_budget_count'],
  $temp['bay_budget_count'],
  $temp['binan_budget_count'],
  $temp['cabuyao_budget_count'],
  $temp['calamba_budget_count'],
  $temp['calauan_budget_count'],
  $temp['losbanos_budget_count'],
  $temp['sanpablo_budget_count'],
  $temp['sanpedro_budget_count'],
  $temp['starosa_budget_count'],
];

?>








<!DOCTYPE html>
<html lang="en">

<head>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
  <link rel="icon" type="image/x-icon" href="img/favicon.ico">

  <script>
    function generatePDF() {
      var element = document.querySelector('table');
      var additionalContent = `
           
        `;

      // Create a new window with the combined content
      var newWindow = window.open('', '_blank');
      newWindow.document.write('<html><head><title>PDF</title></head><body>' + element.outerHTML + additionalContent + '</body></html>');
      newWindow.document.close();

      // Use html2pdf library to generate PDF
      html2pdf(newWindow.document.body, {
        margin: 10,
        filename: 'table_' + getFormattedDate() + '.pdf',
        jsPDF: {
          unit: 'mm',
          format: 'a4',
          orientation: 'landscape'
        }
      });

      // Close the new window
      newWindow.close();
    }

    // Function to download table as Excel
    function downloadExcel() {
      var element = document.querySelector('table');

      // Use xlsx library to generate Excel file
      var wb = XLSX.utils.table_to_book(element);
      var wbout = XLSX.write(wb, {
        bookType: 'xlsx',
        bookSST: true,
        type: 'binary'
      });

      // Convert string to ArrayBuffer
      function s2ab(s) {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
        return buf;
      }

      // Create Blob and trigger download
      var blob = new Blob([s2ab(wbout)], {
        type: 'application/octet-stream'
      });
      saveAs(blob, 'table_' + getFormattedDate() + '.xlsx');
    }

    // Function to adjust table styles for PDF generation
    function adjustTableStyles(table) {
      // Store original styles
      table.setAttribute('data-original-style', table.getAttribute('style') || '');

      // Set new styles for PDF generation
      table.style.fontSize = '6pt'; // Adjust font size
      table.style.width = '100%'; // Adjust table width
      // Add more style adjustments as needed
    }

    // Function to restore original table styles
    function restoreTableStyles(table) {
      // Restore original styles
      var originalStyle = table.getAttribute('data-original-style');
      table.setAttribute('style', originalStyle);
    }

    // Function to get the current date and time in a formatted string
    function getFormattedDate() {
      var now = new Date();
      var year = now.getFullYear();
      var month = ('0' + (now.getMonth() + 1)).slice(-2);
      var day = ('0' + now.getDate()).slice(-2);

      return year + month + day + '_';
    }
  </script>

  <style>
    h1 {
      text-align: center;
      font-family: Arial, sans-serif;
      font-size: 14pt;
      margin-bottom: 10px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    table,
    th,
    td {
      border: 1px solid black;
    }

    th,
    td {
      padding: 5px;
      text-align: center;
      white-space: nowrap;
      /* Prevent text wrapping */
    }

    table {
      width: 100%;
      max-width: 100%;
      /* Set max-width to 100% */
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    @media print {
      /* ... existing styles ... */

      table {
        width: 50%;
        font-size: 4pt;
        /* Adjust font size for printing */
      }

      th,
      td {
        padding: 2px;
        /* Adjust padding for printing */
      }

      td[colspan="4"] {
        white-space: normal;
        /* Allow text wrapping for specific cells */
      }

      @page {
        size: A4 landscape;
      }
    }
  </style>
</head>

<body>
  <b>
    <table>

      <h1> CONSOLIDATED KATARUNGANG PAMBARANGAY COMPLIANCE REPORT ON THE ACTION TAKEN BY THE LUPONG TAGAPAMAYAPA CY <?php echo date('Y'); ?>
      </h1>

      <tr>
        <td rowspan="3"> PROVINCE <br> CITY </td>
        <td rowspan="4" colspan="1"> C/M </td>
        <td rowspan="2" colspan="4"> NATURE OF DISPUTES (2) </td>
      </tr>
      <tr>
        <td colspan="4">SETTLED CASES (3)</td>
        <td colspan="8">UNSETTLED CASES (4)</td>
      </tr>
      <tr>
        <td colspan="1">CRIMI <br> NAL </td>
        <td colspan="1"> CIVIL </td>
        <td colspan="1">OTHERS </td>
        <td colspan="1">TOTAL </td>
        <td colspan="1">MEDIA <br> TION </td>
        <td colspan="1">CONCIL<br>IATION </td>
        <td colspan="1">ARBIT<br>RATION </td>
        <td colspan="1">TOTAL </td>
        <td colspan="1">REPUD<br>IATED </td>
        <td colspan="1">DROP<br>PED</td>
        <td colspan="1">PEND<br>ING </td>
        <td colspan="1">DIS<br>MISSED </td>
        <td colspan="1">CERTIFIED <br> TO FILE <br> ACTION IN <br> COURT </td>
        <td colspan="1"> REFER <br> ED TO <br> CONCER <br> NED <br> AGENCY </td>
        <td colspan="1">TOTAL </td>
        <td colspan="1" rowspan="2">ESTIMA <br> TED <br> GOVT. <br> SAVINGS <br> (5) </td>
      </tr>

      <tr>
        <td colspan="1"> (1) </td>
        <td colspan="1"> (2a) </td>
        <td colspan="1"> (2b) </td>
        <td colspan="1"> (2c) </td>
        <td colspan="1"> (2d) </td>
        <td colspan="1"> (3a) </td>
        <td colspan="1"> (3b) </td>
        <td colspan="1"> (3c) </td>
        <td colspan="1"> (3d) </td>
        <td colspan="1"> (4a)</td>
        <td colspan="1"> (4b) </td>
        <td colspan="1"> (4c) </td>
        <td colspan="1"> (4d) </td>
        <td colspan="1"> (4e) </td>
        <td colspan="1"> (4f) </td>
        <td colspan="1"> (4g) </td>
      </tr>
      <?php

      $municipalities = array(
        "ALAMINOS",
        "BAY",
        "CALAUAN",
        "LOS BAÑOS",
        "CABUYAO",
        "BIÑAN",
        "CALAMBA",
        "SAN PABLO",
        "SAN PEDRO",
        "SANTA ROSA"
      );

      for ($i = 0; $i < 10; $i++) :
      ?>
        <tr>
          <td colspan="1"> </td>
          <td colspan="1"><?php echo $municipalities[$i]; ?></td>
          <td colspan="1"><?php echo $criminalCountArray[$i]; ?></td>
          <td colspan="1"><?php echo $civilCountArray[$i]; ?></td>
          <td colspan="1"><?php echo $othersCountArray[$i]; ?></td>
          <td colspan="1"><?php echo $totalCountArray1[$i]; ?></td>
          <td colspan="1"><?php echo $mediationCountArray[$i]; ?></td>
          <td colspan="1"><?php echo $conciliationCountArray[$i]; ?></td>
          <td colspan="1"><?php echo $arbitrationCountArray[$i]; ?></td>
          <td colspan="1"><?php echo $totalCountArray2[$i]; ?></td>
          <td colspan="1"><?php echo $repudiatedCountArray[$i]; ?></td>
          <td colspan="1"><?php echo $droppedCountArray[$i]; ?></td>
          <td colspan="1"><?php echo $pendingCountArray[$i]; ?></td>
          <td colspan="1"><?php echo $dismissedCountArray[$i]; ?></td>
          <td colspan="1"><?php echo $certcourtCountArray[$i]; ?></td>
          <td colspan="1"><?php echo $outsideBrgyCountArray[$i]; ?></td> 
          <td colspan="1"><?php echo $totalCountArray3[$i]; ?></td>
          <td colspan="1"><?php echo number_format($budgetCountArray[$i]); ?></td>
        </tr>
      <?php endfor; ?>
    </table>

    <button onclick="generatePDF()">Generate PDF</button>
    <button onclick="downloadExcel()">Download Excel</button>
</body>

</html>