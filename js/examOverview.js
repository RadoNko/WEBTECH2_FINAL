$(document).ready(function () {
  /*Render basic website list with all exams*/
  $.ajax({
    method: "GET",
    url: origin + "/Final/router/teacher",
    dataType: "json",
    success: function (teachers) {
      $.ajax({
        method: "GET",
        url: origin + "/Final/router/exam",
        dataType: "json",
        success: function (data) {
          let items = [];
          $.each(data, function (key, val) {
            let active = val["is_active"] == 0 ? "active" : "not active";
            let teacher = teachers.find((t) => t.id === val["id"]);
            let teacherName = teacher ? teacher.username : "undefined";
            items.push(
              "<li class='list-group-item list-group-item-action' id='" +
                val["id"] +
                "'><div class='d-flex w-100 justify-content-between'><h5 class='mb-1'>" +
                val["name"] +
                "</h5><small><button type='button' class='btn btn-outline-dark activity-button'>" +
                active +
                "</button>" +
                "</small></div><small>Teacher username: " +
                teacherName +
                "</small><br><small>Code: " +
                val["code"] +
                "</small></li>"
            );
          });
          $("<ul/>", {
            class: "list-group list-group-flush",
            html: items.join(""),
          }).appendTo("#listBody");
        },
      });
    },
  });
  // Action to show modal on activity button click
  $(document).on("click", ".activity-button", function () {
    console.log($(this).parent().parent().parent().attr("id"));
    let active = $(this).text() == "active" ? "active" : "not active";
    // Make text for active/non active exam
    if (active == "active") {
      $("#deleteApprovalTitle").text(
        "Stop  '" + $(this).parent().prev().text() + "'!"
      );
      $("#deleteApprovalBody").text(
        "Are You sure you want to stop exam with name: '" +
          $(this).parent().prev().text() +
          "'? If You make this exam inactive, students will not be able to start this test anymore. Do You wish to proceed?"
      );
    } else {
      $("#deleteApprovalTitle").text(
        "Start  '" + $(this).parent().prev().text() + "'!"
      );
      $("#deleteApprovalBody").text(
        "Are You sure you want to start exam with name: '" +
          $(this).parent().prev().text() +
          "'? If You make this exam active, students will be able to start working on this exam. Do You wish to proceed?"
      );
    }
    $("#deleteApprovalModal").modal("show");
  });
});
