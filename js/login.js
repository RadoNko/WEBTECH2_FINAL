var testCode;
function saveTest(code){
    testCode=code;
}

function verifyTestCode(){
    testCode=null;
    var code={
        "testCode": document.getElementById("testCode").value
    };

    $.ajax({
        method: "POST",
        url: "http://147.175.98.72/skuska/WEBTECH2_FINAL/router/logins/verifyTestCode",
        data: code,
        success: function(data){
            console.log("som spat "+data);
            if(data==="true"){
                saveTest(code);
                document.getElementById("studentLogin").style.display="none";
                document.getElementById("studentDetails").style.display="block";
            }else{
                document.getElementById("studentLogin").insertAdjacentHTML('beforeend', `
                                <div class='alert alert-danger' role='alert'>Incorrect test code</div>`);
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
        studentDetailsDiv.insertAdjacentHTML('beforeend', `<div class='alert alert-danger' role='alert'>Vyžaduje sa Ais ID</div>`);
    else if(name==null || name==="")
        studentDetailsDiv.insertAdjacentHTML('beforeend', `<div class='alert alert-danger' role='alert'>Vyžaduje sa meno</div>`);
    else if(surname==null || surname==="")
        studentDetailsDiv.insertAdjacentHTML('beforeend', `<div class='alert alert-danger' role='alert'>Vyžaduje sa priezvisko</div>`);
    else {
        var data = {
            "id":id,
            "name": name,
            "surname": surname,
            "testCode":testCode
        };
        $.ajax({
            method: "POST",
            url: "http://147.175.98.72/skuska/WEBTECH2_FINAL/router/logins/sendStudentNameSurname",
            data: data,
            success: function (data) {
                console.log(data);
                if(data==="wrongData")
                    studentDetailsDiv.insertAdjacentHTML('beforeend', `<div class='alert alert-danger' role='alert'>Ais ID nesedí so zadanými údajmi</div>`);
                else if(data==="studentExamInserted"){
                    location.href = 'http://147.175.98.72/skuska/WEBTECH2_FINAL/';
                }else if(data==="alreadyFinished"){
                    studentDetailsDiv.insertAdjacentHTML('beforeend', `<div class='alert alert-danger' role='alert'>Tento test si už dopísal</div>`);
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
    if(psw===psw2){
        $.ajax({
            method: "POST",
            url: "http://147.175.98.72/skuska/WEBTECH2_FINAL/router/logins/registerNewTeacher",
            data: {nickname:nickname,password:psw},
            success: function(data){
                console.log(data);
                if(data==="alreadyRegistered"){
                    document.getElementById("teacherRegistration").insertAdjacentHTML('beforeend', `<div class='alert alert-danger' role='alert'>Účet už existuje</div>`);
                }else
                    location.href = 'http://147.175.98.72/skuska/WEBTECH2_FINAL/';
            }
        });
    }else{
        document.getElementById("teacherRegistration").insertAdjacentHTML('beforeend', `<div class='alert alert-danger' role='alert'>Heslá sa nezhodujú</div>`);
    }
}

function verifyTeacherLogin(){
    var data={
        "nickname":document.getElementById("teacherNickname").value,
        "password":document.getElementById("teacherPassword").value
    };

    $.ajax({
        method: "POST",
        url: "http://147.175.98.72/skuska/WEBTECH2_FINAL/router/logins/verifyTeacherLogin",
        data: data,
        success: function(data){
            console.log("som spat "+data);
            if(data==="wrongPassword"){
                document.getElementById("teacherLogin").insertAdjacentHTML('beforeend', `<div class='alert alert-danger' role='alert'>Nesprávne heslo</div>`);
            }else
                location.href = 'http://147.175.98.72/skuska/WEBTECH2_FINAL/';
        }
    });
}


function logOut(){
    $.ajax({
        method: "POST",
        url: "http://147.175.98.72/skuska/WEBTECH2_FINAL/router/logins/destroySession",
        data: {},
        success: function (data) {
            location.href = 'http://147.175.98.72/skuska/WEBTECH2_FINAL/';
        }
    });
}

