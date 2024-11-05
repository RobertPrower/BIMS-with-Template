<?php 
require_once'connecttodb.php';

$operation_check = (isset($_POST['operation']))? $_POST['operation']: null;

$main_complainantid = isset($_POST['main_complainantid'])?$_POST['main_complainantid']: NULL; 
$main_complainant_status = isset($_POST['main_complainant_status'])?$_POST['main_complainant_status']: NULL;
$main_respondentid = isset($_POST['main_respondentid'])?$_POST['main_respondentid']: NULL;
$main_respondent_status = isset($_POST['main_respondent_status'])?$_POST['main_respondent_status']: NULL;;

function handleNullValue($value) {
    return $value === "null" ? NULL : $value;
}

$dataTypes = ['resident_complainant', 'resident_respondent', 'nonresident_complainant', 'nonresident_respondent'];
$data = [];

if($operation_check == "ADD_BLOTTER" || $operation_check =="EDIT_BLOTTER"){
    foreach ($dataTypes as $type) {
        for ($i = 1; $i <= 5; $i++) {
            $key = "other_{$type}{$i}";
            $other_person[$key] = handleNullValue($_POST[$key]);
        }
    }
}

$schedule_date = isset($_POST['schedule_date'])?$_POST['schedule_date']: NULL;
$schedule_starttime = isset($_POST['schedule_starttime'])?$_POST['schedule_starttime']: NULL;
$schedule_endtime = isset($_POST['schedule_endtime'])?$_POST['schedule_endtime']: NULL;
$schedule_color = isset($_POST['schedule_color'])?$_POST['schedule_color']: NULL;
$mediator_name = isset($_POST['mediator_name'])?$_POST['mediator_name']: NULL;
$incident_date = isset($_POST['incident_date'])?$_POST['incident_date']: NULL;
$incident_desc = isset($_POST['incident_desc'])?$_POST['incident_desc']: NULL;
$incident_location = isset($_POST['incident_location'])?$_POST['incident_location']: NULL;
$blotter_type = isset($_POST['blotter_type'])?$_POST['blotter_type']: NULL;
$case_context = isset($_POST['case_context'])?$_POST['case_context']: NULL;

$blotter_evidence_fd = "img/blotter_evidence/";
$blotter_context_fd = "img/blotter_context/";

function handleNullValues($value){
    return $value ==="null"? NULL : $value;
}
function generateUniqueFileName($target_dir, $originalFileName) {
    $imageFileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
    $baseName = pathinfo($originalFileName, PATHINFO_FILENAME);

    // Generate a unique file name
    $fileName = $originalFileName;
    $fileSuffix = 1;
    while (file_exists($target_dir . $fileName)) {
        $fileName = $baseName . " ($fileSuffix)." . $imageFileType;
        $fileSuffix++;
    }

    return $fileName;
}

function handleImageUpload($fileInputName, $targetDir) {
    if (!isset($_FILES[$fileInputName])) {
        throw new Exception("No file uploaded.");
    }

    // Get file details
    $targetFile = $targetDir . basename($_FILES[$fileInputName]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Generate a unique filename
    $fileName = generateUniqueFileName($targetDir, basename($_FILES[$fileInputName]["name"]));
    $targetFile = $targetDir . $fileName;

    // Check if file is an image
    $check = getimagesize($_FILES[$fileInputName]["tmp_name"]);
    if ($check === false) {
        $response = "File is not an image.";
        throw new Exception($response);

    }

    // Check file size
    if ($_FILES[$fileInputName]["size"] > 500000) {
        $response = "File too large";
        throw new Exception($response);
    }

    // Allow only specific file formats
    if (!in_array($imageFileType, ["jpg", "jpeg", "png"])) {
        $response = "Sorry, only JPG, JPEG & PNG files are allowed.";
        throw new Exception($response);
    }

    // Move uploaded file to target directory
    if (!move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFile)) {
        $response = "Sorry, there was an error uploading your file.";

        throw new Exception($response);
    }

    return $fileName;
}

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
        $non_resident_complainant = NULL;
    }else if($main_complainant_status ==1){
        $non_resident_complainant = $main_complainantid;
        $resident_complainant = NULL;   
    }

    if($main_respondent_status == 0){
        $resident_respondent = $main_respondentid;
        $non_resident_respondent = NULL;
    }else if($main_respondent_status ==1){
        $non_resident_respondent = $main_respondentid;
        $resident_respondent = NULL;
    }

    try{
        $blotter_evidencefile = handleImageUpload('blotter_evidencefile',$blotter_evidence_fd);
        $blotter_contextfile = handleImageUpload('blotter_contextfile',$blotter_context_fd);
    }catch(Exception $e){
        $response = ["success" => false, "message" => "Error updating data: " . $e->getMessage()];
        $pdo=null;
        exit(json_encode($response));
    }

    try{
        $pdo -> beginTransaction();

        $audit_trail_query = "INSERT INTO tbl_blotter_audit_trail(blotter_add_dt) VALUES(CURDATE())";
        $stmt = $pdo->prepare($audit_trail_query);
        $stmt->execute();

        $other_query = "INSERT INTO tbl_other_complainants(res_person_1,nres_person_1,res_person_2,nres_person_2,res_person_3,nres_person_3,res_person_4,nres_person_4,res_person_5,nres_person_5) 
                        VALUES(?,?,?,?,?,?,?,?,?,?)";
        $other_stmt=$pdo->prepare($other_query);
        $other_stmt->execute([$other_person['other_resident_complainant1'],$other_person['other_nonresident_complainant1'],$other_person['other_resident_complainant2'],$other_person['other_nonresident_complainant2'],$other_person['other_resident_complainant3'],$other_person['other_nonresident_complainant3'],$other_person['other_resident_complainant4'],$other_person['other_nonresident_complainant4'],$other_person['other_resident_complainant5'],$other_person['other_nonresident_complainant5']]);

        $other_query = "INSERT INTO tbl_other_respondents(res_person_1,nres_person_1,res_person_2,nres_person_2,res_person_3,nres_person_3,res_person_4,nres_person_4,res_person_5,nres_person_5) 
        VALUES(?,?,?,?,?,?,?,?,?,?)";
        $other_stmt=$pdo->prepare($other_query);
        $other_stmt->execute([$other_person['other_resident_respondent1'],$other_person['other_nonresident_respondent1'],$other_person['other_resident_respondent2'],$other_person['other_nonresident_respondent2'],$other_person['other_resident_respondent3'],$other_person['other_nonresident_respondent3'],$other_person['other_resident_respondent4'],$other_person['other_nonresident_respondent4'],$other_person['other_resident_respondent5'],$other_person['other_nonresident_respondent5']]);

        $blotter_query = "INSERT INTO tbl_blotters(res_complainant_no, nres_complainant_no, res_respondent_no, nres_respondent_no, blotter_type, desc_incident,
         incident_dt, location_of_incident, statemnt, mediation_date, mediation_starttime, mediation_endtime, schedule_color, blotter_evidencefile, blotter_contextfile) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
        $blotter_stmt = $pdo -> prepare($blotter_query);
        $blotter_stmt -> execute([$resident_complainant, $non_resident_complainant, $resident_respondent, $non_resident_respondent,
                        $blotter_type, $incident_desc, $incident_date, $incident_location, $case_context, $schedule_date, $schedule_starttime, $schedule_endtime, $schedule_color, $blotter_evidencefile, $blotter_contextfile]);
        $pdo->commit();

        $response = ["success" => true, "message" => "Blotter Added Successfully!"];
        echo json_encode($response);

   }catch(Exception $e){
        $response = ["success" => false, "message" => "Error updating data: " . $e->getMessage()];
        $pdo->rollBack(); 
        exit(json_encode($response));
   }

    

}elseif ($operation_check == "FETCH_MAIN_TABLE"){
    $sqlquery = "SELECT * FROM vw_blotters";
    $stmt=$pdo->prepare($sqlquery);
    $stmt->execute();
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($result as $row){

        echo '<tr>';
        echo '<td hidden id="resident_id">' . htmlspecialchars($row['blotter_id']) . '</td>';

            switch ($row['blotter_type']){
            case 0: echo "<td>Blotter</td>";
            break;  
            case 1: echo "<td>Incident</td>";
            break;
            default: echo "<td> Unknown Status </td>";   
            }     
        
        echo '<td>' . htmlspecialchars($row['blotter_add_dt']) . '</td>';
        echo '<td>' . htmlspecialchars($row['incident_dt']) . '</td>';
        echo '<td>' . htmlspecialchars($row['desc_incident']) . '</td>';
        echo '<td>' . htmlspecialchars($row['complainant_last_name']) .', '. htmlspecialchars($row['complainant_first_name']) .' '. htmlspecialchars($row['complainant_middle_name']) .' '. htmlspecialchars($row['complainant_suffix']) . '</td>';
        echo '<td>' . htmlspecialchars($row['complainant_last_name']) .', '. htmlspecialchars($row['complainant_first_name']) .' '. htmlspecialchars($row['complainant_middle_name']) .' '. htmlspecialchars($row['complainant_suffix']) . '</td>';
             
        switch ($row['report_status']){
        case 0: echo "<td><span class='badge-pending'>ONGOING</span> </td>";
        break;
        case 1: echo "<td><span class='badge-success'>RESOLVED</span></td>";
        break;
        case 2: echo "<td> <span class='badge-trashed'>FILE TO ACTION</span></td>";
        break;
        default: echo "<td> Unknown Status </td>";
        } 

        echo '<td>
        <div class="btn-group text-center">
                
            <button class="btn btn-primary mx-1 viewDocumentsButton" id=vbutton
                
                data-bs-toggle="modal" data-bs-target="#DocumentDetailsModal">View</button>

            <button class="btn btn-success mx-1 viewDocumentsButton" id=vbutton
                
                data-bs-toggle="modal" data-bs-target="#DocumentDetailsModal">Edit</button>';

            if($row['is_deleted'] == "0"){ 
                echo '<button class="btn btn-danger mx-1 deleteResidentButton" id="deletebutton"
                    data-pageno=""
                    data-request_id = "' . htmlspecialchars($row['blotter_id']) . '">Delete</button>';
            }else{
                echo '<button class="btn btn-warning mx-1 deleteResidentButton" id="undodeletebutton"
                data-pageno="'.$page.'"
                data-request_id = "' . htmlspecialchars($row['blotter_id']) . '">Recover</button>';
            }
        echo '</tr>';
    }


}else{
    echo json_encode(["success" => false, "message" =>"Nothing was recieved"]);
}
$pdo = NULL;

?>