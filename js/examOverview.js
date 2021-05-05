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
        items.push(
          "<li id='" +
            key +
            "'>ID: " +
            val["id"] +
            " name: " +
            val["name"] +
            " code: " +
            val["code"] +
            " is_active: " +
            val["is_active"] +
            "</li>"
        );
      });
      $("<ul/>", {
        class: "my-new-list",
        html: items.join(""),
      }).appendTo("body");
    },
  });
});
