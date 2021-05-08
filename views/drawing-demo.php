<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Drawing Demo</title>
  <link rel="stylesheet" href="../drawingboard.js/drawingboard.min.css">
  <link rel="stylesheet" href="../tailwind.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="../drawingboard.js/drawingboard.min.js"></script>
</head>
<body class="grid grid-cols-12 bg-gray-200 min-h-screen">
<?php include "partials/studentNavigation.html" ?>
<main class="col-span-10 flex justify-center">
    <div id="drawing-demo" class="w-full h-full"></div>
</main>


<script>
  let myBoard = new DrawingBoard.Board('drawing-demo');
</script>
</body>
</html>