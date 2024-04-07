<?php
require_once("connecttodb.php");

try {
    // File upload logic
    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["image_file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

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

    // Insert data into the database
    $insert_query = "INSERT INTO resident (date_recorded, first_name, middle_name, last_name, house_number, street_name, subdivision, sex, marital_status, birth_date, birth_place, cellphone_number, is_a_voter)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = $pdo->prepare($insert_query);
    $insert_stmt->execute([
        date("Y-m-d H:i:s"),
        $_POST['fname'],
        $_POST['mname'],
        $_POST['lname'],
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

    // Success response
    $response = ["success" => true, "message" => "Data updated successfully"];
    echo json_encode($response);
} catch (Exception $e) {
    // Error response
    $response = ["success" => false, "message" => "Error updating data: " . $e->getMessage()];
    echo json_encode($response);
}

// Close the connection
$pdo = null;
?>
