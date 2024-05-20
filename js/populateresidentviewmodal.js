//Script for the View Button
$(document).on("click", ".viewResidentButton", function () {

  event.preventDefault();
  var resident_id = $(this).data("id");
  var first_name = $(this).data("first-name");
  var middle_name = $(this).data("middle-name");
  var last_name = $(this).data("last-name");
  var suffix= $(this).data("suffix");
  var house_no = $(this).data("house-no");
  var street_name = $(this).data("street-name");
  var subdivision = $(this).data("subdivision");
  var sex = $(this).data("sex");
  var marital_status = $(this).data("marital-status");
  var birth_date = $(this).data("birth-date");
  var formattedBirthDate = new Date(birth_date).toLocaleDateString("en-US");
  var birthplace = $(this).data("birth-place");
  var phone_number = $(this).data("phone-number");
  var is_a_voter = $(this).data("isa-voter");
  var resident_since = $(this).data("rsince");

  // Populate the modal with the retrieved data
  $('#ViewResidentModal input[name="resident_id"]').val(resident_id);
  $('#ViewResidentModal input[name="fname"]').val(first_name);
  $('#ViewResidentModal input[name="mname"]').val(middle_name);
  $('#ViewResidentModal input[name="lname"]').val(last_name);
  $('#ViewResidentModal input[name="suffix"]').val(suffix);
  $('#ViewResidentModal input[name="house_no"]').val(house_no);
  $('#ViewResidentModal input[name="street"]').val(street_name);
  $('#ViewResidentModal input[name="subd"]').val(subdivision);
  $('#ViewResidentModal select[name="sex"]').val(sex);
  $('#ViewResidentModal select[name="marital_status"]').val(marital_status);
  $('#ViewResidentModal input[name="birth_date"]').val(birth_date);
  $('#ViewResidentModal input[name="birth_place"]').val(birthplace);
  $('#ViewResidentModal input[name="cp_number"]').val(phone_number);
  $('#ViewResidentModal select[name="is_a_voter"]').val(is_a_voter);
  $('#ViewResidentModal input[name="r_since"]').val(resident_since);

  // Display the modal
  $("#ViewResidentModal").modal("show");
  console.log(resident_since);
  
});
