<?php
    session_start();
    require_once '_db.php';

    $eid = $_SESSION['stud_id'];
    $aid = 1;
    $pending = "Pending";

    $query = "SELECT * FROM ENROLLMENT WHERE STUD_ID = ?;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$eid]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row) {
        $query = "UPDATE ENROLLMENT SET EN_APPROVAL = 'Pending' WHERE STUD_ID = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$eid]);
    }
    else {
        $query = "INSERT INTO ENROLLMENT (EN_APPROVAL, STUD_ID, ADMIN_ID)
        VALUES (:APPROVAL, :ID, :AID);";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":APPROVAL", $pending);
        $stmt->bindParam(":ID", $eid);
        $stmt->bindParam(":AID", $aid);

        $stmt->execute([$pending, $eid, $aid]);
    }
    
    echo "\<script type='text/javascript'> ";
    echo "window.location.href='studentDashboard.php';";  
    echo "</script>";