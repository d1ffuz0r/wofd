<?php
header ("Content-type: image/vnd.wap.wbmp");

$x=3;
$y=3;
$im1 = ImageCreate (3,3);
$background_color = ImageColorAllocate ($im1, 255, 255, 255);
$text_color = ImageColorAllocate ($im1, 0, 0, 0);
ImageRectangle($im1,0,0,2,2,$text_color);
imagesetpixel($im1,1,0,$text_color);
imagesetpixel($im1,1,2,$text_color);
imagesetpixel($im1,0,1,$text_color);
imagesetpixel($im1,2,1,$text_color);

$im = ImageCreateFromJPEG ("1.jpg");
imagegammacorrect($im,25,1);

$N=30;
$x1=ImageSX($im)/$N;
$y1=ImageSY($im)/$N;
$ind=524;
$yN = $y1 * ($ind / $N);
$xN = $x1 * ($ind % $N);
$yN=10;
$xN=10;

ImageCopy($im2,$im,0,0,0,0,$x1,$y1);
ImageCopy($im2,$im1,0,0,0,0,$x,$y);
ImageCopy($im,$im1,$xN,$yN,0,0,$x,$y);
Imagewbmp ($im);
?>
