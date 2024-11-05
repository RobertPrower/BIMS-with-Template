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

  $(".viewBlotterButton").on("click",function(){
    var complainant_first_name = $(this).data('complainant_first_name');
    var complainant_middle_name = $(this).data('complainant_middle_name');
    var complainant_last_name = $(this).data('complainant_last_name');
    var complainant_suffix = $(this).data('complainant_suffix');

    var respondent_first_name = $(this).data('respondent_first_name');
    var respondent_middle_name = $(this).data('respondent_middle_name');
    var respondent_last_name = $(this).data('respondent_last_name');
    var respondent_suffix = $(this).data('respondent_suffix');

    var complete_address = $(this).data('complete_address');
    var blotter_id = $(this).data('blotter_id');

    $("#fname").val(complainant_first_name);
    $("#mname").val(complainant_middle_name);
    $("#lname").val(complainant_last_name);
    $("#suffix").val(complainant_suffix);

    console.log(complainant_first_name)
    console.log("View button has been click")



  })
  
});