<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//server-side code where we save the given drawing in a PNG file

$img = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_URL);
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);

//see http://j-query.blogspot.fr/2011/02/save-base64-encoded-canvas-image-to-png.html
$img = str_replace(' ', '+', str_replace('data:image/png;base64,', '', $img));
$data = base64_decode($img);

//create the image png file with the given name
file_put_contents('/home/xfullajtar/public_html/files'. str_replace(' ', '_', $name) .'.png', $data);
?>