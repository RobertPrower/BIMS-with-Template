$(document).ready(function () {

    $(".sidebar-body-menu li a").removeClass("active");

   const Pagename = $(".main-title").text();
   console.log(Pagename);

   switch(Pagename){
    case "Manage Residents":
        $("#resident_btn").addClass("active");
    break;
    case "Manage Documents":
        $("#documents_btn").addClass("active");
    break;
    case "Manage Blotters":
        $("#blotter_btn").addClass("active");
    break;
    case "Dashboard":
        $("#dashboard_btn").addClass("active");
    break;
   }
});