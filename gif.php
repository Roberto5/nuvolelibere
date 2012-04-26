<?php
error_reporting(E_ALL);
header ('Content-type:image/gif');
require_once 'include/GIFEncoder.class.php';
$file1='/var/www/gifeditor/upload/3342582cddaf354a67b8caa0b947a1b8/cielo.jpg';
$file2='/var/www/gifeditor/upload/3342582cddaf354a67b8caa0b947a1b8/cloud.png';

ob_start();
imagegif(imagecreatefromjpeg($file1));
$frames[]=ob_get_contents();
$framed[]=40; // Delay in the animation.
ob_end_clean();

// And again..

// Open the first source image and add the text.
$image = imagecreatefrompng($file2);


// Generate GIF from the $image
// We want to put the binary GIF data into an array to be used later,
//  so we use the output buffer.
ob_start();
imagegif($image);
$frames[]=ob_get_contents();
$framed[]=40; // Delay in the animation.
ob_end_clean();

$gif = new GIFEncoder($frames,$framed,0,1,-255,-255,-255,'bin');

echo $gif->GetAnimation();
/*
//*/
?>
