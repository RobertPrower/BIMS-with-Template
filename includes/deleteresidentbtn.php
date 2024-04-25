<?php

// Include the database connection file
require_once('connecttodb.php');


// Check if the ID of the record to delete is provided in the POST data
if (isset($_POST['resident_id'])) { // Use POST method
    // Get the ID of the record to delete
    $id_to_delete = $_POST['resident_id'];

    try {
        // Start a transaction
        $pdo->beginTransaction();

        // Prepare an update statement to mark the record as deleted
        $update_query = "UPDATE resident SET is_deleted = true WHERE resident_id = ?";
        $update_stmt = $pdo->prepare($update_query);

        // Bind the ID parameter
        $update_stmt->bindParam(1, $id_to_delete, PDO::PARAM_INT);

        // Execute the update and delete statements
        if ($update_stmt->execute()) {
            // Deletion successful
            echo json_encode(["success" => true, "message" => "Record and image deleted successfully."]);
            // Commit changes
            $pdo->commit();
        } else {
            // Error handling if update or delete fails
            echo json_encode(["success" => false, "message" => "Error deleting record or image: " . implode(" ", $update_stmt->errorInfo())]);
        }

        // Close the prepared statements
        $update_stmt->closeCursor();
    } catch (PDOException $e) {
        // Rollback transaction if an exception occurs
        $pdo->rollBack();
        echo json_encode(["success" => false, "message" => "Error deleting record or image: " . $e->getMessage()]);
    }
} else {
    //If the ID is not provided in the POST data
    echo json_encode(["success" => false, "message" => "ID not provided."]);
}


?>
