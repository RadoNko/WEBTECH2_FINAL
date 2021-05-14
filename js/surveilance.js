window.onload = function() {
    document.addEventListener("visibilitychange", () => {

        //console.log(document.hidden);
        return document.hidden ? studentLeft() : console.log("Student came back");
    });
};

function studentLeft(){
    console.log("Student left");
    let left = true;
    var studentID;
    $.ajax({
        type: "POST",
        url: '/Final/php/changeStudentLeft.php',
        data: {/*studentId: studentID*/},
        success: function (data) {
                studentID = data;
            $.ajax({
                type: "POST",
                url: '/Final/views/examOverview.php',
                data: {studentID: studentID},
                success: function () {
                    console.log("SUCCESS! examOverview.php ajax call");
                }
            });
        }
    });


}