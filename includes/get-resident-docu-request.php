<?php 
require_once('connecttodb.php');

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

                if($row['status']=='0'){

                    echo "<td style='background-color: green; color: white'> ACTIVE </td>";

                }elseif($row['status']=='1'){
                    
                    echo "<td style='background-color: grey; color: white'> EXPIRED </td>";

                }else{
                    echo "<td style='background-color: red; color: white'> REVOKED </td>";
                    
                }
                
                        
        }
   
}else{
    echo json_encode("ID not provided");
}

?>