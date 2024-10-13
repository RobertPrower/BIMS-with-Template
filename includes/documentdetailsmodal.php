<!-- Modal -->
<div class="modal fade" id="DocumentDetailsModal" tabindex="-1" aria-labelledby="DocumentDetailsModal" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="DocumentDetailsModal">Document Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">

        <!-- Checker for the revoke button -->
        <input hidden id="status" name="status"/> 
        <!-- Checker for the certiticate_type -->
        <input hidden id="certiticate_type"/>
        <!-- Placeholder for the Request ID To be used for AJAX request-->
        <input type="text" hidden id="request_id" name="request_id"/>
        <!-- Placeholder for the resident or Non resident ID -->
        <input hidden id="resident_id" name="resident_id"/>

        <p id="Request_ID"></p>
        <br>
        <p id="Date_issued"></p> 
        <br>
        <p id="Expiration_Date"></p> 
        <br>
        <p class="last_edited" id="Last_Edited"></p> 
        <br class="last_edited">
        <p class="deleted_date" id="Deleted_Date"></p> 
        <br class="deleted_date">
        <p id="Fullname"></p> 
        <br>
        <p id="Address"></p> 
        <br>
        <p id="Sex"></p>
        <br>
        <p id="Age"></p>
        <br>
        <p id="Document_Desc"></p> 
        <br>
        <p id="Presented_ID"></p> 
        <br>
        <p id="ID_num"></p>   
        <br>
        <p id="Purpose"></p> 
        <br>
        <p class="Business_name" id="Business_name" hidden></p> 
        <br class="Business_name" hidden>
        <p class="Business_address" id="Business_address" hidden></p> 
        <br class="Business_address" hidden>
        <p class="Business_type" id="Business_type" hidden></p> 
        <br class="Business_type" hidden>
        <p class="agency" id="agency" hidden></p> 
        <br class="agency" hidden>
        <p class="Building_address" id="Building_address" hidden></p> 
        <br class="Building_address" hidden>
        <p class="Building_type" id="Building_type" hidden></p> 
        <br class="Building_type" hidden>
        <p class="agency" hidden></p> 
        <p id="Status"></p> 
    </div>
    <div class="modal-footer">

        <form>
            <button type="button" id="viewResidentfromDocu" class="btn btn-primary" data-bs-target="#ViewResidentModal" data-bs-toggle="modal" data-isfordocu="YES">View Resident Details</button>
            <button type="button" id="retrevePDF" data-cert_type="" class="btn btn-info">Reprint</button>
            <button type="button" id="editDocumentbtn" class="btn btn-success" data-bs-target="#EditDocumentModal" data-bs-toggle="modal" data-expiration="" data-presentedid="" data-id_num="" data-request_id="">Edit</button>
            <button type="button" class="btn btn-danger" id="revokebtn">Revoke</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </form>
        
    </div>
    </div>
</div>
</div>
