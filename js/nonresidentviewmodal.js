$(document).ready(function(){
    function DocuRequestloadTable(page) {

        var nresidentid = $("#viewnonresident_id").val();

        $.ajax({
          url: "includes/modaloperation.php",
          type: "POST",
          data: { pageno: page, nresident_id: nresidentid, operation: "NONRES_DOCREQ_FETCH_TABLE" },
          dataType: "HTML",
          success: function (data) {
            $("#NonResidentRequestTable tbody").html(data);
            updatePaginationControls(page);
          },
          error: function (xhr, status, error) {
            console.error("Error fetching table data:", error);
          },
        });
    }

    function updatePaginationControls(currentPage) {
        var nresidentid = $("#viewnonresident_id").val();

        $.ajax({
          url: "includes/modaloperation.php",
          type: "POST",
          data: { pageno: currentPage, operation: "NONRES_DOCREQ_PAGINATION", nresident_id: nresidentid },
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
    $(document).on("click", ".nrdocmodal-pagination-control", function (e) {
        e.preventDefault();

        var page = $(this).data("page");

        $(".modal-pagination .modal-page-item").removeClass("active");
        $(this).parent().addClass("active");

        DocuRequestloadTable(page);
        PagControlsForRequestedDocs(page);
    });

    //Load the Resident Docu request table once the clearance tab was clicked
    $(document).on("click", "#open-clearance-tab", function () {
        var nresident_id = $("#viewnonresident_id").val();
    
        $("#nonres_clearance-tab").tab("show");

        console.log(nresident_id);

        DocuRequestloadTable();
        updatePaginationControls();
        
    });
});