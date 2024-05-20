<?php
require_once("connecttodb.php");

try {
    //Variable for the Name of the Folder which is img
    $target_dir = "img/resident_img/";

    //Variable for the path
    $target_file = $target_dir . basename($_FILES["image_file"]["name"]);

    // To get the file extension and converts it to lower case
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Generate a Unique filename via the generateUniqueFileName user define function below
    $fileName = generateUniqueFileName($target_dir, basename($_FILES["image_file"]["name"]));
    $target_file = $target_dir . $fileName;

    // Check if file is an image
    $check = getimagesize($_FILES["image_file"]["tmp_name"]);
    if ($check === false) {
        throw new Exception("File is not an image.");
    }

    // Check file size
    if ($_FILES["image_file"]["size"] > 500000) {
        throw new Exception("Sorry, your file is too large.");
    }

    // Allow only specific file formats
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        throw new Exception("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    }

    // Move uploaded file to target directory
    if (!move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
        throw new Exception("Sorry, there was an error uploading your file.");
    }

    // Retrieve the last used ID from the resident table
    $last_id_query = "SELECT resident_id FROM resident ORDER BY resident_id DESC LIMIT 1";
    $last_id_stmt = $pdo->query($last_id_query);
   
    if ($last_id_stmt && $last_id_stmt->rowCount() > 0) {
        $row = $last_id_stmt->fetch(PDO::FETCH_ASSOC);
        $next_id = $row['resident_id'] + 1;
    } else {
        // If there are no existing records, start with ID 1
        $next_id = 1;
    }

    $fname=sanitizeData($_POST['fname']);
    $mname=sanitizeData($_POST['mname']);
    $lname=sanitizeData($_POST['lname']);
    $suffix=sanitizeData($_POST['suffix']);
    $houseno=sanitizeData($_POST['house_no']);
    $street=sanitizeData($_POST['street']);
    $sudb=sanitizeData($_POST['subd']);
    $sex=sanitizeData($_POST['sex']);
    $maritalstatus=sanitizeData($_POST['marital_status']);
    $birthdate=sanitizeData($_POST['birth_date']);
    $birthplace=sanitizeData($_POST['birth_place']);
    $cellphonenumber=sanitizeData($_POST['cellphone_number']);
    $is_a_voter=sanitizeData($_POST['is_a_voter']);
    $residentsince=sanitizeData($_POST['resident_since']);


    // Insert data into the resident table
    $insert_query = "INSERT INTO resident (resident_id, date_recorded, img_path, first_name, middle_name, last_name, suffix, house_number, street_name, subdivision, resident_since, sex, marital_status, birth_date, birth_place, cellphone_number, is_a_voter)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?)";
    $insert_stmt = $pdo->prepare($insert_query);
    $insert_stmt->execute([
        $next_id,
        date("Y-m-d H:i:s"),
        $target_file,
        $fname,
        $mname,
        $lname,
        $suffix,
        $houseno,
        $street,
        $sudb,
        $residentsince,
        $sex,
        $maritalstatus,
        $birthdate,
        $birthplace,
        $cellphonenumber,
        $is_a_voter
        
      
    ]);

    // Success response
    $response = ["success" => true, "message" => "Data updated successfully"];
    echo json_encode($response);
} catch (Exception $e) {
    // Error response
    $response = ["success" => false, "message" => "Error updating data: " . $e->getMessage()];
    echo json_encode($response);
}

// Function to check if a file with the given name exists in the resident_img table

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

function sanitizeData($input){
    $removedSpecialChar = trim ($input, "!@#$%^&*()-=[]{};:`~'<>,./\?| "); 
    $removedSpecialCharinthemiddle= preg_replace('/[^a-zA-Z0-9\s\-ñÑ#]/u','', $removedSpecialChar);

    $sanatizedData=htmlspecialchars($removedSpecialCharinthemiddle);

    return $sanatizedData;

}

// Close the database connection
$pdo = null;
?>
