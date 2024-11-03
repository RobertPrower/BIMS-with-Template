<?php 
require_once'connecttodb.php';

$operation_check = (isset($_POST['operation']))? $_POST['operation']: null;

$main_complainantid = isset($_POST['main_complainantid'])?$_POST['main_complainantid']: null; 
$main_complainant_status = isset($_POST['main_complainant_status'])?$_POST['main_complainant_status']: null;
$main_respondentid = isset($_POST['main_respondentid'])?$_POST['main_respondentid']: null;
$main_respondent_status = isset($_POST['main_respondent_status'])?$_POST['main_respondent_status']: null;;
$other_nonresident_complainant1 = isset($_POST['other_nonresident_complainant1'])?$_POST['other_nonresident_complainant1']: null;
$other_nonresident_complainant2 = isset($_POST['other_nonresident_complainant2'])?$_POST['other_nonresident_complainant2']: null;
$other_nonresident_complainant3 = isset($_POST['other_nonresident_complainant3'])?$_POST['other_nonresident_complainant3']: null; 
$other_nonresident_complainant4 = isset($_POST['other_nonresident_complainant4'])?$_POST['other_nonresident_complainant4']: null; 
$other_nonresident_complainant5 = isset($_POST['other_nonresident_complainant5'])?$_POST['other_nonresident_complainant5']: null;
$other_nonresident_respondent1 = isset($_POST['other_nonresident_respondent1'])?$_POST['other_nonresident_respondent1']: null;
$other_nonresident_respondent2 = isset($_POST['other_nonresident_respondent2'])?$_POST['other_nonresident_respondent2']: null;
$other_nonresident_respondent3 = isset($_POST['other_nonresident_respondent3'])?$_POST['other_nonresident_respondent3']: null;
$other_nonresident_respondent4 = isset($_POST['other_nonresident_respondent4'])?$_POST['other_nonresident_respondent4']: null;
$other_nonresident_respondent5 = isset($_POST['other_nonresident_respondent5'])?$_POST['other_nonresident_respondent5']: null;
$other_resident_complainant1 = isset($_POST['other_resident_complainant1'])?$_POST['other_resident_complainant1']: null;
$other_resident_complainant2 = isset($_POST['other_resident_complainant2'])?$_POST['other_nonresident_respondent2']: null; 
$other_resident_complainant3= isset($_POST['other_resident_complainant3'])?$_POST['other_nonresident_respondent3']: null;
$other_resident_complainant4 = isset($_POST['other_resident_complainant4'])?$_POST['other_nonresident_respondent4']: null; 
$other_resident_complainant5 = isset($_POST['other_resident_complainant5'])?$_POST['other_nonresident_respondent5']: null;;
$other_resident_respondent1 = isset($_POST['other_resident_respondent1'])?$_POST['other_resident_respondent1']: null;
$other_resident_respondent2 = isset($_POST['other_resident_respondent2'])?$_POST['other_resident_respondent2']: null;
$other_resident_respondent3 = isset($_POST['other_resident_respondent3'])?$_POST['other_resident_respondent3']: null;
$other_resident_respondent4 = isset($_POST['other_resident_respondent4'])?$_POST['other_resident_respondent4']: null;
$other_resident_respondent5 = isset($_POST['other_resident_respondent5'])?$_POST['other_resident_respondent5']: null;

$schedule_date = isset($_POST['schedule_date'])?$_POST['schedule_date']: null;
$schedule_starttime = isset($_POST['schedule_starttime'])?$_POST['schedule_starttime']: null;
$schedule_endtime = isset($_POST['schedule_endtime'])?$_POST['schedule_endtime']: null;
$schedule_color = isset($_POST['schedule_color'])?$_POST['schedule_color']: null;
$mediator_name = isset($_POST['mediator_name'])?$_POST['mediator_name']: null;
$incident_date = isset($_POST['incident_date'])?$_POST['incident_date']: null;
$incident_desc = isset($_POST['incident_desc'])?$_POST['incident_desc']: null;
$incident_location = isset($_POST['incident_location'])?$_POST['incident_location']: null;
$blotter_type = isset($_POST['blotter_type'])?$_POST['blotter_type']: null;
$blotter_evidence = isset($_POST['blotter_evidence'])?$_POST['blotter_evidence']: null;
$blotter_filecontext = isset($_POST['blotter_filecontext'])?$_POST['blotter_filecontext']: null;
$case_context = isset($_POST['case_context'])?$_POST['case_context']: null;

if($operation_check == "SELECT_NONRESIDENT_TABLELOAD"){

    $sqlquery = "SELECT * FROM vw_select_nonresident";

    $stmt = $pdo->prepare($sqlquery);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($results);

}else if($operation_check == "SELECT_RESIDENT_TABLELOAD"){

    $sqlquery = "SELECT * FROM vw_select_resident";
    
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if(empty($results)){
            echo "Responded nothing"; 
        }else{
        echo json_encode($results);
        }

}else if($operation_check == "FETCH_SCHEDULE_ON_MODAL"){

    $sqlquery = "SELECT * FROM vw_blotters_schedule";
    $stmt = $pdo->prepare($sqlquery);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);
}else if($operation_check == "FETCH_MEDIATOR_SELECT"){

    $sqlquery = "SELECT CONCAT(first_name, ' ', middle_name, ', ', last_name, ' ', COALESCE(suffix, '')) AS mediator_name FROM tbl_blotter_mediator";
    $stmt = $pdo -> prepare($sqlquery);
    $stmt -> execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<option value="" hidden>Select Mediator</option>';

    foreach($results as $mediator_name){

        echo '<option value="'.htmlspecialchars($mediator_name['mediator_name']).'">'.htmlspecialchars($mediator_name['mediator_name']).'</option>';

    }

}else if($operation_check == "ADD_BLOTTER"){

    if($main_complainant_status == 0){
        $resident_complainant = $main_complainantid;
    }else if($main_complainant_status ==1){
        $non_resident_complainant = $main_complainantid;
    }

    if($main_respondent_status == 0){
        $resident_respondent = $main_respondentid;
    }else if($main_respondent_status ==1){
        $non_resident_respondent = $main_respondentid;
    }

   try{
        $pdo -> beginTransaction();
        $blotter_query = "INSERT INTO tbl_blotter(res_complainant_no, nres_complainant_no, res_respondent_no, nres_respondent_no, blotter_type, desc_incident,
         incident_dt, location_of_incident, date_of_resolution, statemnt, mediation_date, mediation_starttime, mediation_endtime, schedule_color) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
        $blotter_stmt = $pdo -> prepare($blotter_query);
        $blotter_stmt -> execute([$resident_complainant. $non_resident_complainant, $resident_respondent, $non_resident_respondent,
                        $blotter_type, $blotter_type, $desc_incident, $incident_date, $incident_location, $statement, $schedule_date, $schedule_starttime, $schedule_endtime, $schedule_color]);
        $pdo->commit();

   }catch(Exception $e){

        $pdo->rollBack();

   }

    

}else{
    echo json_encode(["Nothing was recieved"]);
}
$pdo = null;

?>