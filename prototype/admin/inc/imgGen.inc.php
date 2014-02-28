<?php

$im = imagecreatefrompng("../images/tennis-court.png");

if(!$im) {
    die();
}

$black = imagecolorallocate($im, 0, 0, 0);
$width = imagesx($im);
$height = imagesy($im);

imagefilledrectangle($im, 0, ($height-20) , $width, $height, $black);

$font = 4;
$text = $overlayTxt;

$leftTextPos = ( $width - imagefontwidth($font)*strlen($text) )/2;

imagestring($im, $font, $leftTextPos, $height-18, $text, $yellow);

Header('Content-type: image/png');
imagepng($im);