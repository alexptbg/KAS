<?php
include("../data/klima.php");
//header
header("Content-type: image/jpeg");
//image file
$imagefile = 'vrf1.jpg';
//font used
$font = imageloadfont('f.gdf');
//text to insert
$text_on = 'ON';
$text_off = 'OFF';
//load image
$im = @imagecreatefromjpeg($imagefile);
//text color
$red = imagecolorallocate($im,230,0,0);
$green = imagecolorallocate($im,34,203,0);
$err = imagecolorallocate($im,255,102,0);
//test text allocation
//imagestring($im,$font,250,150,$text_on,$green);
//imagestring($im,$font,250,250,$text_off,$red);
//start allocations
//01
if(!($dev0101 == NULL)) {
    $d0101 = explode(" ",$dev0101);
    $d0101_5 = $d0101[5];//mode2
    if ($d0101_5 < 8) { imagestring($im,$font,366,869,$text_off,$red); }
    if ($d0101_5 > 7) { imagestring($im,$font,366,869,$text_on,$green); }
}
if(!($dev0102 == NULL)) {
    $d0102 = explode(" ",$dev0102);
    $d0102_5 = $d0102[5];//mode2
    if ($d0102_5 < 8) { imagestring($im,$font,111,823,$text_off,$red); }
    if ($d0102_5 > 7) { imagestring($im,$font,111,823,$text_on,$green); }
}
if(!($dev0103 == NULL)) {
    $d0103 = explode(" ",$dev0103);
    $d0103_5 = $d0103[5];//mode2
    if ($d0103_5 < 8) { imagestring($im,$font,111,691,$text_off,$red); }
    if ($d0103_5 > 7) { imagestring($im,$font,111,691,$text_on,$green); }
}
if(!($dev0104 == NULL)) {
    $d0104 = explode(" ",$dev0104);
    $d0104_5 = $d0104[5];//mode2
    if ($d0104_5 < 8) { imagestring($im,$font,278,641,$text_off,$red); }
    if ($d0104_5 > 7) { imagestring($im,$font,278,641,$text_on,$green); }
}
if(!($dev0105 == NULL)) {
    $d0105 = explode(" ",$dev0105);
    $d0105_5 = $d0105[5];//mode2
    if ($d0105_5 < 8) { imagestring($im,$font,277,757,$text_off,$red); }
    if ($d0105_5 > 7) { imagestring($im,$font,277,757,$text_on,$green); }
}
if(!($dev0106 == NULL)) {
    $d0106 = explode(" ",$dev0106);
    $d0106_5 = $d0106[5];//mode2
    if ($d0106_5 < 8) { imagestring($im,$font,405,755,$text_off,$red); }
    if ($d0106_5 > 7) { imagestring($im,$font,405,755,$text_on,$green); }
}
//03
if(!($dev0301 == NULL)) {
    $d0301 = explode(" ",$dev0301);
    $d0301_5 = $d0301[5];//mode2
    if ($d0301_5 < 8) { imagestring($im,$font,440,940,$text_off,$red); }
    if ($d0301_5 > 7) { imagestring($im,$font,440,940,$text_on,$green); }
}
if(!($dev0302 == NULL)) {
    $d0302 = explode(" ",$dev0302);
    $d0302_5 = $d0302[5];//mode2
    if ($d0302_5 < 8) { imagestring($im,$font,485,940,$text_off,$red); }
    if ($d0302_5 > 7) { imagestring($im,$font,485,940,$text_on,$green); }
}
//04
if(!($dev0401 == NULL)) {
    $d0401 = explode(" ",$dev0401);
    $d0401_5 = $d0401[5];//mode2
    if ($d0401_5 < 8) { imagestring($im,$font,726,870,$text_off,$red); }
    if ($d0401_5 > 7) { imagestring($im,$font,726,870,$text_on,$green); }
}
if(!($dev0402 == NULL)) {
    $d0402 = explode(" ",$dev0402);
    $d0402_5 = $d0402[5];//mode2
    if ($d0402_5 < 8) { imagestring($im,$font,553,767,$text_off,$red); }
    if ($d0402_5 > 7) { imagestring($im,$font,553,767,$text_on,$green); }
}
if(!($dev0403 == NULL)) {
    $d0403 = explode(" ",$dev0403);
    $d0403_5 = $d0403[5];//mode2
    if ($d0403_5 < 8) { imagestring($im,$font,806,768,$text_off,$red); }
    if ($d0403_5 > 7) { imagestring($im,$font,806,768,$text_on,$green); }
}
if(!($dev0404 == NULL)) {
    $d0404 = explode(" ",$dev0404);
    $d0404_5 = $d0404[5];//mode2
    if ($d0404_5 < 8) { imagestring($im,$font,802,639,$text_off,$red); }
    if ($d0404_5 > 7) { imagestring($im,$font,802,639,$text_on,$green); }
}
if(!($dev0405 == NULL)) {
    $d0405 = explode(" ",$dev0405);
    $d0405_5 = $d0405[5];//mode2
    if ($d0405_5 < 8) { imagestring($im,$font,552,640,$text_off,$red); }
    if ($d0405_5 > 7) { imagestring($im,$font,552,640,$text_on,$green); }
}
//10
if(!($dev1001 == NULL)) {
    $d1001 = explode(" ",$dev1001);
    $d1001_5 = $d1001[5];//mode2
    if ($d1001_5 < 8) { imagestring($im,$font,823,258,$text_off,$red); }
    if ($d1001_5 > 7) { imagestring($im,$font,823,258,$text_on,$green); }
}
//12
if(!($dev1201 == NULL)) {
    $d1201 = explode(" ",$dev1201);
    $d1201_5 = $d1201[5];//mode2
    if ($d1201_5 < 8) { imagestring($im,$font,708,506,$text_off,$red); }
    if ($d1201_5 > 7) { imagestring($im,$font,708,506,$text_on,$green); }
}
if(!($dev1202 == NULL)) {
    $d1202 = explode(" ",$dev1202);
    $d1202_5 = $d1202[5];//mode2
    if ($d1202_5 < 8) { imagestring($im,$font,708,419,$text_off,$red); }
    if ($d1202_5 > 7) { imagestring($im,$font,708,419,$text_on,$green); }
}
if(!($dev1203 == NULL)) {
    $d1203 = explode(" ",$dev1203);
    $d1203_5 = $d1203[5];//mode2
    if ($d1203_5 < 8) { imagestring($im,$font,708,340,$text_off,$red); }
    if ($d1203_5 > 7) { imagestring($im,$font,708,340,$text_on,$green); }
}
//14
if(!($dev1401 == NULL)) {
    $d1401 = explode(" ",$dev1401);
    $d1401_5 = $d1401[5];//mode2
    if ($d1401_5 < 8) { imagestring($im,$font,118,480,$text_off,$red); }
    if ($d1401_5 > 7) { imagestring($im,$font,118,480,$text_on,$green); }
}
if(!($dev1402 == NULL)) {
    $d1402 = explode(" ",$dev1402);
    $d1402_5 = $d1402[5];//mode2
    if ($d1402_5 < 8) { imagestring($im,$font,330,350,$text_off,$red); }
    if ($d1402_5 > 7) { imagestring($im,$font,330,350,$text_on,$green); }
}
if(!($dev1403 == NULL)) {
    $d1403 = explode(" ",$dev1403);
    $d1403_5 = $d1403[5];//mode2
    if ($d1403_5 < 8) { imagestring($im,$font,113,350,$text_off,$red); }
    if ($d1403_5 > 7) { imagestring($im,$font,113,350,$text_on,$green); }
}
if(!($dev1404 == NULL)) {
    $d1404 = explode(" ",$dev1404);
    $d1404_5 = $d1404[5];//mode2
    if ($d1404_5 < 8) { imagestring($im,$font,330,477,$text_off,$red); }
    if ($d1404_5 > 7) { imagestring($im,$font,330,477,$text_on,$green); }
}
//15
if(!($dev1501 == NULL)) {
    $d1501 = explode(" ",$dev1501);
    $d1501_5 = $d1501[5];//mode2
    if ($d1501_5 < 8) { imagestring($im,$font,430,257,$text_off,$red); }
    if ($d1501_5 > 7) { imagestring($im,$font,430,257,$text_on,$green); }
}
//generate image
imagejpeg($im);
?>