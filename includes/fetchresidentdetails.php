<?php

// Database connection
require_once('connecttodb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $residentId = $_POST['id'];

    // Query to fetch resident details based on the ID
    $query = "SELECT
    `resident`.`resident_id`       AS `resident_id`,
    `res_audit_trail`.`date_added` AS `date_recorded`,
    `resident`.`img_filename`      AS `img_filename`,
    `resident`.`last_name`         AS `last_name`,
    `resident`.`first_name`        AS `first_name`,
    `resident`.`middle_name`       AS `middle_name`,
    `resident`.`suffix`            AS `suffix`,
    `resident`.`house_num`         AS `house_num`,
    `resident`.`street`            AS `street`,
    `resident`.`subdivision`       AS `subdivision`,
    `resident`.`resident_since`    AS `resident_since`,
    `resident`.`sex`               AS `sex`,
    `resident`.`marital_status`    AS `marital_status`,
    `resident`.`birth_date`        AS `birth_date`,
    `resident`.`birth_place`       AS `birth_place`,
    `resident`.`cellphone_num`     AS `cellphone_num`,
    `resident`.`is_a_voter`        AS `is_a_voter`,
    `resident`.`is_deleted`        AS `is_deleted`
    FROM `resident`
    JOIN `res_audit_trail`
        ON `resident`.`audit_trail` = `res_audit_trail`.`res_at_id`
    WHERE `resident`.`resident_id` = ?
    ";
    
    $stmt=$pdo->prepare($query);
    $stmt->execute([$residentId]);

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } else {
        echo json_encode(['error' => 'No resident found']);
    }

    $pdo=null;
}else{
    echo "The server request method is not post!!";
}
