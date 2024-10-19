<?php
        require_once("connecttodb.php");
        
        $sqlquery = "SELECT * FROM vw_nonresident";

        $stmt=$pdo->prepare($sqlquery);
        $stmt -> execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $isResident = 0;
        $pdo = null;
?>
<form action="#" id="SelectNonResidentForm" method="POST" enctype="multipart/form-data">
    <div class="modal fade" id="selectnonresident" name="add" tabindex="-1" aria-labelledby="EditResidentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditResidentModalLabel">View Non-Resident Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                <div class="content pt-2">
                      <div class="users-table table-wrapper">
                        <form id="SelectNonResidentForm">
                            <table class="tablehover NonResidentTable" id="NonResidentTable" style="scale: 98%;">
                                <thead>
                                <tr class="users-table-info">
                    
                                    <!-- <th style="width: 2%;"class="text-center"><input type="checkbox" class="check-all"></th> -->
                                    <th hidden style="width:  1%;"class="text-center nonresident_id" id="nonresident_id">ID</th> 
                                    <th style="width: 15%;"class="text-center">Image</th>
                                    <th style="width: 20%;" class="text-center">Full Name</th>
                                    <th style="width: 25%;" class="text-center">Address</th>
                                    <th style="width: 5%;" class="text-center">Sex</th>
                                    <th style="width: 5%;" class="text-center">Marital Status</th>
                                    <th style="width: 5%;" class="text-center">Birth Date</th>
                                    <th style="width: 5%;" class="text-center">Cellphone Number</th>
                                </tr>
                                </thead>
                                <tbody>
                                
                                
                                <?php
                                    
                                    require('includes/selectpersonalrecords.php');

                               
                                ?>
                                </tbody>
                            
                                
                                <!-- </tbody> -->

                            
                            </table>
                      <!-- End of Table -->
                      </div>
                    </div>
                   
                </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                        </form>


                
            </div>
        </div>
    </div>
</form>