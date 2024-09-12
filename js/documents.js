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

    $(document).on("click", ".viewDocumentsButton", function (event) { 
      event.preventDefault();

      console.log("View Button has been click!")

      var request_id = $(this).data("id");
      var date_requested = $(this).data("date-requested");
      var first_name = $(this).data("first-name");
      var middle_name = $(this).data("middle-name");
      var last_name = $(this).data("last-name");
      var suffix = $(this).data("suffix");
      var house_no = $(this).data("house-no");
      var street_name = $(this).data("street-name");
      var subdivision = $(this).data("subdivision")
      var sex = $(this).data("sex");
      var age = $(this).data("age");
      var presented_id = $(this).data("presented_id");
      var ID_number = $(this).data("ID-number");
      var status = $(this).data("status");

      $("#Request_ID").append(request_id);
      $("#Date_issued").append(date_requested);
      $("#Fullname").append(first_name+' '+ middle_name+','+' '+ last_name);
      $("#Address").val();

    })
    
    $(document).on("hide","#DocumentDetailsModal",function(){

      console.log("The Document Modal has been hidden");

    });
});