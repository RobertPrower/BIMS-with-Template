<?php
if($_SERVER['REQUEST_METHOD']=="POST"){

    require_once 'config.php';
    require_once 'enforce_login.php';

    require_once("connecttodb.php");

    //To Sanitize the Data to prevent SQL Injections and Cross site scripting and insertion of special characters
    require_once('anti-SQLInject.php');

    //For the file upload function
    require_once 'fileUpload.php';

    function check_db_duplicate($pdo, $valuetocheck){

        //Check for any duplicates of the entered details
        $check_query = "SELECT * FROM non_resident WHERE last_name = ? AND first_name = ? AND house_num = ? AND street = ? AND district_brgy = ? AND city = ? 
        AND province = ? AND zipcode = ? AND sex = ? AND marital_status = ? AND birth_date = ? AND birth_place = ? AND cellphone_num = ?";
        $check_stmt = $pdo->prepare($check_query);
        $check_stmt->execute($valuetocheck);
        $result = $check_stmt->fetch(mode: PDO::FETCH_ASSOC);

        return $result;
        
    }

    function checkForDuplicateFiles($pdo,$resident_id, $target_dir){
        //Checks the img/non_resident_img folder for any used images

        if(isset($resident_id)){
            try{
                // Fetch all filenames from the database
                $stmt = $pdo->prepare("SELECT img_filename FROM non_resident WHERE resident_id = ?");
                $stmt -> execute([$resident_id]);
                $filename = $stmt->fetchColumn();
            }catch(Exception $e){
                throw new Exception("Failed to fetch filename from database");
            }
            

            $filePath = $target_dir . $filename;
            if (file_exists($filePath)) {
                unlink($filePath);
                return true;
            }else{
                throw new Exception("Failed to Delete the file");
            }
        }else{
            throw new Exception("No resident ID was passed to this function");
        }
    }

    date_default_timezone_set('Asia/Hong_Kong'); //Set the default timezone

    $operation_check=$_POST['operation']; //Catches What operation to perform
    $nowdate = date("y-m-d H:i:s"); //Checks the current date
    $userid=$_SESSION["user_id"]; // For the user currently using the system
    $departno=$_SESSION["depart_no"]; // For the users depart currently using

    // Retrieve data sent via POST for add and edit
    $fname = (isset($_POST['fname'])) ? sanitizeData($_POST['fname']): null;
    $mname = (isset($_POST['mname'])) ? sanitizeData($_POST['mname']): null;
    $lname = (isset($_POST['lname'])) ? sanitizeData($_POST['lname']): null;
    $suffix = (isset($_POST['suffix'])) ? sanitizeData($_POST['suffix']): null;
    $houseno = (isset($_POST['house_no'])) ? sanitizeData($_POST['house_no']): null;
    $street = (isset($_POST['street'])) ? sanitizeData($_POST['street']): null;
    $subd = (isset($_POST['subd'])) ? sanitizeData($_POST['subd']): null;
    $districtbrgy = (isset($_POST['district_brgy'])) ? sanitizeData($_POST['district_brgy']): null;
    $city=(isset($_POST['city'])) ? sanitizeData($_POST['city']): null;
    $province=(isset($_POST['province'])) ? sanitizeData($_POST['province']): null;
    $zipcode=(isset($_POST['zipcode'])) ? sanitizeData($_POST['zipcode']): null;
    $sex = (isset($_POST['sex'])) ? sanitizeData($_POST['sex']): null;
    $maritalstatus = (isset($_POST['marital_status'])) ? sanitizeData($_POST['marital_status']): null;
    $birthdate = (isset($_POST['birth_date'])) ? sanitizeData($_POST['birth_date']): null;
    $birthplace = (isset($_POST['birth_place'])) ? sanitizeData($_POST['birth_place']): null;
    $cellphonenumber = (isset($_POST['cellphone_number'])) ? sanitizeData($_POST['cellphone_number']): null;
    $is_a_voter = (isset($_POST['is_a_voter'])) ? sanitizeData($_POST['is_a_voter']): null;
    
    $checkifempty = [$lname, $fname, $houseno, $street, $districtbrgy, $city, $province, $zipcode, $sex, $maritalstatus, $birthdate, $birthplace, $cellphonenumber];

    if($operation_check == "ADD"){ //For the add operation

        if(check_empty_values($checkifempty) == false){
            echo json_encode(["success" => false, "message" => "Some fields are empty"]);
            die();
        }

        if(!empty(check_db_duplicate($pdo, $checkifempty))){
            echo json_encode(["success" => "entry_match", "message" => "Duplicate Entry has been found!", "data" => check_db_duplicate($pdo, $params)]);
            die();
        }

        if(isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK){

            try{
            $fileName = uploadImageFile("image_file", "img/non_resident_img/");

            }catch(Exception $e){
                echo json_encode(["success" => false, "message" => $e->getMessage()]);
                die();
            }

        }else if(isset($_POST['captureImageData'])){ //Incase the image comes from the camera
        
            try{
            $fileName = captureImageUpload('captureImageData', "img/non_resident_img/");
            }catch(Exception $e){
                echo json_encode(["success" => false, "message" => $e->getMessage()]);
                die();
            }

        }else{

            exit(json_encode(['success' => false, 'message' => 'No image was sent!'.$e->Message()])); 

        }
            
        
        try {

            $pdo->beginTransaction();

            //Record to Audit Trail
            $audit_query = "INSERT INTO nonres_audit_trail (dept_added_no, user_added_no, datetime_added)
            VALUES (?, ?,CURRENT_TIMESTAMP)";
            $audit_stmt = $pdo->prepare($audit_query);
            $audit_stmt->execute([$departno,$userid]);
        
            // Insert data into the non resident table
            $insert_query = "INSERT INTO non_resident (img_filename, last_name, first_name, middle_name, suffix, house_num, street, subdivision, 
                                district_brgy, city, province, zipcode, sex, marital_status, birth_date, birth_place, cellphone_num)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?);";
            $insert_stmt = $pdo->prepare($insert_query);
            $insert_stmt->execute([
                
                $fileName,
                $lname,
                $fname,
                $mname,
                $suffix,
                $houseno,
                $street,
                $subd,
                $districtbrgy,
                $city,
                $province,
                $zipcode,
                $sex,
                $maritalstatus,
                $birthdate,
                $birthplace,
                $cellphonenumber,
                
            ]);

            // Success response encodes it to JSON format for the AJAX to read
            $response = ["success" => true, "message" => "Data Added successfully"];
            echo json_encode($response);

            $pdo->commit();
        } catch (Exception $e) {
            // Error response
            $pdo->rollBack();
            $response = ["success" => false, "message" => "Error updating data: " . $e->getMessage()];
            echo json_encode($response);
        }


        
    }elseif($operation_check == "EDIT"){

        // Retrieve data sent via POST
        $nresidentId = sanitizeData($_POST['nresident_id']);
    
        if(empty($nresidentId)){
            echo json_encode(["success"=>false, "message"=>"No ID was recieved!!"]);
            die();
        }

        if(isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK){

            try{
                $fileName = uploadImageFile("image_file", "img/non_resident_img/");
    
            }catch(Exception $e){
                echo json_encode(["success" => false, "message" => $e->getMessage()]);
                die();
            }
            
            try{
                $pdo->beginTransaction();

            //MetaData Entering to the Database
                $stmt = $pdo->prepare("UPDATE non_resident SET img_filename=? WHERE nresident_id=?");
                $stmt -> execute([$fileName, $nresidentId]);
                $pdo->commit();

            }catch(Exception $error){

                $pdo->rollBack();
                $response = ["success" => false, "message" => "Error updating data: ".$error->getMessage()];

            }
        
            $imgopresponse = "Image Uploaded Successfully";

        }elseif(isset($_POST['isfromcamcheck'])){ //Incase the image comes from the camera

            try{
                $fileName = captureImageUpload('isfromcamcheck', "img/non_resident_img/");
            }catch(Exception $e){
                echo json_encode(["success" => false, "message" => $e->getMessage()]);
                die();
            }

            try{
                $pdo->beginTransaction();

            //MetaData Entering to the Database
                $stmt = $pdo->prepare("UPDATE non_resident SET img_filename=? WHERE nresident_id=?");
                $stmt -> execute([$fileName, $nresidentId]);
                $pdo->commit();
                
            }catch(Exception $error){

                $pdo->rollBack();
                $response = ["success" => false, "message" => "Error updating data: ".$error->getMessage()];
                die();
            }
            
            $imgopresponse = "Captured Picture recorded successfully";
            
        }else{
            $imgopresponse = "No image data was recevied";
        }

        try {
            $pdo->beginTransaction();

            // Prepare SQL statement for updating resident data
            $statement = $pdo->prepare("UPDATE non_resident SET first_name = ?, middle_name = ?, last_name = ?,suffix = ?, house_num = ?, street = ?, subdivision = ?, district_brgy=?, city=?, province=?, zipcode=? ,sex = ?, marital_status = ?, birth_date = ?, birth_place = ?, cellphone_num = ? WHERE nresident_id = ?");
            
            // Bind parameters and execute the statement
            $statement->execute([$fname, $mname, $lname, $suffix, $houseno, $street, $subd,$districtbrgy, $city, $province, $zipcode, $sex, $maritalstatus, $birthdate, $birthplace, $cellphonenumber, $nresidentId]);

            $update_audit_sql= "UPDATE nonres_audit_trail SET dept_edited_no=?, user_edited_no=?, last_edited_dt=? WHERE audit_trail_id=?";
            $atstmt= $pdo->prepare($update_audit_sql);
            $atstmt -> execute([$departno, $userid, $nowdate, $nresidentId]);

              // Send success response
            echo json_encode(["success" => true, "message" => "Data updated successfully". " ImageStatus: " . $imgopresponse]);

            $pdo->commit();
        } catch (PDOException $e) {
            // Handle database connection or query errors

            $pdo->rollBack();
            error_log($e->getMessage());

            echo json_encode(["success" => false, "message" => "Error updating data: " . $e->getMessage()]);

        }


    }elseif($operation_check == "DELETE"){
        // Get the ID of the record to delete
        $id_to_delete = sanitizeData($_POST['nresident_id']);

        if(isset($id_to_delete)){
            // Prepare an update statement to mark the record as deleted
            try{
            
                $pdo->beginTransaction();

                $update_query = "UPDATE non_resident SET is_deleted = 1 WHERE nresident_id = ?";
                $update_stmt = $pdo->prepare($update_query);
                $update_stmt->execute([$id_to_delete]);

                $update_audit_sql= "UPDATE nonres_audit_trail SET dept_deleted_no=?, user_deleted_no=?, last_deleted_dt=? WHERE audit_trail_id=?";
                $atstmt= $pdo->prepare($update_audit_sql);
                $atstmt -> execute([$departno, $userid, $nowdate, $id_to_delete]);
                echo json_encode(["success" => true, "message" => "Record Soft deleted successfully."]);

                $pdo->commit();
            }catch(PDOException $e){

                $pdo->rollBack();
                error_log($e->getMessage());
                echo json_encode(["success" => false, "message" => "Error deleting record" . $e->getMessage()]);

            }
        }else{
            echo json_encode(["success" => false, "message" => "ID not Provided"]);

        }
    }elseif($operation_check=="UNDO_DELETE"){
        //For Admin only
        $id_to_delete = sanitizeData($_POST['nresident_id']);

        if(isset($id_to_delete)){
            // Prepare an update statement to mark the record as is_deleted=0
            try{

                $pdo->beginTransaction();
            
                $update_query = "UPDATE non_resident SET is_deleted = 0 WHERE nresident_id = ?";
                $update_stmt = $pdo->prepare($update_query);
                $update_stmt->execute([$id_to_delete]);

                $update_audit_sql= "UPDATE nonres_audit_trail SET dept_recovered_no=?, user_recovered_no=?, last_recovered_dt=CURRENT_TIMESTAMP() WHERE audit_trail_id=?";
                $atstmt= $pdo->prepare($update_audit_sql);
                $atstmt -> execute([$departno, $userid, $id_to_delete]);
                echo json_encode(["success" => true, "message" => "Record recovered successfully."]);

                $pdo->commit();

            }catch(PDOException $e){
                $pdo->rollBack();
                error_log($e->getMessage());
                echo json_encode(["success" => false, "message" => "Error recovering the record" . $e->getMessage()]);

            }
        }else{
            echo json_encode(["success" => false, "message" => "ID not Provided"]);

        }


    }elseif($operation_check=="PAGINATION"){
        
    // Fetch the total number of records
        $total_records = $pdo->query("SELECT COUNT(*) FROM vw_nonresident")->fetchColumn();
        $limit = 10; //To limit the number of pages
        $total_pages = ceil($total_records / $limit);

        // Get the current page or set a default
        $current_page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
        $current_page = max(1, min($current_page, $total_pages));
        $start_from = ($current_page - 1) * $limit;

        // Fetch the data for the current page
        $query = $pdo->prepare("SELECT * FROM vw_nonresident ORDER BY last_name ASC LIMIT $start_from, $limit");
        $query->execute();
        $result = $query->fetchAll();

        require_once'paginationtemplate.php';

    }elseif($operation_check=="SHOW_DELETED"){

        // Fetch the total number of records
        $total_records = $pdo->query("SELECT COUNT(*) FROM vw_nonresident_deleted")->fetchColumn();
        $limit = 10; //To limit the number of pages
        $total_pages = ceil($total_records / $limit);
    
        // Get the current page or set a default
        $page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
        $page = max(1, min($page, $total_pages));
        $start_from = ($page - 1) * $limit;
    
        // Fetch the data for the current page
        $query = "SELECT * FROM vw_nonresident_deleted LIMIT :start_from, :lim";
        $stmt = $pdo->prepare($query);
        $stmt->bindvalue(":start_from", (int)$start_from, PDO::PARAM_INT);
        $stmt->bindValue(":lim", (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll();

        if(!empty($results)){
            require_once'nonresidenttabletofetch.php';
        }else{
            echo '<tr><td colspan="11"><b>No Deleted Records found</b></td></tr>';
        }

    }elseif($operation_check=="PAGINATION_FOR_DEL_REC"){
        // Fetch the total number of records
        $total_records = $pdo->query("SELECT COUNT(*) FROM non_resident WHERE is_deleted=1")->fetchColumn();
        $limit = 10; //To limit the number of pages
        $total_pages = ceil($total_records / $limit);

        // Get the current page or set a default
        $current_page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
        $current_page = max(1, min($current_page, $total_pages));
        $start_from = ($current_page - 1) * $limit;

        require_once('paginationtemplate.php');
    }elseif($operation_check == "GET_IMAGE"){

        $id = $_POST['id'];
        $query = "SELECT img_filename FROM non_resident WHERE nresident_id = ?"; 
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        $result = $statement->fetch(mode: PDO::FETCH_ASSOC);

        if ($result) {
            // Prepare response
            $response = array(
            "imageData" => $result['img_filename']
            
            );
        
        } else {
            $response = array("error" => "No data found for id: $id");
        }

        $pdo = null;

        header('Content-Type: application/json');
        echo json_encode($response);

    }elseif($operation_check == "FETCH_TABLE"){
        $limit = 10;
        $page = isset($_POST['pageno']) ? sanitizeData($_POST['pageno']) : 1;
        $start_from = ($page - 1) * $limit;

        try {
                $sql = "SELECT * FROM vw_nonresident ORDER BY last_name ASC LIMIT $start_from, $limit"; 
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Check if there are any results
            if (count($results) > 0) {
                // Output each row as HTML
                require_once'nonresidenttabletofetch.php';
            } else {
                echo '<tr><td colspan="12">No records found.</td></tr>';
            }
        } catch (PDOException $e) {
            echo 'Error: ' . htmlspecialchars($e->getMessage());
        }

    }elseif($operation_check == "COUNT_RES_CERT"){
        $nresident_no = $_POST['nresident_id'];

        $countquery = "SELECT COUNT(*) AS count FROM tbl_docu_request WHERE nresident_no = ?";
        $stmt = $pdo->prepare($countquery);
        $stmt->execute([$nresident_no]);
        $results = $stmt -> fetchColumn();

        echo json_encode([$results]);
    }elseif($operation_check=="SEARCH"){
        $search = isset($_POST['search']) ? sanitizeData($_POST['search']): '';
        if(!empty($search)){
            $limit = 10;
            $page = isset($_POST['page']) ? sanitizeData($_POST['page']) : '1';
            $start_from = ($page - 1) * $limit;

            // query to fetch records with pagination
            $stmt = $pdo->prepare("CALL SearchNonResident(:search, :start_from ,$limit)"); 

            $stmt->execute(['search' => "%$search%",
                                    'start_from' => "$start_from"]);

            $results = $stmt->fetchAll();

            if(!empty($results)){
                // Code for displaying the results
            require_once'nonresidenttabletofetch.php';
                
            }else{
                echo '<tr><td colspan="11"><b>No results found</b></td></tr>';
            }
        }else{
            echo '<tr><td colspan="11">No Query</td></tr>';
        }
    }elseif($operation_check=="DELETED_SEARCH"){
        $search = isset($_POST['search']) ? sanitizeData($_POST['search']): '';
        if(!empty($search)){
            $limit = 10;
            $page = isset($_POST['page']) ? sanitizeData($_POST['page']) : '1';
            $start_from = ($page - 1) * $limit;

            // query to fetch records with pagination
            $stmt = $pdo->prepare("CALL SearchNonResidentDeleted(:search,:start_from,$limit)"); 

            $stmt->execute(['search' => "%$search%", 'start_from' => "$start_from"] );

            $results = $stmt->fetchAll();

            if(!empty($results)){
                // Code for displaying the results
                require_once'nonresidenttabletofetch.php';
                
            }else{
                echo '<tr><td colspan="11"><b>No results found</b></td></tr>';
            }
        }else{
            echo '<tr><td colspan="11">No Query</td></tr>';
        }

    }elseif($operation_check == "LOOK_FOR_ENTRY"){
        $id = $_POST["id"];
        if(isset($id)){
            $stmt = $pdo->prepare("SELECT * FROM vw_nonresident WHERE nresident_id =?");
            $stmt->execute([$id]);
            $results = $stmt->fetchAll(mode:PDO::FETCH_ASSOC);
        
            echo json_encode($results);

        }else{
            echo json_encode(["success" => false, "message" => "NO ID was recieved"]);
        }
        
    }elseif($operation_check=="SEARCH_PAGINATION"){
        $search = isset($_POST['search']) ? sanitizeData($_POST['search']): '';
        $limit = 10;
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM non_resident WHERE last_name LIKE :search OR first_name LIKE :search OR middle_name LIKE :search");
        $stmt->execute(['search' => "%$search%"]);
        $total_records = $stmt->fetchColumn();

        switch($total_records){
            case 0:
                $total_pages = 0;
            break;
            default:
                $total_pages = ceil($total_records / $limit);
        }


        $current_page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
        $current_page = max(1, min($current_page, $total_pages));
        $start_from = ($current_page - 1) * $limit;
            
        require_once'paginationtemplate.php';
    }else if($operation_check == "FETCH_CITY_JSON"){
    }elseif($operation_check=="CHECK_HIT"){
        $resident_id = $_POST['nresident_id'];
        try{
            $sqlquery="CALL CountNonResidentBlotterEntries(?)";
            $stmt = $pdo->prepare($sqlquery);
            $stmt->execute(array($resident_id));
            $count = $stmt->fetchColumn();
    
            if($count==0){
                echo json_encode(["success"=> "clear" , "message" => "Clear"]);
            }else{
                echo json_encode(["success"=> "hit" , "message" => "Hit Found"]);
            }
    
        }catch(Exception $e){
            die(json_encode(["success"=>false , "message" => "Erorr :".$e->getMessage()]));
    
        }
    
    }else{
        echo "Invalid operation";
    }

}else{
    header("Location: index.php");
    exit("Access Denied");
}

// Close the database connection
$pdo = null;
?>
