<?php

header ('Content-type:image/gif');
include('include/GIFEncoder.class.php');
$file='00.jpg';
$size=getimagesize($file);
$ratio=$size[0]/$size[1];
$w=$_GET['w'] ? $_GET['w'] : 180;
$h=$_GET['h'] ? $_GET['h'] : 150;
/*if ($_GET['h']) $w=intval($h*$ratio);
else $h=intval($w/$ratio);*/


$image = imagecreatefromjpeg($file);


//var_dump($size);


$thumb = imagecreatetruecolor($w, $h);
imagecopyresized($thumb, $image, 0, 0, 0, 0, $w, $h, $size[0], $size[1]);
imagedestroy($image);

imagegif($thumb);
imagedestroy($thumb);
/*
$text = "Hello World";

// Open the first source image and add the text.
$image = imagecreatefrompng('source01.png');
$text_color = imagecolorallocate($image, 200, 200, 200);
imagestring($image, 5, 5, 5,  $text, $text_color);

// Generate GIF from the $image
// We want to put the binary GIF data into an array to be used later,
//  so we use the output buffer.
ob_start();
imagegif($image);
$frames[]=ob_get_contents();
$framed[]=40; // Delay in the animation.
ob_end_clean();

// And again..

// Open the first source image and add the text.
$image = imagecreatefrompng('source02.png');
$text_color = imagecolorallocate($image, 200, 200, 200);
imagestring($image, 5, 20, 20,  $text, $text_color);

// Generate GIF from the $image
// We want to put the binary GIF data into an array to be used later,
//  so we use the output buffer.
ob_start();
imagegif($image);
$frames[]=ob_get_contents();
$framed[]=40; // Delay in the animation.
ob_end_clean();

// Generate the animated gif and output to screen.
$gif = new GIFEncoder($frames,$framed,0,2,0,0,0,'bin');
echo $gif->GetAnimation();
//*/
?>
