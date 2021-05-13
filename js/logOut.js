function logOut() {
    const origin = $(location).attr("origin");
    $.ajax({
        method: "POST",
        url: origin + "/Final/router/logins/destroySession",
        data: {},
        success: function (data) {
            location.href = "/Final/index.php";
        }
    });
}