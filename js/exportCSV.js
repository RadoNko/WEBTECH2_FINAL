function exportCSV(test_code) {

    $.ajax({
        type: "POST",
        url: '/Final/php/getcsvData.php',
        data: {test_code: test_code},
        success: function (data) {

            console.log("Export CSV: SUCCESS!");
            console.log("Here"+test_code);
            data = JSON.parse(data);
            console.log(data);
            //console.log(data[0].student[1].points_earned);
            let allStudents =[['AIS ID','NAME','SURNAME','POINTS']];
            for (let i = 0; i<data.length; i++){
                let ais_id = data[i].student[0].ais_id;
                let name = data[i].student[0].name;
                let surname = data[i].student[0].surname;
                let points = data[i].student[1].points_earned;
                allStudents.push([ais_id,name,surname,points]);
            }

            let name = 'test'+test_id+'results.csv';
            exportToCsv(name, allStudents);
        },
        error : function (error){
            console.log(error);
        }
    });
}
function exportToCsv(filename, rows) {
    var processRow = function (row) {
        var finalVal = '';
        for (var j = 0; j < row.length; j++) {
            var innerValue = row[j] === null ? '' : row[j].toString();
            if (row[j] instanceof Date) {
                innerValue = row[j].toLocaleString();
            };
            var result = innerValue.replace(/"/g, '""');
            if (result.search(/("|,|\n)/g) >= 0)
                result = '"' + result + '"';
            if (j > 0)
                finalVal += ',';
            finalVal += result;
        }
        return finalVal + '\n';
    };

    var csvFile = '';
    for (var i = 0; i < rows.length; i++) {
        csvFile += processRow(rows[i]);
    }

    var blob = new Blob([csvFile], { type: 'text/csv;charset=utf-8;' });
    if (navigator.msSaveBlob) { // IE 10+
        navigator.msSaveBlob(blob, filename);
    } else {
        var link = document.createElement("a");
        if (link.download !== undefined) { // feature detection
            // Browsers that support HTML5 download attribute
            var url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", filename);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
}
/*
window.onload = function() {




    console.log("ONLOAD");
    exportCSV(1);
};
*/