
<?php

session_status() == PHP_SESSION_NONE ? session_start() : null;

include 'connection.php';

$userID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// select all funcion
function getAllNotificationData($conn, $userID, $extraCondition = "")
{
    $query = "SELECT * FROM complaints 
          WHERE UserID = :user_id 
          AND CStatus = 'Settled' 
          AND (          /* true if current date is greater than mdate + 15 days */       
              (CMethod = 'Mediation' AND NOW() > DATE_ADD(Mdate, INTERVAL 15 DAY))
              OR 
              (CMethod = 'Conciliation' AND NOW() > DATE_ADD(Mdate, INTERVAL 30 DAY))
          )
          AND isArchived = 0
          AND YEAR(Mdate) = YEAR(NOW())";

    $query .= !empty($extraCondition) ? " AND $extraCondition" : "";

    $query .= " ORDER BY Mdate DESC";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $userID);
    $stmt->execute();
    $temp = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // to make unread notifications in the start
    usort($temp, function($a, $b){
        return $a['seen'] <=> $b['seen'];
    });

    return $temp;

}
$notifData = getAllNotificationData($conn, $userID);


// update function
function updateSeenStatus($conn, $userID, $setFields = "", $extraCondition = "")
{
    $query = "UPDATE complaints ";

    $query .= !empty($setFields) ? "SET $setFields " : "";

    $query .= "WHERE UserID = :user_id 
                AND CStatus = 'Settled' 
                AND (       
                    (CMethod = 'Mediation' AND NOW() > DATE_ADD(Mdate, INTERVAL 15 DAY))
                    OR 
                    (CMethod = 'Conciliation' AND NOW() > DATE_ADD(Mdate, INTERVAL 30 DAY))
                )
                AND isArchived = 0
                AND YEAR(Mdate) = YEAR(NOW())";

    $query .= !empty($extraCondition) ? " AND $extraCondition" : "";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $userID);
    $stmt->execute();
}


// count notification function
function countNotification($arg)
{
    $flag = 0;
    foreach ($arg as $val) {
       $flag = $val['seen'] == 0 ? ++$flag : $flag;
    }
    return $flag;
}
$notifCount = countNotification($notifData);

?>