$(document).ready(function () {

    reloadTable(1);

    $("#start_date, #end_date").datepicker({
      format: "yyyy-mm-dd",
      autoclose: true,
    });

    function reloadTable(page) {
        $.ajax({
        url: "includes/documentsaudittrailoperation.php",
        type: "POST",
        data: { pageno: page, operation: "RESIDENT_FETCH_TABLE"  },
        dataType: "HTML",
        success: function (data) {
            $("#ResidentAuditTrailTable tbody").html(data);
            updatePaginationControls(page);
        },
        error: function (xhr, status, error) {
            console.error("Error fetching table data:", error);
        },
        });
    }

    function updatePaginationControls(currentPage) {
        $.ajax({
          url: "includes/documentsaudittrailoperation.php",
          type: "POST",
          data: { pageno: currentPage, operation: "FETCH_RESIDENT_PAGINATION" },
          dataType: "HTML",
          success: function (data) {
            $(".main-pagination").html(data);
            var noofpageitems = $(".pagination-control").length;
            console.log(noofpageitems);
            //Prevent the pagination from showing when the entries is less than 10
            switch(noofpageitems){
              case 1 :
                $("#pagenav").prop("hidden", true);
              break;
              default:
                $("#pagenav").prop("hidden", false);
    
            }
          },
          error: function (xhr, status, error) {
            console.error("Error updating pagination data:", error);
          },
        });
      }

        //Function to search for entries
      function fetchResults(query, page = 1) {

        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();

        if(!start_date && !end_date){
          $.ajax({
            url: "includes/documentsaudittrailoperation.php",
            type: "POST",
            data: { search: query, page: page, operation: "RESIDENT_AUDIT_SEARCH" },
            success: function (data) {
              $("#ResidentAuditTrailTable tbody").html(data);
              updateSearchPaginationControls(page, query);
            },
            error: function (xhr, status, error) {
              console.error("Error fetching search results:", error);
            },
          });
        }else{
          $.ajax({
            url: "includes/documentsaudittrailoperation.php",
            type: "POST",
            data: { search: query, page: page, operation: "RESIDENT_AUDIT_SEARCH_WITH_FILTERS", start_date: start_date, end_date: end_date},
            success: function (data) {
              $("#ResidentAuditTrailTable tbody").html(data);
              updateSearchPaginationControls(page, query);
            },
            error: function (xhr, status, error) {
              console.error("Error fetching search results:", error);
            },
          });

        }
    
      }

    
      //Update the pagination controls every search
      function updateSearchPaginationControls(query, currentPage) {
        $.ajax({
          url: "includes/documentsaudittrailoperation.php",
          type: "POST",
          data: {
            search: query,
            pageno: currentPage,
            operation: "SEARCH_PAGINATION",
          },
          success: function (data) {
            $(".main-pagination").html(data);
    
            //Prevent the pagination from showing when the entries is less than 10 entries
            var noofpageitems = $(".pagination-control").length;
            switch(noofpageitems){
              case 1 :
                $("#pagenav").prop("hidden", true);
              break;
              default:
                $("#pagenav").prop("hidden", false);
    
            }
          },
          error: function (xhr, status, error) {
            console.error("Error updating search pagination data:", error);
          },
        });
    }

    function populatefullnamemodal(lname, fname, mname, suffix){
      var fullname = lname + " "+ fname +" "+ mname + " " + suffix;
      $("#fullname").val(fullname); 
    }

    function populatemodal(oldValues){
  
      $("#expiration").val(oldValues.expiration_date);
      $("#id_num").val(oldValues.ID_number);
      $("#presented_id").val(oldValues.presented_id);
      $("#is_deleted").val(oldValues.is_deleted);

    }

      //For the search box
    $("#searchbox").on("keyup", function () {
      let query = $(this).val();

      if (query.length > 0) {

        fetchResults(query);

      } else {
       
          reloadTable();
  
      }
    });

    $("#apply_filters").click(function (e) {
      e.preventDefault();
  
      var start_date = $("#start_date").val();
      var end_date = $("#end_date").val();
  
      if (!start_date || !end_date) {
          Swal.fire({
              title: "Error",
              text: "Please fill the start and end dates.",
              icon: "error"
          });
          return; // Stop further execution
      }
  
      let start = new Date(start_date);
      let end = new Date(end_date);
  
      if (isNaN(start.getTime()) || isNaN(end.getTime())) {
          Swal.fire({
              title: "Error",
              text: "Invalid date values.",
              icon: "error"
          });
          return; // Stop further execution
      }
  
      let previousDate = new Date(start);
      previousDate.setDate(start.getDate() - 1);
  
      if (end.toDateString() === previousDate.toDateString()) {
          Swal.fire({
              title: "Error",
              text: "End date is the previous day of the start date.",
              icon: "error"
          });
          return; // Stop further execution
      }
  
      $.ajax({
          type: "POST",
          url: "includes/documentsaudittrailoperation.php",
          data: { 
              start_date: start_date, 
              end_date: end_date, 
              operation: "RESIDENT_AUDIT_SEARCH_WITH_DATE" 
          },
          dataType: "HTML",
          success: function (response) {
              $("#ResidentAuditTrailTable tbody").html(response);
              updatePaginationControls(1);
          },
          error: function (xhr, status, error) {
              console.error("Error updating search table data:", error);
          }
      });
  });

  $("#clear_filters").click(function (e) { 
    e.preventDefault();

    $("#start_date, #end_date, #searchbox").val('');
    reloadTable(1)
    
  });
  

    $(document).on("click",".viewOldButton",function (event) {
        event.preventDefault();
        $("#ViewDocumentModal").modal("show")


        var residentid = $(this).data("id");
  
        $.ajax({
            url: "includes/documentsaudittrailoperation.php",
            type: "POST",
            data: { audit_id: residentid, operation: "FETCH_RESIDENT_OLD_DETAILS" },
            dataType: "JSON",
            success: function (data) {
              if (data[0].old_entry) {

                var oldValues = JSON.parse(data[0].old_entry);
                var res = data[0]

                console.log(oldValues)

  
                populatemodal(oldValues)
                populatefullnamemodal(res.last_name, res.first_name, res.middle_name, res.suffix)
                $("#certificate_type").val(res.document_desc)
                $("#is_deleted_con").attr("hidden", true);

  
              } else {
                  alert('No old values found for this resident.');
              }
          },error: function (xhr, status, error) {
              console.error("Error fetching table data:", error);
            },
        });
         
        
      }
    );

    $(document).on("click",".viewNewButton",function (event) {
      event.preventDefault();
      $("#ViewDocumentModal").modal("show")


      var residentid = $(this).data("id");

      $.ajax({
          url: "includes/documentsaudittrailoperation.php",
          type: "POST",
          data: { audit_id: residentid, operation: "FETCH_RESIDENT_NEW_DETAILS" },
          dataType: "JSON",
          success: function (data) {
            if (data && data.length > 0 && data[0].new_entry) {

              var oldValues = JSON.parse(data[0].new_entry);
                var res = data[0]

                console.log(oldValues)
  
                populatemodal(oldValues)
                populatefullnamemodal(res.last_name, res.first_name, res.middle_name, res.suffix)
                $("#certificate_type").val(res.document_desc)
                $("#is_deleted_con").attr("hidden", true);


            } else {
                alert('No old values found for this resident.');
            }
        },error: function (xhr, status, error) {
            console.error("Error fetching table data:", error);
          },
      });
       
      
    }
    );

    $(document).on("click",".viewNewEntryButton",function (event) {
      event.preventDefault();
      $("#ViewDocumentModal").modal("show")

      var audit_id = $(this).data("id");

      $.ajax({
          url: "includes/documentsaudittrailoperation.php",
          type: "POST",
          data: { audit_id: audit_id, operation: "FETCH_RESIDENT_NEW_ENTRY" },
          dataType: "JSON",
          success: function (data) {
            var res = data[0]
            let expirationDate = res.expiration_date.replace(/^"/, '').replace(/"$/, '');
            $('#expiration').val(expirationDate);


            console.log(res.presented_id)
            console.log(res.expiration_date)

            $('#presented_id').val(res.presented_id.replace(/^"|"$/, ''));
            $("#id_num").val(res.ID_number);
            $("#is_deleted").val(res.is_deleted);

            populatefullnamemodal(res.last_name, res.first_name, res.middle_name, res.suffix)
            $("#certificate_type").val(res.document_desc)
            $("#is_deleted_con").attr("hidden", true);

        },error: function (xhr, status, error) {
            console.error("Error fetching table data:", error);
          },
      });
       
      
    }
    );

    $(document).on("click",".viewRecoverButton, .viewDeleteButton",function (event) {
      event.preventDefault();
      $("#ViewDocumentModal").modal("show")
      var audit_id = $(this).data("id");

      $.ajax({
          url: "includes/documentsaudittrailoperation.php",
          type: "POST",
          data: { audit_id: audit_id, operation: "FETCH_RESIDENT_RECOVER_DELETE" },
          dataType: "JSON",
          success: function (data) {
            if (data && data.length > 0) {

              var oldValues = JSON.parse(data[0].new_entry);
              var res = data[0]
              var is_deleted = JSON.parse(res.old_entry)

              console.log(oldValues)

              populatemodal(oldValues)
              populatefullnamemodal(res.last_name, res.first_name, res.middle_name, res.suffix)
              $("#certificate_type").val(res.document_desc)
              $("#is_deleted_con").attr("hidden", false);
              $("#is_deleted_con").val(is_deleted);


            } else {
                alert('No old values found for this resident.');
            }
        },error: function (xhr, status, error) {
            console.error("Error fetching table data:", error);
          },
      });
       
      
    }
    );

   





});