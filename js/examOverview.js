$(document).ready(function () {
  console.log("Hello from examOverview.js");
  $.ajax({
    method: "GET",
    url: origin + "/Final/router/exam",
    dataType: "json",
    success: function (data) {
      let items = [];
      $.each(data, function (key, val) {
        console.log(key, val);
        let active = val["is_active"] == 0 ? "active" : "not active";
        items.push(
          "<li class='list-group-item list-group-item-action' id='" +
            val["id"] +
            "'><div class='d-flex w-100 justify-content-between'><h5 class='mb-1'>" +
            val["name"] +
            "</h5><small>" +
            active +
            "</small></div><small>Teacher id:" +
            val["teacher_fk"] +
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
});
