<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Custom Intro</title>
    <link rel="stylesheet" href="custom.css">
</head>
<body id="body">
<h1>Nadpis</h1>
<h2>Subnadpis</h2>
<div id="leftSide">
    <button id="menu1" type="button">Menu 1</button><br>
    <button id="menu2" type="button">Menu 2</button><br>
    <button id="menu3" type="button" >Menu 3</button><br>
    <button id="menu4" type="button">Menu 4</button><br>
    <button id="menu5" type="button">Menu 5</button><br>
    <button id="menu6" type="button">Menu 6</button><br>
    <button id="menu7" type="button">Menu 7</button><br>
    <button id="guide" type="button" >Menu8</button>
</div>

<div id="rightSide">
    <div id="searchDiv" data-guide="true" data-guide-step="4" data-guide-position="L" data-guide-message="Sem pride nejaky textaaaaaaa aaaaa asasasa asas a sas a sas asasa as as">
        <input type="text" placeholder="Search...">
    </div>
    <div id="searchDiv2" data-guide="true" data-guide-step="4" data-guide-position="L" data-guide-message="Sem pride nejaky textaaaaaaa aaaaa asasasa asas a sas a sas asasa as as">
        <input type="text" placeholder="Search...">
    </div>

    <div id="searchDiv3" data-guide="true" data-guide-step="4" data-guide-position="L" data-guide-message="Sem pride nejaky textaaaaaaa aaaaa asasasa asas a sas a sas asasa as as">
        <input type="text" placeholder="Search...">
    </div>

    <div id="searchDiv4" data-guide="true" data-guide-step="4" data-guide-position="L" data-guide-message="Sem pride nejaky textaaaaaaa aaaaa asasasa asas a sas a sas asasa as as">
        <input type="text" placeholder="Search...">
    </div>


    <article class="articleText" >
        <h3 class="guide" data-guide="true" data-guide-step="6" data-guide-position="R" data-guide-message="Sem pride nejaky textaaaaaaa aaaaa a a sas a sas asasa as as">Article title</h3>
        <span class="guide" data-guide="true" data-guide-step="8" data-guide-position="L" data-guide-message="Sem pride nejaky textaaaaaaa aaaaa asasasa asas a sas a sas asasa as as as as as as as as as assssssss">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            </span>
    </article>

    <button id="PDF" type="button" onclick="SaveAsPdf()">Print PDF</button>

</div>

<footer>
    <span>Footer</span>
</footer>
<script src="js/printPDF.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>

</body>
</html>
