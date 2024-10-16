<?php 
require_once"connecttodb.php";
include_once'anti-SQLInject.php';

$operation_check = (isset($_POST['OPERATION'])? $_POST['OPERATION'] : null);
$kagawad_id = (isset($_POST['id'])? sanitizeData($_POST['id']):  null);
$imagefile = (isset($_FILES['image_file'])? $_FILES['image_file']: null);
$target_dir="../img/logos/";

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

function uploadImage($imageInputName, $targetDir, $maxFileSize = 500000, $allowedFormats = ["jpg", "jpeg", "png"]) {
    // Check if the file was uploaded without errors
    if (!isset($imageInputName) || $imageInputName['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("File upload error or file not found.");
    }

    // Variable for the path
    $target_file = $imageInputName["name"];

    // Get the file extension and convert it to lower case
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Generate a unique filename using the user-defined function
    $fileName = generateUniqueFileName($targetDir, basename($imageInputName["name"]));
    $target_file = $targetDir . $fileName;

    // Check if the file is an image
    $check = getimagesize($imageInputName["tmp_name"]);
    if ($check === false) {
        throw new Exception("File is not an image.");
    }

    // Check file size
    if ($imageInputName["size"] > $maxFileSize) {
        throw new Exception("Sorry, your file is too large.");
    }

    // Allow only specific file formats
    if (!in_array($imageFileType, $allowedFormats)) {
        throw new Exception("Sorry, only " . implode(", ", $allowedFormats) . " files are allowed.");
    }

    // Move the uploaded file to the target directory
    if (!move_uploaded_file($imageInputName["tmp_name"], $target_file)) {
        throw new Exception("Sorry, there was an error uploading your file.");
    }

    return $fileName; // Return the unique filename if upload is successful
}

function deleteFile($target_dir, $filename) {
    // Construct the full path to the file
    $filePath = $target_dir . '/' . $filename;

    // Check if the file exists
    if (file_exists($filePath)) {
        // Attempt to delete the file
        if (unlink($filePath)) {
            return ["success" => true, "message" => "File deleted successfully."];
        } else {
            return ["success" => false, "message" => "Error deleting the file."];
        }
    } else {
        return ["success" => false, "message" => "File does not exist."];
    }
}

if($operation_check == "FETCH_KAGAWAD"){

    $suboperation = (isset($_POST['SUBOPERATION']))? $_POST['SUBOPERATION']: null;

    if($suboperation == "FOR_REFRESHING"){

        $sqlquery = "SELECT * FROM kagawad";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $names){
            $kagawads[] = $names['official_name'];
        }

        echo implode(', ', $kagawads );
        

    }else{
        $sqlquery = "SELECT * FROM kagawad";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $kagawad){

            echo ' <tr>
                        <td>
                            <input type="text" class="form-control" id="kagawad'.$kagawad['kagawad_id'].'" value="'.$kagawad['official_name'].'" data-id="'.$kagawad['kagawad_id'].'" placeholder=""/>
                        </td>
                        <td class="d-flex justify-content-center">
                        <button class="btn btn-success mx-2 editkagawadbtn" data-id='.$kagawad['kagawad_id'].'>Edit</button>
                        <button class="btn btn-danger deletekagawadbtn" data-id='.$kagawad['kagawad_id'].'>Delete</button>

                        </td>
                        
                        
                    </tr>
                    
                    ';


        }

            echo '<tr>
                    <th scope="row">
                        <input type="text" class="form-control" id="newkagawad" placeholder=""/>
                    </th>

                    <td class="d-flex justify-content-center">
                        <button class="btn btn-primary addkagawadbtn">Add</button>
                    </td>
                </tr>';
    }
}else if($operation_check == "EDIT_KAGAWAD"){

    $kagawad_name = $_POST['kagawad_name'];

    try{
        $pdo->beginTransaction();
    
        $sqlquery = "UPDATE kagawad SET official_name = :official_name WHERE kagawad_id=:id";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->bindParam(':id', $kagawad_id, PDO::PARAM_INT);
        $stmt->bindParam(':official_name',$kagawad_name,PDO::PARAM_STR);
        $stmt->execute();

        $pdo->commit();

        echo json_encode(["success"=>true, "message" => "Kagawad updated successfully"]);
    }catch(Exception $e){
        echo json_encode(["success"=>false, "message" => $e->getMessage()]);
        $pdo->rollBack();

    }
}else if($operation_check == "ADD_KAGAWAD"){

    $kagawad_name = $_POST['kagawad_name'];

    try{
        $pdo->beginTransaction();
    
        $sqlquery = "INSERT INTO kagawad(official_name) VALUES (:official_name)";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->bindParam(':official_name',$kagawad_name,PDO::PARAM_STR);
        $stmt->execute();

        $pdo->commit();

        echo json_encode(["success"=>true, "message" => "Kagawad added successfully"]);
    }catch(Exception $e){
        echo json_encode(["success"=>false, "message" => $e->getMessage()]);
        $pdo->rollBack();

    }
}else if($operation_check == "DELETE_KAGAWAD"){

    try{
        $pdo->beginTransaction();
    
        $sqlquery = "DELETE FROM kagawad WHERE kagawad_id=:id";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->bindParam(':id',$kagawad_id,PDO::PARAM_INT);
        $stmt->execute();

        $pdo->commit();

        echo json_encode(["success"=>true, "message" => "Kagawad deleted successfully"]);
    }catch(Exception $e){
        echo json_encode(["success"=>false, "message" => $e->getMessage()]);
        $pdo->rollBack();

    }
}else if($operation_check == "SAVE_PSSK"){

    $punong_barangay = (isset($_POST['pb']))? $_POST['pb']: null;
    $barangay_sec = (isset($_POST['bsec']))? $_POST['bsec']:null;
    $barangay_sk = (isset($_POST['bsk']))? $_POST['bsk']: null;

    try{
        $pdo->beginTransaction();
    
        // Update for Punong Barangay
        $sql1 = "UPDATE brgy_officials SET official_name = :punong_barangay WHERE official_position = 'Punong Barangay'";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->bindParam(':punong_barangay', $punong_barangay, PDO::PARAM_STR);
        $stmt1->execute();
    
        // Update for Barangay Secretary
        $sql2 = "UPDATE brgy_officials SET official_name = :barangay_sec WHERE official_position = 'Barangay Secretary'";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindParam(':barangay_sec', $barangay_sec, PDO::PARAM_STR);
        $stmt2->execute();
    
        // Update for SK Chairperson
        $sql3 = "UPDATE brgy_officials SET official_name = :barangay_sk WHERE official_position = 'SK Chairperson'";
        $stmt3 = $pdo->prepare($sql3);
        $stmt3->bindParam(':barangay_sk', $barangay_sk, PDO::PARAM_STR);
        $stmt3->execute();
    
        // Commit the transaction
        $pdo->commit();
        echo json_encode(["success"=>true, "message" => "PSSK updated successfully"]);
    }catch(Exception $e){
        echo json_encode(["success"=>false, "message" => $e->getMessage()]);
        $pdo->rollBack();

    }
}else if($operation_check == "EDIT_BRGY_DETAILS"){

    $barangay_name = (isset($_POST['brgy_name']))? $_POST['brgy_name']: null;
    $barangay_address = (isset($_POST['brgy_address']))? $_POST['brgy_address']:null;
    $barangay_celnum = (isset($_POST['brgy_celnum']))? $_POST['brgy_celnum']: null;
    $barangay_telnum = (isset($_POST['brgy_telnum']))? $_POST['brgy_telnum']: null;
    $barangay_email = (isset($_POST['brgy_email']))? $_POST['brgy_email']: null;
    $barangay_district = (isset($_POST['brgy_district']))? $_POST['brgy_district']: null;
    $barangay_sona = (isset($_POST['brgy_sona']))? $_POST['brgy_sona']: null;


    try{
        $pdo->beginTransaction();
    
        // Update for Punong Barangay
        $sql1 = "UPDATE brgy_details SET brgy_name = ?, sona=?, district=?, tel_num=?, cp_num=?, email=?, `address`=? WHERE brgy_details_id = 1";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute([$barangay_name, $barangay_sona, $barangay_district,$barangay_telnum,  $barangay_celnum, $barangay_email,$barangay_address]);
    
        // Commit the transaction
        $pdo->commit();
        echo json_encode(["success"=>true, "message" => "Brgy details updated successfully"]);
    }catch(Exception $e){
        echo json_encode(["success"=>false, "message" => $e->getMessage()]);
        $pdo->rollBack();

    }
}else if($operation_check == "EDIT_ADMIN_LOGO"){

    if(isset($imagefile)){  
      
        try{  
            $pdo->beginTransaction();

            $fetcholdfilequery = "SELECT `filename` FROM `certificate-img` WHERE purpose='Government Logo'"; 
            $stmt = $pdo->prepare($fetcholdfilequery);
            $stmt->execute();
            $dbfile = $stmt->fetch(PDO::FETCH_COLUMN);

            deleteFile($target_dir, $dbfile);

            $filename = uploadImage($imagefile, $target_dir);

            $sqlquery="UPDATE `certificate-img` SET `filename` = ? WHERE `purpose` = 'Government Logo';";
            $stmt = $pdo->prepare($sqlquery);
            $stmt->execute([$filename]);
            $pdo->commit();

            echo json_encode(["success"=>true, "message" => "Admin logo updated successfully", "filename" => $filename]);


        }catch(Exception $e){
            echo json_encode(["success"=>false, "message" => $e->getMessage()]);
            $pdo->rollBack();
        }
    }else{
        echo json_encode(["success"=>false, "message" => "No file recieved"]);
    }

}else if($operation_check == "EDIT_CITY_LOGO"){

    if(isset($imagefile)){  
      
        try{  
            $pdo->beginTransaction();

            $fetcholdfilequery = "SELECT `filename` FROM `certificate-img` WHERE purpose='City Logo'"; 
            $stmt = $pdo->prepare($fetcholdfilequery);
            $stmt->execute();
            $dbfile = $stmt->fetch(PDO::FETCH_COLUMN);

            $removedunusedfiles = deleteFile($target_dir, $dbfile);

            if($removedunusedfiles == true){

                $filename = uploadImage($imagefile, $target_dir);

                $sqlquery="UPDATE `certificate-img` SET `filename` = ? WHERE `purpose` = 'City Logo';";
                $stmt = $pdo->prepare($sqlquery);
                $stmt->execute([$filename]);
                $pdo->commit();

                exit(json_encode(["success"=> true, "message" => "Admin logo updated successfully", "filename" => $filename]));

                
            }else{

                exit(json_encode(["success"=> false, "message" => $removedunusedfiles]));

            }

        }catch(Exception $e){
            echo json_encode(["success"=>false, "message" => $e->getMessage()]);
            $pdo->rollBack();
        }
    }else{
        echo json_encode(["success"=>false, "message" => "No file recieved"]);
    }

}else if($operation_check == "EDIT_BARANGAY_LOGO"){

    if(isset($imagefile)){  
      
        try{  
            $pdo->beginTransaction();

            $fetcholdfilequery = "SELECT `filename` FROM `certificate-img` WHERE purpose='Barangay Logo'"; 
            $stmt = $pdo->prepare($fetcholdfilequery);
            $stmt->execute();
            $dbfile = $stmt->fetch(PDO::FETCH_COLUMN);

            $removedunusedfiles = deleteFile($target_dir, $dbfile);

            if($removedunusedfiles == true){

                $filename = uploadImage($imagefile, $target_dir);

                $sqlquery="UPDATE `certificate-img` SET `filename` = ? WHERE `purpose` = 'Barangay Logo';";
                $stmt = $pdo->prepare($sqlquery);
                $stmt->execute([$filename]);
                $pdo->commit();

                exit(json_encode(["success"=> true, "message" => "Admin logo updated successfully", "filename" => $filename]));

                
            }else{

                exit(json_encode(["success"=> false, "message" => $removedunusedfiles]));

            }

        }catch(Exception $e){
            echo json_encode(["success"=>false, "message" => $e->getMessage()]);
            $pdo->rollBack();
        }
    }else{
        echo json_encode(["success"=>false, "message" => "No file recieved"]);
    }

}else if($operation_check == "EDIT_WATERMARK_LOGO"){

    if(isset($imagefile)){  
      
        try{  
            $pdo->beginTransaction();

            $fetcholdfilequery = "SELECT `filename` FROM `certificate-img` WHERE purpose='Watermark'"; 
            $stmt = $pdo->prepare($fetcholdfilequery);
            $stmt->execute();
            $dbfile = $stmt->fetch(PDO::FETCH_COLUMN);

            $removedunusedfiles = deleteFile($target_dir, $dbfile);

            if($removedunusedfiles == true){

                $filename = uploadImage($imagefile, $target_dir);

                $sqlquery="UPDATE `certificate-img` SET `filename` = ? WHERE `purpose` = 'Watermark';";
                $stmt = $pdo->prepare($sqlquery);
                $stmt->execute([$filename]);
                $pdo->commit();

                exit(json_encode(["success"=> true, "message" => "Admin logo updated successfully", "filename" => $filename]));

                
            }else{

                exit(json_encode(["success"=> false, "message" => $removedunusedfiles]));

            }

        }catch(Exception $e){
            echo json_encode(["success"=>false, "message" => $e->getMessage()]);
            $pdo->rollBack();
        }
    }else{
        echo json_encode(["success"=>false, "message" => "No file recieved"]);
    }

}else{
    echo json_encode(["success"=> false, "message" => "Unknown Operation"]);
}

?>