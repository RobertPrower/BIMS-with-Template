
<?php

function uploadImageFile($what_field, $target_dir){

    if($_FILES[$what_field]['error'] == UPLOAD_ERR_OK){
    }elseif($_FILES[$what_field]['error']==UPLOAD_ERR_INI_SIZE){

        $imgopresponse = "UPLOAD_ERR_INI_SIZE: You exceeded the allow file size";
        throw new Exception($imgopresponse); 

    }elseif($_FILES[$what_field]['error']==UPLOAD_ERR_FORM_SIZE){

        $imgopresponse = "UPLOAD_ERR_INI_SIZE: You exceeded the allow HTML directive size";
        throw new Exception($imgopresponse); 


    }elseif($_FILES[$what_field]['error']==UPLOAD_ERR_PARTIAL){

        $imgopresponse = "UPLOAD_ERR_PARTIAL: The uploaded file was partially upload. Check your Internet Connection";
        throw new Exception($imgopresponse); 

    }elseif($_FILES[$what_field]['error']==UPLOAD_ERR_NO_FILE){

        $imgopresponse = "UPLOAD_ERR_NO_FILE: No file is uploaded";
        throw new Exception($imgopresponse); 

    }elseif($_FILES[$what_field]['error']==UPLOAD_ERR_CANT_WRITE){
        $imgopresponse = "UPLOAD_ERR_CANT_WRITE: Unable to write file to disk.";
        throw new Exception($imgopresponse); 

    }elseif($_FILES[$what_field]['error']==UPLOAD_ERR_EXTENSION){
        $imgopresponse = "UPLOAD_ERR_EXTENSION: A PHP extension stopped the file upload.";
        throw new Exception($imgopresponse); 

    }elseif($_FILES[$what_field]['error']==UPLOAD_ERR_NO_TMP_DIR){
        $imgopresponse = "UPLOAD_ERR_NO_TEMP_DIR: You have a missing directory";
        throw new Exception($imgopresponse);

    }else{
        $imgopresponse = "No unknown Error";
        throw new Exception($imgopresponse);

        
    }// End of Image Check If statement

     //Variable for the Name of the Folder which is img
    //  $target_dir = "img/resident_img/";

     //Variable for the path
     $target_file = $target_dir . basename($_FILES[$what_field]["name"]);

     // To get the file extension and converts it to lower case
     $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

     // Generate a Unique filename via the generateUniqueFileName user define function below
     $fileName = generateUniqueFileName($target_dir, basename($_FILES[$what_field]["name"]));
     $target_file = $target_dir . $fileName;

     // Check if file is an image
     $check = getimagesize($_FILES[$what_field]["tmp_name"]);
     if ($check === false) {
         throw new Exception("File is not an image.");
     }

    // Allow only specific file formats
    if (!in_array($imageFileType, ["jpg", "jpeg", "png"])) {
        throw new Exception("Sorry, only JPG, JPEG & PNG files are allowed.");
    }

     $mimeType = mime_content_type($_FILES[$what_field]["tmp_name"]);
     if($mimeType != "image/jpeg" && $mimeType != "image/png"){
        throw new Exception("Sorry, only JPG, JPEG & PNG are allowed.");
     }

     // Check file size
     if ($_FILES[$what_field]["size"] > 500000) {
         throw new Exception("Sorry, your file is too large.");
     }

     // Move uploaded file to target directory
     if (!move_uploaded_file($_FILES[$what_field]["tmp_name"], $target_file)) {
         throw new Exception("Sorry, there was an error uploading your file.");
     }

     return $fileName;
}

function captureImageUpload($what_field, $target_dir){
    //Capture the Data
    if(!isset($_POST[$what_field])){
        throw new Exception("No data was captured.");
    }

    $data_uri = $_POST[$what_field];

    //Extract the base64 Data
    $encoded_image = explode(",", $data_uri)[1];

    //Decode the base64 string
    $decoded_image = base64_decode($encoded_image);

    if($decoded_image ===false){
        throw new Exception("Failed to decode base64 image data.");
    }

    //For the filename being entered in the Database
    $fileName =  'capture_'.time().'.jpg';

    $filePath = $target_dir . $fileName;

    if(!is_dir($target_dir) || !is_writable($target_dir)){
        throw new Exception("Failed to write image to the directory.");
    }

    //Save the image file
    $result = file_put_contents($filePath, $decoded_image);

    if($result === false){
        throw new Exception("Failed to save the image file.");
    }

    return $fileName;
}

function check_empty_values ($required_fields){

    $all_filled = true;

    foreach($required_fields as $check_fields){
        if($check_fields === "" || $check_fields === NULL){
            $all_filled = false;
            break;
        }

    }

    return $all_filled;

}


// Function to check if a file with the given name exists in the non_resident_img table
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

?>