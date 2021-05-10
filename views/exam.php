<?php
function showErrors(){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

include "../../Database.php";
showErrors();
?>



<!DOCTYPE html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

</head>
<body>

<p> Tu bude test</p>


<script src="../js/surveilance.js"></script>
<script src="../js/exportCSV.js"></script>
</body>
</html>







