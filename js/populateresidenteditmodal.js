//Script for the  Retriving of Data for the Edit Modal.

$(document).on("click", ".editResidentButton", function () {
  var resident_id = $(this).data("id");
  var first_name = $(this).data("first-name");
  var middle_name = $(this).data("middle-name");
  var last_name = $(this).data("last-name");
  var suffix = $(this).data("suffix");
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

  // Populate the modal with the retrieved data
  $('#EditResidentModal input[name="resident_id"]').val(resident_id);
  $('#EditResidentModal input[name="fname"]').val(first_name);
  $('#EditResidentModal input[name="mname"]').val(middle_name);
  $('#EditResidentModal input[name="lname"]').val(last_name);
  $('#EditResidentModal input[name="suffix"]').val(suffix);
  $('#EditResidentModal input[name="house_no"]').val(house_no);
  $('#EditResidentModal input[name="street"]').val(street_name);
  $('#EditResidentModal input[name="subd"]').val(subdivision);
  $('#EditResidentModal select[name="sex"]').val(sex);
  $('#EditResidentModal select[name="marital_status"]').val(marital_status);
  $('#EditResidentModal input[name="birth_date"]').val(birth_date);
  $('#EditResidentModal input[name="birth_place"]').val(birthplace);
  $('#EditResidentModal input[name="cp_number"]').val(phone_number);
  $('#EditResidentModal select[name="is_a_voter"]').val(is_a_voter);

  // Display the modal
  $("#EditResidentModal").modal("show");
  console.log("Suffix is:" + suffix);

});
