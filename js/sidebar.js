$(document).ready(function () {

    $(".sidebar-body-menu li a").removeClass("active");

   const Pagename = $(".main-title").text();
   console.log(Pagename);

   switch(Pagename){
    case "Manage Residents":
        $("#resident_btn").addClass("active");
    break;
    case "Manage Certificates" :
    case "Create Tricycle Pedicab Regulatory Services":
    case "Create Fencing Permits" :
    case "Create Business Permit":
    case "Create Building Permits":
    case "Create Fencing Permits":
    case "Create Excavation Permits":
    case "Create Certificate of Indigency":
    case "Create Certificate of Good Moral":
    case "Create Certificate of Residency":
    case "Create Certificate of First Time Job Seeker":
    case "Generate Reports":
    case "Create Certificates":
        $("#certificates_btn").addClass("active");
    break;
    case "Manage Blotter Schedule":
    case "Manage Blotters":
    case "Create Blotter":
        $("#blotter_btn").addClass("active");
    break;
    case "Dashboard":
        $("#dashboard_btn").addClass("active");
    break;
    case "Manage Non-Residents":
        $("#non_resident_btn").addClass("active");
    break;
    case "Manage Settings":
    case "Select Audit Trail":
    case "Residents Audit Trail":
    case "Non Resident Audit Trail":
    case "Documents Audit Trail":
    case "Manage Users":
    case "Manage Brgy Details":
    

        $("#settings_btn").addClass("active");
    break;
   }
});