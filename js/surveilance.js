window.onload = function() {
    document.addEventListener("visibilitychange", () => {

        //console.log(document.hidden);
        return document.hidden ? studentLeft() : console.log("Student came back");
    });
};

function studentLeft(){
    console.log("Student left");
    //let studentID = "45645";
    $.ajax({
        type: "POST",
        url: '/Final/controllers/changeStudentLeft.php',
        data: {/*studentId: studentID*/},
        success: function () {
                console.log("SUCCESS!");
        }
    });

}