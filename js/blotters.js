$(document).ready(function () {

  reloadTable();

  //To Reload the page
  function reloadTable(page) {
    $.ajax({
      url: "includes/blottersoperation.php",
      type: "POST",
      data: { pageno: page, operation: "FETCH_MAIN_TABLE"},
      dataType: "HTML",
      success: function (data) {
        $("#BlotterTable tbody").html(data);
        updatePaginationControls(page);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching table data:", error);
      },
    });
  }

  //Reload the table of the Deleted Entries
  function reloadDeletedEntries(page) {
    $.ajax({
     url: "includes/blottersoperation.php",
      type: "POST",
      data: { pageno: page, operation: "SHOW_DELETED" },
      dataType: "HTML",
      success: function (data) {
        $("#BlotterTable tbody").html(data);
        updateDeletedPaginationControls(page);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching table data:", error);
      },
    });
  }

  //Update the pagination controls every operation
  function updatePaginationControls(currentPage) {
    $.ajax({
     url: "includes/blottersoperation.php",
      type: "POST",
      data: { pageno: currentPage, operation: "PAGINATION" },
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

  //Update the pagination controls every search
  function updateSearchPaginationControls(query, currentPage) {
    $.ajax({
     url: "includes/blottersoperation.php",
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

  //Update the pagination controls every flipped of the show deleted entries switch
  function updateDeletedPaginationControls(currentPage, query) {
    $.ajax({
     url: "includes/blottersoperation.php",
      type: "POST",
      data: { pageno: currentPage, search: query, operation: "PAGINATION_FOR_DEL_REC" },
      success: function (data) {
        $(".pagination").html(data);
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
        console.error("Error updating pagination data:", error);
      },
    });
  }

  //Function to search for entries
  function fetchResults(query, page = 1) {
    if ($("#showdeletedentries").is(":checked")) {
      console.log("Deleted Entries switch has been on");
      $.ajax({
       url: "includes/blottersoperation.php",
        type: "POST",
        data: { search: query, page: page, operation: "DELETED_SEARCH" },
        success: function (data) {
          $("#BlotterTableBody").html(data);
          updateDeletedPaginationControls(page, query);
        },
        error: function (xhr, status, error) {
          console.error("Error fetching search results:", error);
        },
      });
    } else {
      console.log("Deleted Entries switch has been off");
      $.ajax({
       url: "includes/blottersoperation.php",
        type: "POST",
        data: { search: query, page: page, operation: "SEARCH" },
        success: function (data) {
          $("#BlotterTableBody").html(data);
          updateSearchPaginationControls(query, page);
        },
        error: function (xhr, status, error) {
          console.error("Error fetching search results:", error);
        },
      });
    }
  }

  //For the search box
  $("#searchbox").on("keyup", function () {
    let query = $(this).val();

    if (query.length > 0) {
      //Fetch the results by the fetchResults function above
      fetchResults(query);
    } else {
      if ($("#showdeletedentries").is(":checked")) {
        //If query is less than 2 character just reload the table
        reloadDeletedEntries(1);
      } else {
        reloadTable();
      }
    }
  });

  //Show the deleted records when the switch is flipped
  $("#showdeletedentries").click(function () {
    let query = $("#searchbox").val(); // Get the current search query
    if ($(this).is(":checked")) {
      console.log("Checkbox ON - Show Deleted Entries");
      reloadDeletedEntries(1); // Reload deleted entries
    } else {
      console.log("Checkbox OFF - Hide Deleted Entries");
      reloadTable(1); // Reload all entries
    }
  });

  //For pagination control function and make it dynamic
  $(document).on("click", ".pagination-control", function (e) {
    e.preventDefault();

    var page = $(this).data("page");
    console.log("Page:", page);

    $(".main-pagination .pagination-control").removeClass("active");
    $(this).parent().addClass("active");

    if ($("#showdeletedentries").is(":checked")) {
      reloadDeletedEntries(page);
      updateDeletedPaginationControls(page);
    } else {
      reloadTable(page);
      updatePaginationControls(page);
    }
  });

  $(document).on("click",".viewbtn",function(e){
    e.preventDefault();
    $('#complainant_respondent_tab').tab('show');
    var complainant_first_name = $(this).data('complainant_first_name');
    var complainant_middle_name = $(this).data('complainant_middle_name');
    var complainant_last_name = $(this).data('complainant_last_name');
    var complainant_suffix = $(this).data('complainant_suffix');

    var respondent_first_name = $(this).data('respondent_first_name');
    var respondent_middle_name = $(this).data('respondent_middle_name');
    var respondent_last_name = $(this).data('respondent_last_name');
    var respondent_suffix = $(this).data('respondent_suffix');

    var complainant_address = $(this).data('complainant_address');
    var respondent_address = $(this).data('respondent_address');
    var complainant_filename = $(this).data('complainant_filename');
    var respondent_filename = $(this).data('respondent_filename');
    var blotter_id = $(this).data('blotter_id');
    var complainant_no = $(this).data('complainant_no');
    var respondent_no = $(this).data('respondent_no');
    var complainant_status = $(this).data('complainant_status');
    var respondent_status = $(this).data('respondent_status');


    $("#fname").val(complainant_first_name);
    $("#mname").val(complainant_middle_name); 
    $("#lname").val(complainant_last_name);
    $("#suffix").val(complainant_suffix);
    $("#address").val(complainant_address);

    $("#fname_res").val(respondent_first_name);
    $("#mname_res").val(respondent_middle_name);
    $("#lname_res").val(respondent_last_name);
    $("#suffix_res").val(respondent_suffix);
    $("#address_res").val(respondent_address);

    $("#blotter_id").val(blotter_id);
    $("#complainant_id").val(complainant_no);
    $("#respondent_id").val(respondent_no);
    $("#respondent_status").val(respondent_status);
    $("#complainant_status").val(complainant_status);
    $("#respondent_status").val(respondent_status);
    $("#display_complainant_status").text(complainant_status);
    $("#display_respondent_status").text(respondent_status);


    if(complainant_status == "Resident"){
      $("#ComplainantImg").attr("src", "includes/img/resident_img/"+complainant_filename);
    }else{
      $("#ComplainantImg").attr("src", "includes/img/non_resident_img/"+complainant_filename);
    }

    if(respondent_status == "Resident"){
      $("#RespondentImg").attr("src", "includes/img/resident_img/"+respondent_filename);
    }else{
      $("#RespondentImg").attr("src", "includes/img/non_resident_img/"+respondent_filename);
    }


  })

  $("#other_complainants_tab").click(function (e) { 
    e.preventDefault();
    var blotter_id = $("#blotter_id").val();
    $.ajax({
      type: "POST",
      url: "includes/blottersoperation.php",
      data: {operation: "FETCH_OTHER_COMPLAINANTS_MODAL", blotter_id, blotter_id},
      dataType: "HTML",
      success: function (response) {

        $("#Complainant").html(response);
        
      },error: function(xhr, status, error) {
        console.error('Error fetching other complainants details:', error);
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Something went wrong!"
        });
      }
    });
    
  });


  $("#other_respondents_tab").click(function (e) { 
    var blotter_id = $("#blotter_id").val();
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "includes/blottersoperation.php",
      data: {operation: "FETCH_OTHER_RESPONDENTS_MODAL", blotter_id: blotter_id},
      dataType: "HTML",
      success: function (response) {

        $("#Respondent").html(response);
        
      },error: function(xhr, status, error) {
        console.error('Error fetching other respondents details:', error);
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Something went wrong!"
        });
      }
    });
    
  });

  $(document).on("click","#case_details_tab",function (e) { 
    e.preventDefault();
    var blotter_id = $("#blotter_id").val();
    console.log("case details has been press")
    $.ajax({
      type: "POST",
      url: "includes/blottersoperation.php",
      data: {operation: "FETCH_OTHER_CASE_DETAILS_MODAL", blotter_id: blotter_id},
      dataType: "JSON",
      success: function (response) {
        console.log(response);

        $("#schedule_date").val(response.schedule_date);
        $("#schedule_starttime").val(response.starttime);
        
      },error: function(xhr, status, error) {
        console.error('Error fetching case details:', error);
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Something went wrong!"
        });
      }
    });
    
  });
  
});