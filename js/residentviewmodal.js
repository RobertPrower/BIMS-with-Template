$(document).ready(function(){
    function DocuRequestloadTable(page) {

        var residentid = $("#viewresident_id").val();

        $.ajax({
          url: "includes/get-resident-docu-request.php",
          type: "POST",
          data: { pageno: page, resident_id: residentid, OPERATION: "FETCH_TABLE" },
          dataType: "HTML",
          success: function (data) {
            $("#ResidentRequestTable tbody").html(data);
            updatePaginationControls(page);
          },
          error: function (xhr, status, error) {
            console.error("Error fetching table data:", error);
          },
        });
    }

    function updatePaginationControls(currentPage) {
        var residentid = $("#viewresident_id").val();

        $.ajax({
          url: "includes/get-resident-docu-request.php",
          type: "POST",
          data: { pageno: currentPage, OPERATION: "PAGINATION", resident_id: residentid },
          dataType: "HTML",
          success: function (data) {
            $(".modal-pagination").html(data);
  
          //Prevent the pagination from showing when the entries is less than 10 entries
          var noofpageitems = $(".modal-pagination-control").length;
          switch(noofpageitems){
            case 1 :
              $("#modalpagenav").prop("hidden", true);
            break;
            default:
              $("#modalpagenav").prop("hidden", false);
          }
  
  
          },
          error: function (xhr, status, error) {
            console.error("Error updating pagination data:", error);
          },
        });
      }

    //Click event in triggering the pagination control of the table
    $(document).on("click", ".modal-pagination-control", function (e) {
        e.preventDefault();

        var residentid = $("#res_id_to_fetch").val();
        var page = $(this).data("page");

        $(".modal-pagination .modal-page-item").removeClass("active");
        $(this).parent().addClass("active");

        DocuRequestloadTable(page);
        PagControlsForRequestedDocs(residentid, page);
    });

    //Load the Resident Docu request table once the clearance tab was clicked
    $(document).on("click", "#nav-clearance-tab", function () {
        var resident_id = $("#viewresident_id").val();

        console.log(resident_id);

        DocuRequestloadTable();
        updatePaginationControls();
        
    });
});