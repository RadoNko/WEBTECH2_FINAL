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
            let code = val["code"].toString();

            items.push(
              "<li class='list-group-item list-group-item-action' id='" +
              val["id"] +
              "'><div class='d-flex w-100 justify-content-between'><h5 class='mb-1'>" +
              val["name"] +
              "</h5><small><button type='button' class='btn btn-outline-dark activity-button'>" +
              active +
              "</button>" +
                "<button type='button' class='btn btn-outline-dark' onclick='exportCSV(\""+code+"\")'>export to CSV</button>"+
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


  $(document).on("click", ".list-group-item", function () {
    const origin = $(location).attr("origin");
    if (!$("#toggleExamModal").hasClass("show")) {
      $.ajax({
        type: "POST",
        url: origin + "/Final/views/showStudentStatus.php",
        data: { exam_id: $(this).attr('id') },
        async: false,
        success: function (response) {

          $("#statusExamBody").html(response);
          $("#statusExamModal").modal("show");
        }
      });
    }
  })

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
      if (existingExams != undefined && existingExams.length > 0) {
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
        $("#createExamButton").prop("disabled", false);
        $("#nameHelp").hide();
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
    const origin = $(location).attr("origin");
    $.ajax({
      method: "POST",
      url: origin + "/Final/router/exam",
      data: data,
      dataType: "text",
      success: function (response) {
        $("#createExamModal").modal("hide");
        location.href = "/Final/views/createTest.php";
      },
    });
  });
});

function exportCSV(test_code) {
  $.ajax({
    type: "POST",
    url: '/Final/php/getcsvData.php',
    data: {test_code: test_code},
    success: function (data) {

      //console.log("Export CSV: SUCCESS!");
      //console.log(data);
      data = JSON.parse(data);

      //console.log(data[0].student[1].points_earned);
      let allStudents =[['AIS ID','NAME','SURNAME','POINTS']];
      for (let i = 0; i<data.length; i++){
        let ais_id = data[i].student[0].ais_id;
        let name = data[i].student[0].name;
        let surname = data[i].student[0].surname;
        let points = data[i].student[1].points_earned;
        allStudents.push([ais_id,name,surname,points]);
      }
      let name = 'test'+test_code+'results.csv';
      exportToCsv(name, allStudents);
    },
    error : function (error){
      console.log(error);
    }
  });
}
function exportToCsv(filename, rows) {
  var processRow = function (row) {
    var finalVal = '';
    for (var j = 0; j < row.length; j++) {
      var innerValue = row[j] === null ? '' : row[j].toString();
      if (row[j] instanceof Date) {
        innerValue = row[j].toLocaleString();
      };
      var result = innerValue.replace(/"/g, '""');
      if (result.search(/("|,|\n)/g) >= 0)
        result = '"' + result + '"';
      if (j > 0)
        finalVal += ',';
      finalVal += result;
    }
    return finalVal + '\n';
  };

  var csvFile = '';
  for (var i = 0; i < rows.length; i++) {
    csvFile += processRow(rows[i]);
  }

  var blob = new Blob([csvFile], { type: 'text/csv;charset=utf-8;' });
  if (navigator.msSaveBlob) { // IE 10+
    navigator.msSaveBlob(blob, filename);
  } else {
    var link = document.createElement("a");
    if (link.download !== undefined) { // feature detection
      // Browsers that support HTML5 download attribute
      var url = URL.createObjectURL(blob);
      link.setAttribute("href", url);
      link.setAttribute("download", filename);
      link.style.visibility = 'hidden';
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }
  }
}
