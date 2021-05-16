window.onload = function () {
    document.addEventListener("visibilitychange", () => {

        //console.log(document.hidden);
        return document.hidden ? studentLeft() : console.log("Student came back");
    });
};

function studentLeft() {
    let left = true;
    var studentID;
    $.ajax({
        type: "POST",
        url: '/Final/php/changeStudentLeft.php',
        data: {/*studentId: studentID*/ },
        success: function (data) {
        }
    });
}