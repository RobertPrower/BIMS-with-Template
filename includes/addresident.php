<?php
require_once("connecttodb.php");

try {
    //Variable for the Name of the Folder which is img
    $target_dir = "img/";

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

    // Extract image metadata
    $imageSize = $check[0]; 
    $imageHeight = $check[1]; 
    $imageMimeType = $_FILES["image_file"]["type"];

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

    // Insert data into the resident table
    $insert_query = "INSERT INTO resident (resident_id, date_recorded, first_name, middle_name, last_name, suffix, house_number, street_name, subdivision, sex, marital_status, birth_date, birth_place, cellphone_number, is_a_voter)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
    $insert_stmt = $pdo->prepare($insert_query);
    $insert_stmt->execute([
        $next_id,
        date("Y-m-d H:i:s"),
        $_POST['fname'],
        $_POST['mname'],
        $_POST['lname'],
        $_POST['suffix'],
        $_POST['house_no'],
        $_POST['street'],
        $_POST['subd'],
        $_POST['sex'],
        $_POST['marital_status'],
        $_POST['birth_date'],
        $_POST['birth_place'],
        $_POST['cellphone_number'],
        $_POST['is_a_voter']
    ]);


  // Insert image metadata into the database
    $insert_query = "INSERT INTO resident_img (id, path, size, height, mime_type) VALUES (?, ?, ?, ?, ?)";
    $insert_stmt = $pdo->prepare($insert_query);
    $insert_stmt->execute([$next_id,$target_file, $imageSize, $imageHeight, $imageMimeType]);

    // Success response
    $response = ["success" => true, "message" => "Data updated successfully"];
    echo json_encode($response);
} catch (Exception $e) {
    // Error response
    $response = ["success" => false, "message" => "Error updating data: " . $e->getMessage()];
    echo json_encode($response);
}

// Function to check if a file with the given name exists in the resident_img table
function fileExistsInDatabase($filename){
    global $pdo;

    $query = "SELECT COUNT(*) FROM resident_img WHERE name= ?";
    $stmt = $pdo->prepare($query);
    $stmt ->execute([$filename]);

    $count = $stmt -> fetchColumn();

    return $count > 0;
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

// Close the database connection
$pdo = null;
?>
