$(document).ready(function(){
    function DocuRequestloadTable(page) {

        var residentid = $("#viewresident_id").val();

        $.ajax({
          url: "includes/modaloperation.php",
          type: "POST",
          data: { pageno: page, resident_id: residentid, operation: "RES_DOCUREQ_FETCH_TABLE" },
          dataType: "HTML",
          success: function (data) {
            $("#ResidentRequestTable tbody").html(data);
            updatePaginationControls(page, 0,0);
          },
          error: function (xhr, status, error) {
            console.error("Error fetching table data:", error);
          },
        });
    }

    function updatePaginationControls(currentPage, whattable, whatoperation) {
        var residentid = $("#viewresident_id").val();

        if(whattable == 1){
          var table = "blottertab-pagination-control"
        }else if(whattable == 0){
          var table = "docutab-pagination-control"
        }else{
          var table
        }

        if(whatoperation == 0){
          var operation = "RES_DOCUREQ_PAGINATION"
        }else if(whatoperation == 1){
          var operation = "RES_BLOTTER_PAGINATION"
        }else{
          var operation
        }

        $.ajax({
          url: "includes/modaloperation.php",
          type: "POST",
          data: { pageno: currentPage, operation: operation, resident_id: residentid, whattable: table },
          dataType: "HTML",
          success: function (data) {
            if(operation = 0){
              $(".docu-pagination").html(data);
            }else if(operation == 1){
              $(".blotter-pagination").html(data);
            }
            
  
          //Prevent the pagination from showing when the entries is less than 10 entries
          var noofpageitems = $(".blotter_pagination").length;

          if(noofpageitems <=5){
              $("#modalpagenav").prop("hidden", true);
          }else{
              $("#modalpagenav").prop("hidden", false);
          }
  
  
          },
          error: function (xhr, status, error) {
            console.error("Error updating pagination data:", error);
          },
        });
      }

    //Click event in triggering the pagination control of the table
    $(document).on("click", ".doctab-pagination-control", function (e) {
        e.preventDefault();

        var residentid = $("#res_id_to_fetch").val();
        var page = $(this).data("page");

        $(".modal-pagination .modal-page-item").removeClass("active");
        $(this).parent().addClass("active");

        DocuRequestloadTable(page);
        updatePaginationControls(page, 0, 0);
    });

    //Load the Resident Docu request table once the clearance tab was clicked
    $(document).on("click", "#nav-clearance-tab", function () {
        var resident_id = $("#viewresident_id").val();

        console.log(resident_id);

        DocuRequestloadTable();
        updatePaginationControls(1,0,0);
        
    });

    $(document).on('click','#nav-blotters-tab', function(){
      var resident_id = $("#viewresident_id").val();

      $.ajax({
        type: "POST",
        url: "includes/modaloperation.php",
        data: {operation: "FETCH_RES_BLOTTER_INVOLVED", resident_id: resident_id},
        dataType: "HTML",
        success: function (response) {

          $("#ResidentBlotterTable tbody").html(response);
          
        }
      });


    })
});