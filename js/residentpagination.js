$(document).ready(function () {
  function loadpage(page) {
    $.ajax({
      url: "",
      type: "GET",
      data: {
        page: page,
        items_per_page: 10,
      },
      dataType: "JSON",
      success: function (response) {
        $("#residentTable tbody").empty();

        response.array.forEach(function (row) {
          $("#residentTable tbody").append(
            "<tr>" +
              "<td hidden>" +
              htmlspecialchars(row["resident_id"]) +
              "</td>" +
              "<td>" +
              htmlspecialchars(row["date_recorded"]) +
              "</td>" +
              "<td>" +
              htmlspecialchars(row["last_name"]) +
              ", " +
              htmlspecialchars(row["first_name"]) +
              " " +
              htmlspecialchars(row["middle_name"]) +
              " " +
              htmlspecialchars(row["suffix"]) +
              "</td>" +
              "<td>" +
              htmlspecialchars(row["house_number"]) +
              ", " +
              htmlspecialchars(row["street_name"]) +
              ", " +
              htmlspecialchars(row["subdivision"]) +
              "</td>" +
              '<td class="text-center">' +
              htmlspecialchars(row["resident_since"]) +
              "</td>" +
              "<td>" +
              htmlspecialchars(row["sex"]) +
              "</td>" +
              "<td>" +
              htmlspecialchars(row["marital_status"]) +
              "</td>" +
              "<td>" +
              htmlspecialchars(row["birth_date"]) +
              "</td>" +
              "<td>" +
              htmlspecialchars(row["birth_place"]) +
              "</td>" +
              '<td class="text-center">' +
              htmlspecialchars(row["cellphone_number"]) +
              "</td>" +
              "<td>" +
              (row["is_a_voter"] ? "YES" : "NO") +
              "</td>" +
              '<td style="width: 35%;">' +
              '<div class="btn-group text-center">' +
              '<button class="btn btn-primary mx-1 viewResidentButton" data-id="' +
              htmlspecialchars(row["resident_id"]) +
              '">View</button>' +
              '<button class="btn btn-success mx-1 editResidentButton" data-id="' +
              htmlspecialchars(row["resident_id"]) +
              '">Edit</button>' +
              '<button class="btn btn-danger mx-1 deleteResidentButton" data-id="' +
              htmlspecialchars(row["resident_id"]) +
              '">Delete</button>' +
              "</div>" +
              "</td>" +
              "</tr>"
          );
        });

        attachEventHandlers();
      },
      error: function (xhr, status, error) {
        console.error("Error fetch data:", error);
      },
    });

    function attachEventHandlers() {}
  }
});
