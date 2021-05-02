

function verifyTestCode(){
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

    if(id==null || id==="")
        document.getElementById("studentDetails").insertAdjacentHTML('beforeend', `<div class='alert alert-danger' role='alert'>Vyžaduje sa Ais ID</div>`);
    else if(name==null || name==="")
        document.getElementById("studentDetails").insertAdjacentHTML('beforeend', `<div class='alert alert-danger' role='alert'>Vyžaduje sa meno</div>`);
    else if(surname==null || surname==="")
        document.getElementById("studentDetails").insertAdjacentHTML('beforeend', `<div class='alert alert-danger' role='alert'>Vyžaduje sa priezvisko</div>`);
    else {
        var data = {
            "name": document.getElementById("studentName").value,
            "surname": document.getElementById("studentSurname").value,
        };
        $.ajax({
            method: "POST",
            url: "http://147.175.98.72/skuska/WEBTECH2_FINAL/router/logins/sendStudentNameSurname",
            data: data,
            success: function (data) {
                console.log("som spat " + data);
            }
        });
    }
}