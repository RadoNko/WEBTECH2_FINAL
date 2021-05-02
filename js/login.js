

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
            "surname": surname
        };
        $.ajax({
            method: "POST",
            url: "http://147.175.98.72/skuska/WEBTECH2_FINAL/router/logins/sendStudentNameSurname",
            data: data,
            success: function (data) {
                console.log(data);
                if(data==="wrongData")
                    studentDetailsDiv.insertAdjacentHTML('beforeend', `<div class='alert alert-danger' role='alert'>Ais ID nesedí so zadanými údajmi</div>`);
                //else
                    //chod na index a vykresli text
            }
        });
    }
}