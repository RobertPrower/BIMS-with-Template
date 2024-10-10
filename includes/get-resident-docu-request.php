<?php 
require_once('connecttodb.php');

$operation_check = $_POST['OPERATION'];

if($operation_check == "FETCH_TABLE"){
    $id=$_POST['resident_id'];
    if(isset($id)){

        $sqlquery="SELECT * FROM vw_all_res_cert WHERE resident_no = ?";

        $stmt=$pdo->prepare($sqlquery);
        $stmt->execute([$id]);
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                                        
        //To Populate table rows with Resident Clearance data
        foreach ($result as $row) {
            echo "<tr>";
            
            echo   "<td>{$row['request_id']}</td>
                    <td>{$row['date_issued']}</td>
                    <td>{$row['expiration']}</td>
                    <td>{$row['cert_type']}</td>
                    <td>{$row['purpose']}</td>
                    <td>{$row['age']}</td>
                    <td>{$row['presented_id']}</td>
                    <td>{$row['ID_number']}</td>";
        
            switch ($row['status']){
                case 0: echo "<td><span class='badge-success'> ACTIVE</span> </td>";
                break;
                case 1: echo "<td><span class='badge-disabled'> EXPIRED</span></td>";
                break;
                case 2: echo "<td> <span class='badge-trashed'> REVOKED </span></td>";
                break;
                default: echo "<td> Unknown Status </td>";
            } 
        
            echo "</tr>";
                        
        }
    
    }else{
        echo json_encode("ID not provided");
    }
}elseif($operation_check == "PAGINATION"){
    $id=$_POST['resident_id'];

    $pagequery = "SELECT COUNT(*) FROM vw_all_res_cert WHERE resident_no = ?";
    $total_records_stmt = $pdo->prepare($pagequery);
    $total_records_stmt->execute([$id]);
    $total_records = $total_records_stmt->fetchColumn();
    $limit = 5; //To limit the number of pages
    $total_pages = ceil($total_records / $limit);

    // Get the current page or set a default
    $page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
    $current_page = max(1, min($page, $total_pages));
    $start_from = ($page - 1) * $limit;

    // Fetch the data for the current page
    $query = $pdo->prepare("SELECT * FROM vw_all_res_cert ORDER BY resident_no ASC LIMIT $start_from, $limit");
    $query->execute();
    $result = $query->fetchAll();

    require_once("paginationtemplate.php");
    
}
$pdo = null;
?>