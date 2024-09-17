$(document).ready (function(){
    reloadTable();

    function reloadTable(page) {
        $.ajax({
          url: "includes/documentsautoreloadtable.php",
          type: "POST",
          data: {pageno: page},
          dataType: "HTML",
          success: function (data) {
            $("#DocumentsTableBody").html(data);
            // updatePaginationControls(page);
          },
          error: function (xhr, status, error) {
            console.error("Error fetching table data:", error);
          },
        });
    }

    //For populating the DocumentsViewModal
    $(document).on("click", ".viewDocumentsButton", function (event) { 
      event.preventDefault();

      var request_id = $(this).data("id");
      var resident_id = $(this).data("resident_id");
      var date_requested = $(this).data("date-requested");
      var expiration = $(this).data("expiration-date");
      var first_name = $(this).data("first-name");
      var middle_name = $(this).data("middle-name");
      var last_name = $(this).data("last-name");
      var suffix = $(this).data("suffix");
      var house_no = $(this).data("house-no");
      var street_name = $(this).data("street-name");
      var subdivision = $(this).data("subdivision")
      var sex = $(this).data("sex");
      var age = $(this).data("age");
      var docu_type = $(this).data("docu-desc");
      var presented_id = $(this).data("presented-id");
      var ID_number = $(this).data("id_num");
      var purpose = $(this).data("purpose");
      var status = $(this).data("status");
      var date_edited =  $(this).data("last-edited");
      var date_deleted = $(this).data("last-deleted");

      $("#Request_ID").html('<b>Request ID:  </b>'+request_id);
      $("#Date_issued").html('<b>Date Issued:  </b>'+date_requested);
      $("#Expiration_Date").html('<b>Expiration Date:  </b>'+expiration);
      $("#Fullname").html('<b>Fullname:  </b>'+first_name+' '+ middle_name+','+' '+ last_name+' '+suffix);
      $("#Address").html('<b>Address:</b> '+house_no+' '+street_name+' '+subdivision+' Camarin Caloocan City');
      $("#Sex").html('<b>Sex: </b>' +sex);
      $("#Age").html('<b>Age (Upon Request): </b>' +age+" Years Old");
      $("#Document_Desc").html('<b>Document Description:  </b>' +docu_type);
      $("#Presented_ID").html('<b>Presented ID:  </b>' +presented_id);
      $("#ID_num").html('<b>ID Number:  </b>' +ID_number);
      $("#Purpose").html('<b>Purpose:  </b>' +purpose);
      $("#resident_id").val(resident_id);
      $("#request_id").val(request_id);
      $("#status").val(status);
      $("#editDocumentbtn").attr("data-request_id", request_id);
      $("#editDocumentbtn").attr("data-expiration", expiration);
      $("#editDocumentbtn").attr("data-presentedid", presented_id);
      $("#editDocumentbtn").attr("data-id_num", ID_number);


      //Hide the deleted date when nothing to show
      if(date_deleted == ""){
          $(".deleted_date").prop("hidden", true);
          console.log("Date Deleted is null");
      }else{  
          $(".deleted_date").prop("hidden", false);
          $("#Deleted_date").html('<b>Last Edited:  </b>' +date_deleted);
      }
      
      //Hide the last edited date when nothing to show
      if(date_edited === ""){
        $(".last_edited").prop("hidden", true);
        console.log("Date Edited is null");
      }else{
        $(".last_edited").prop("hidden", false);
        $("#Last_Edited").html('<b>Edited Date:  </b>' +date_edited);
      }

      //For the status display on the table
      switch(status){
        case 0:
          $("#Status").html('<b>Status: </b>' + "<b style='color: green';>ACTIVE</b>");
        break;
        case 1:
          $("#Status").html('<b>Status: </b>' + "<b style='color: grey';>EXPIRED</b>");
        break;
        case 2:
          $("#Status").html('<b>Status: </b>' + "<b style='color: red';>REVOKED</b>");
        break;
        default:
          $("#Status").html('<b>Status: </b>' + "<b>Unknown Status</b>");
      }

      //For the revoke button change depending to the status
      switch(status){
        case 2:
          $("#revokebtn").removeClass("btn-danger");
          $("#revokebtn").addClass("btn-warning").text("Restore");
        break;
        case 0:
          $("#revokebtn").removeClass("btn-warning");
          $("#revokebtn").addClass("btn-danger").text("Revoke");

        break;
        case 1:
          $("#revokebtn").prop("hidden", true);
          $("#revokebtn").addClass("btn-warning").text("Restore");

        break;
        default:

      }
    })

    //To populate the Edit Document Modal
    $("#editDocumentbtn").click(function(e){
      e.preventDefault();

      var expiration = $(this).data("expiration");
      var id_num = $(this).data("id_num");
      var presented_id = $(this).data("presentedid");
      var reqid=$(this).data("request_id");
      console.log(reqid)


      $("#expiration").val(expiration);
      $("#presented_id").val(presented_id);
      $("#id_num").val(id_num);
      $("#requestid").val(reqid);
      
    });

    //Edit function of the document
    $("#EditDocumentModalForm").submit(function (e) {
      e.preventDefault();
    
      var formdata = new FormData(this);
      formdata.append("OPERATION", "EDIT");
    
      $.ajax({
        url: "includes/documentsoperation.php",
        method: "POST",
        dataType: "JSON",
        processData: false, 
        contentType: false, 
        data: formdata,    
        success: function(response) {
          // Check the response from the server
          if (response.success) {
            // Hide modal
            $("#EditDocumentModal").modal("hide");
            reloadTable();
    
            // Show success alert
            swal({
              title: "Edit Document",
              text: "Document Edited Successfully!",
              icon: "success",
              button: "Close",
            });
          } else {
            // Hide modal
            $("#EditDocumentModal").modal("hide");
            reloadTable()
    
            // Show error alert
            swal({
              icon: "error",
              title: "Oops...",
              text: "Something went wrong!",
            });
          }
        },
        error: function(xhr, status, error) {
          // Hide modal
          $("#EditDocumentModal").modal("hide");
          reloadTable();
          // Show error alert
          swal({
            icon: "error",
            title: "Oops...",
            text: "Something went wrong!",
          });
    
          // Log error for debugging
          console.error(xhr.responseText);
        }
      });
    });
    

    //For populate the view resident from docu modal
    $(document).on("click","#viewResidentfromDocu", function(){
      var residentid = $("#resident_id").val();
      $('#nav-home-tab').tab('show');

      $.ajax({
        url: "includes/fetchresidentdetails.php",
        type: "POST",
        data: {id: residentid},
        dataType: "JSON",
        success: function (response) {

          var imagepath = "includes/img/resident_img/"+response.img_filename;

          $("#viewresident_id").val(response.resident_id)
          $("#fname").val(response.first_name);
          $("#mname").val(response.middle_name);
          $("#lname").val(response.last_name);
          $("#house_no").val(response.house_num);
          $("#street").val(response.street);
          $("#subd").val(response.subdivision);
          $("#sex").val(response.sex);
          $("#marital_status").val(response.marital_status);
          $("#birth_date").val(response.birth_date);
          $("#birth_place").val(response.birth_place);
          $("#cp_number").val(response.cellphone_num);
          $("#is_a_voter").val(response.is_a_voter);
          $("#rsince").val(response.resident_since);
          $("#viewimagePreview").prop("src", imagepath);
          $("#backbtntodocu").prop("hidden", false);

        },
        error: function (xhr, status, error) {
          console.error("Error fetching table data:", error);
        },
      });
    })

    //For the back button on the resident view modal
    $(document).on("click","#backbtntodocu", function(){
      $(this).prop("hidden", true);

      $("#ViewResidentModal").modal("hide");
      $("#DocumentDetailsModal").modal("show");

    })

    //AJAX request for the clearance tab and table of the modal
  $(document).on("click", "#nav-clearance-tab", function () {
    var resident_id = $('#resident_id').val();

    console.log(resident_id);
    
      $.ajax({
        url: "includes/get-resident-docu-request.php",
        type: "POST",
        data: {resident_id: resident_id},
        dataType: "HTML",
        success: function (data) {
          $("#ResidentRequestTable tbody").html(data);
        },
        error: function (xhr, status, error) {
          console.error("Error fetching table data:", error);
        },
      });

  });

  //For the function of the revoke or restore button
  $("#revokebtn").click(function (e) { 
    e.preventDefault();

    var request_id = $('#request_id').val();
    var status = $('#status').val();

    if(status=="2"){
      swal({
        title: "Are you sure?",
        text: "Restoring the certificate will continue it's validity.",
        icon: "warning",
        buttons: ["Cancel","Yes"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "includes/documentsoperation.php",
            type: "POST",
            data: {OPERATION: "RESTORE", request_id: request_id},
            success: function(){
  
              swal("The certificate has been RESTORED!", {
                icon: "success"
              });
              
              $("#DocumentDetailsModal").modal("hide");
              reloadTable();
              
            },
            error: function(xhr,status,error){
              swal("Error!", "Failed to restore the entry.", "error");
            },
          })
     
        } else {
          swal("The certificate is not RESTORED!.");
        }
      });

    }else{
      console.log(request_id, status);
      swal({
        title: "Are you sure?",
        text: "Revoking the certificate VOIDS a certificate validity",
        icon: "warning",
        buttons: ["Cancel","Yes"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "includes/documentsoperation.php",
            type: "POST",
            data: {OPERATION: "REVOKE", request_id: request_id},
            success: function(){
  
              swal("The certificate has been REVOKED!", {
                icon: "success"
              });
  
              reloadTable();
              $("#DocumentDetailsModal").modal("hide");

              
            },
            error: function(xhr,status,error){
              swal("Error!", "Failed to revoke the entry.", "error");
            },
          })
     
        } else {
          swal("The certificate is not revoked");
        }
      });
    }
    
  });
 
    
    
});