var testCode;
function saveTest(code){
    testCode=code;
}

function verifyTestCode(){
    testCode=null;
    var code={
        "testCode": document.getElementById("testCode").value
    };

    const origin = $(location).attr("origin");
    $.ajax({
        method: "POST",
        url: origin + "/Final/router/logins/verifyTestCode",
        data: code,
        dataType: "text",
        success: function(data){
            console.log(data)
            if(data==="true"){
                saveTest(code);
                document.getElementById("studentLogin").style.display="none";
                document.getElementById("studentDetails").style.display="block";
            }else{
                document.getElementById("studentLogin").insertAdjacentHTML('beforeend', `
                                <div class='red-warning-small mt-4' role='alert'>Incorrect test code</div>`);
            }
        }
    });
}

function sendStudentName(){
    var name=document.getElementById("studentName").value;
    var surname=document.getElementById("studentSurname").value;
    var id=document.getElementById("aisID").value;

    var studentDetailsDiv=document.getElementById("studentDetails");

    if(id==null || id==="")
        studentDetailsDiv.insertAdjacentHTML('beforeend', `<div class='red-warning-small mt-4' role='alert'>Vyžaduje sa Ais ID</div>`);
    else if(name==null || name==="")
        studentDetailsDiv.insertAdjacentHTML('beforeend', `<div class='red-warning-small mt-4' role='alert'>Vyžaduje sa meno</div>`);
    else if(surname==null || surname==="")
        studentDetailsDiv.insertAdjacentHTML('beforeend', `<div class='red-warning-small mt-4' role='alert'>Vyžaduje sa priezvisko</div>`);
    else {
        var data = {
            "id":id,
            "name": name,
            "surname": surname,
            "testCode":testCode
        };
        const origin = $(location).attr("origin");
        $.ajax({
            method: "POST",
            url: origin + "/Final/router/logins/sendStudentNameSurname",
            data: data,
            success: function (data) {
                if(data==="wrongData")
                    studentDetailsDiv.insertAdjacentHTML('beforeend', `<div class='red-warning-small mt-4' role='alert'>Ais ID nesedí so zadanými údajmi</div>`);
                else if(data==="studentExamInserted"){
                    location.href = "/Final/views/fillTest.php";
                }else if(data==="alreadyFinished"){
                    studentDetailsDiv.insertAdjacentHTML('beforeend', `<div class='red-warning-small mt-4' role='alert'>Tento test si už dopísal</div>`);
                }

            }
        });
    }
}

function imNotRegistered(){
    document.getElementById("teacherLogin").style.display="none";
    document.getElementById("teacherRegistration").style.display="block";
}

function registerNewTeacher(){
    var nickname=document.getElementById("teacherRegistrationNickname").value;
    var psw=document.getElementById("teacherRegistrationPassword").value;
    var psw2=document.getElementById("teacherRegistrationPasswordAgain").value;

    if(nickname===null || nickname==="")
        document.getElementById("teacherRegistration").insertAdjacentHTML('beforeend', `<div class='alert alert-danger' role='alert'>Vyžaduje sa meno</div>`);
    else if(psw===null || psw==="")
        document.getElementById("teacherRegistration").insertAdjacentHTML('beforeend', `<div class='alert alert-danger' role='alert'>Vyžaduje sa heslo</div>`);
    else if(psw2===null || psw2==="")
        document.getElementById("teacherRegistration").insertAdjacentHTML('beforeend', `<div class='alert alert-danger' role='alert'>Vyžaduje sa heslo</div>`);
    else {
        if (psw === psw2) {
            const origin = $(location).attr("origin");
            $.ajax({
                method: "POST",
                url: origin + "/Final/router/logins/registerNewTeacher",
                data: {nickname: nickname, password: psw},
                success: function (data) {
                    if (data === "alreadyRegistered") {
                        document.getElementById("teacherRegistration").insertAdjacentHTML('beforeend', `<div class='red-warning-small mt-4' role='alert'>Účet už existuje</div>`);
                    } else
                        location.href = origin + '/Final/views/examOverview.php';
                },
                error: function(data){
                    console.log(data);
                }
            });
        } else {
            document.getElementById("teacherRegistration").insertAdjacentHTML('beforeend', `<div class='red-warning-small mt-4' role='alert'>Heslá sa nezhodujú</div>`);
        }
    }
}

function verifyTeacherLogin(){
    var data={
        "nickname":document.getElementById("teacherNickname").value,
        "password":document.getElementById("teacherPassword").value
    };
    const origin = $(location).attr("origin");
    $.ajax({
        method: "POST",
        url: origin + "/Final/router/logins/verifyTeacherLogin",
        data: data,
        success: function(data){
            if(data==="wrongPassword"){
                document.getElementById("teacherLogin").insertAdjacentHTML('beforeend', `<div class='red-warning-small mt-4' role='alert'>Nesprávne heslo</div>`);
            }else
                location.href = "/Final/views/examOverview.php";
        }
    });
}


// function logOut(){
//     const origin = $(location).attr("origin");
//     $.ajax({
//         method: "POST",
//         url: origin+"/Final/router/logins/destroySession",
//         data: {},
//         success: function (data) {
//             location.href = "/Final/index.php";
//         }
//     });
// }

