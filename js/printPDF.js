
function SaveAsPdf() {
    var all = document.getElementsByClassName("mq-selectable");
    for (var i = 0; i < all.length; i++) {
        all[i].style.display = 'none';
    }
    var all = document.getElementsByClassName("form-check-input");
    for (var i = 0; i < all.length; i++) {
        all[i].style.display = 'none';
    }

    var all = document.getElementsByClassName("pdf");
    console.log(all);
    for (var i = 0; i < all.length; i++) {
        all[i].style.display = 'none';
    }

    var api_endpoint = "https://selectpdf.com/api2/convert/";
    var api_key = "8658be42-b9e6-49ce-aefb-3f7691e503a2";

    var url = window.location.href; // current page

    var params = {
        key: api_key,
       // url: url
        html : document.getElementById("examContainer").innerHTML
    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST', api_endpoint, true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.responseType = 'arraybuffer';

    xhr.onload = function (e) {
        if (this.status == 200) {
            //console.log('Conversion to PDF completed ok.');

            var blob = new Blob([this.response], { type: 'application/pdf' });
            var url = window.URL || window.webkitURL;
            var fileURL = url.createObjectURL(blob);
            //window.location.href = fileURL;

            //console.log('File url: ' + fileURL);

            var fileName = "Test.pdf";

            if (navigator.appVersion.toString().indexOf('.NET') > 0) {
                // This is for IE browsers, as the alternative does not work
                window.navigator.msSaveBlob(blob, fileName);
            }
            else {
                // This is for Chrome, Firefox, etc.
                var a = document.createElement("a");
                document.body.appendChild(a);
                a.style = "display: none";
                a.href = fileURL;
                a.download = fileName;
                a.click();
            }
        }
        else {
            //console.log("An error occurred during conversion to PDF: " + this.status);
            alert("An error occurred during conversion to PDF.\nStatus code: " + this.status + ", Error: " + String.fromCharCode.apply(null, new Uint8Array(this.response)));
        }
    };

    xhr.send(JSON.stringify(params));

    var all = document.getElementsByClassName("mq-selectable");
    for (var i = 0; i < all.length; i++) {
        all[i].style.display = 'block';
    }
    var all = document.getElementsByClassName("form-check-input");
    for (var i = 0; i < all.length; i++) {
        all[i].style.display = 'block';
    }

    var all = document.getElementsByClassName("pdf");
    console.log(all);
    for (var i = 0; i < all.length; i++) {
        all[i].style.display = 'block';
    }

}
