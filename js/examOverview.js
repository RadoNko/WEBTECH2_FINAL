$(document).ready(function () {
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
                "</h5><small>" +
                active +
                "</small></div><small>Teacher username:" +
                teacherName +
                "</small><br><small>Code:" +
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
});
