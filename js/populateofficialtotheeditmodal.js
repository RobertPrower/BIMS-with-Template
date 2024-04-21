$(document).on('click', '.editOfficialBtn', function(){
  
  var id = $(this).data('official-id');
  var official_fullname = $(this).data('official-fullname');
  var official_position = $(this).data('official-position');

  $('#EditOfficialModal input[name="official_id"]').val(id);
  $('#EditOfficialModal input[name="fullname"]').val(official_fullname);
  $('#EditOfficialModal input[name="position"]').val(official_position);
  
  $("#EditOfficialModal").modal("show");

});