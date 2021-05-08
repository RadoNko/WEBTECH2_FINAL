$(document).ready(function () {
  let existingExams;
  $("#nameHelp").show();

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
          existingExams = data;
          $.each(data, function (key, val) {
            let active = val["is_active"] == 0 ? "inactive" : "active";
            let teacher = teachers.find((t) => t.id === val["teacher_fk"]);
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
    let active = $(this).text() == "active" ? "active" : "inactive";
    // Make text for active/non active exam
    if (active == "active") {
      $("#toggleExamTitle").text(
        "Stop  '" + $(this).parent().prev().text() + "'!"
      );
      $("#toggleExamBody").text(
        "Are You sure you want to stop exam with name: '" +
          $(this).parent().prev().text() +
          "'? If You make this exam inactive, students will not be able to start this test anymore. Do You wish to proceed?"
      );
      $("#toggleExamButton").text("STOP!");
    } else {
      $("#toggleExamTitle").text(
        "Start  '" + $(this).parent().prev().text() + "'!"
      );
      $("#toggleExamBody").text(
        "Are You sure you want to start exam with name: '" +
          $(this).parent().prev().text() +
          "'? If You make this exam active, students will be able to start working on this exam. Do You wish to proceed?"
      );
      $("#toggleExamButton").text("START!");
    }
    $("#toggleExamButton").attr(
      "exam_id",
      $(this).parent().parent().parent().attr("id")
    );
    $("#toggleExamModal").modal("show");
  });

  // onClick of toggleExamButton send ajax request to toggle exam activity
  $(document).on("click", "#toggleExamButton", function () {
    let examId = $(this).attr("exam_id");
    $.ajax({
      method: "PUT",
      url: origin + "/Final/router/exam/toggle/" + examId,
      dataType: "json",
      success: function (response) {
        // If toggle was successfull, change button from active to inactive and reveres
        let active =
          $("#" + examId + " > div > small > button").text() == "active"
            ? "inactive"
            : "active";
        $("#" + examId + " > div > small > button").text(active);
        $("#toggleExamModal").modal("hide");
      },
    });
  });

  $("#addNewExamButton").click(function () {
    $("#createExamModal").modal("show");
  });

  // validation of inputs, do not allow empty
  $("#timeInput").on("input", function (e) {
    if ($("#timeInput").val() > 1660) {
      $("#timeInput").val(1660);
    } else if ($("#timeInput").val() < 1) {
      $("#timeInput").val(1);
    }
  });

  // validation of inputs, do not allow empty
  $("#nameInput").on("input", function (e) {
    if ($("#nameInput").val().length == 0) {
      $("#createExamButton").prop("disabled", true);
      $("#nameHelp").show();
    } else if ($(this).val().length > 0 && $("#timeInput").val().length > 0) {
      // do not allow exam with existing name
      if (
        existingExams.find((exam) => exam.name == $(this).val()) == undefined
      ) {
        $("#createExamButton").prop("disabled", false);
        $("#nameHelp").hide();
      } else {
        $("#createExamButton").prop("disabled", true);
        $("#nameHelp").show();
      }
    } else {
      $("#createExamButton").prop("disabled", true);
    }
  });

  $("#createExamButton").click(function (e) {
    let data = {};
    data["name"] = $("#nameInput").val();
    data["time"] = $("#timeInput").val();
    data["code"] = Math.random().toString(36).substring(2, 7);
    $.ajax({
      method: "POST",
      url: origin + "/Final/router/exam",
      data: data,
      dataType: "json",
      success: function (response) {
        // TODO redirect to proper exam creation site
        $("#createExamModal").modal("hide");
      },
    });
  });
});
