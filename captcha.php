<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);  
/*session_start();
$ranStr = md5(microtime());
$ranStr = substr($ranStr, 0, 6);
$_SESSION['cap_code'] = $ranStr;
$newImage = imagecreatefromjpeg("images/captcha_bg.jpg");
$txtColor = imagecolorallocate($newImage, 0, 0, 0);
imagestring($newImage, 5, 45, 8, $ranStr, $txtColor);
//imagettftext($newImage, 20, 0, 10, 20, $txtColor, "arial.ttf", $ranStr);
header("Content-type: image/jpeg");
imagejpeg($newImage);*/

session_start(); //MUST START SESSION
$string_length=5; //NUMBER OF CHARS TO DISPLAY
$ranStr = md5(microtime());
$ranStr = substr($ranStr, 0, 6);
$_SESSION['cap_code'] = $ranStr;

//INIT IMAGE
$img = imagecreatefrompng("images/captcha_bg.png");
//ALLOCATE COLORS
$black=imagecolorallocate($img, 0, 0, 0);
$gray=imagecolorallocate($img, 200, 200, 200);
//REPLACE THIS WITH THE FONT YOU UPLOAD
$font='/var/www/html/schooly/Admin/BELLB.TTF';
$font_size=19;
//DRAW STRING USING TRUE TYPE FUNCTION
imagettftext($img, $font_size, 0, 26,
    30, $black, $font, $ranStr);

//OUTPUT IMAGE HEADER AND SEND TO BROWSER
header("Content-Type: image/png");
imagepng($img);

?>






