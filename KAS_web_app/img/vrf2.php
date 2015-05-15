<?php
include("../data/klima.php");
//header
header("Content-type: image/jpeg");
//image file
$imagefile = 'vrf2.jpg';
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
//02
if(!($dev0201 == NULL)) {
    $d0201 = explode(" ",$dev0201);
    $d0201_5 = $d0201[5];//mode2
    if ($d0201_5 < 8) { imagestring($im,$font,98,849,$text_off,$red); }
    if ($d0201_5 > 7) { imagestring($im,$font,98,849,$text_on,$green); }
}
if(!($dev0202 == NULL)) {
    $d0202 = explode(" ",$dev0202);
    $d0202_5 = $d0202[5];//mode2
    if ($d0202_5 < 8) { imagestring($im,$font,146,622,$text_off,$red); }
    if ($d0202_5 > 7) { imagestring($im,$font,146,622,$text_on,$green); }
}
if(!($dev0203 == NULL)) {
    $d0203 = explode(" ",$dev0203);
    $d0203_5 = $d0203[5];//mode2
    if ($d0203_5 < 8) { imagestring($im,$font,141,748,$text_off,$red); }
    if ($d0203_5 > 7) { imagestring($im,$font,141,748,$text_on,$green); }
}
if(!($dev0204 == NULL)) {
    $d0204 = explode(" ",$dev0204);
    $d0204_5 = $d0204[5];//mode2
    if ($d0204_5 < 8) { imagestring($im,$font,310,845,$text_off,$red); }
    if ($d0204_5 > 7) { imagestring($im,$font,310,845,$text_on,$green); }
}
if(!($dev0205 == NULL)) {
    $d0205 = explode(" ",$dev0205);
    $d0205_5 = $d0205[5];//mode2
    if ($d0205_5 < 8) { imagestring($im,$font,337,743,$text_off,$red); }
    if ($d0205_5 > 7) { imagestring($im,$font,337,743,$text_on,$green); }
}
//05
if(!($dev0501 == NULL)) {
    $d0501 = explode(" ",$dev0501);
    $d0501_5 = $d0501[5];//mode2
    if ($d0501_5 < 8) { imagestring($im,$font,370,670,$text_off,$red); }
    if ($d0501_5 > 7) { imagestring($im,$font,370,670,$text_on,$green); }
}
if(!($dev0502 == NULL)) {
    $d0502 = explode(" ",$dev0502);
    $d0502_5 = $d0502[5];//mode2
    if ($d0502_5 < 8) { imagestring($im,$font,430,670,$text_off,$red); }
    if ($d0502_5 > 7) { imagestring($im,$font,430,670,$text_on,$green); }
}
//06
if(!($dev0601 == NULL)) {
    $d0601 = explode(" ",$dev0601);
    $d0601_5 = $d0601[5];//mode2
    if ($d0601_5 < 8) { imagestring($im,$font,525,670,$text_off,$red); }
    if ($d0601_5 > 7) { imagestring($im,$font,525,670,$text_on,$green); }
}
if(!($dev0602 == NULL)) {
    $d0602 = explode(" ",$dev0602);
    $d0602_5 = $d0602[5];//mode2
    if ($d0602_5 < 8) { imagestring($im,$font,585,670,$text_off,$red); }
    if ($d0602_5 > 7) { imagestring($im,$font,585,670,$text_on,$green); }
}
//07
if(!($dev0701 == NULL)) {
    $d0701 = explode(" ",$dev0701);
    $d0701_5 = $d0701[5];//mode2
    if ($d0701_5 < 8) { imagestring($im,$font,748,863,$text_off,$red); }
    if ($d0701_5 > 7) { imagestring($im,$font,748,863,$text_on,$green); }
}
if(!($dev0702 == NULL)) {
    $d0702 = explode(" ",$dev0702);
    $d0702_5 = $d0702[5];//mode2
    if ($d0702_5 < 8) { imagestring($im,$font,546,804,$text_off,$red); }
    if ($d0702_5 > 7) { imagestring($im,$font,546,804,$text_on,$green); }
}
if(!($dev0703 == NULL)) {
    $d0703 = explode(" ",$dev0703);
    $d0703_5 = $d0703[5];//mode2
    if ($d0703_5 < 8) { imagestring($im,$font,744,674,$text_off,$red); }
    if ($d0703_5 > 7) { imagestring($im,$font,744,674,$text_on,$green); }
}
if(!($dev0704 == NULL)) {
    $d0704 = explode(" ",$dev0704);
    $d0704_5 = $d0704[5];//mode2
    if ($d0704_5 < 8) { imagestring($im,$font,1105,838,$text_off,$red); }
    if ($d0704_5 > 7) { imagestring($im,$font,1105,838,$text_on,$green); }
}
if(!($dev0705 == NULL)) {
    $d0705 = explode(" ",$dev0705);
    $d0705_5 = $d0705[5];//mode2
    if ($d0705_5 < 8) { imagestring($im,$font,1100,642,$text_off,$red); }
    if ($d0705_5 > 7) { imagestring($im,$font,1100,642,$text_on,$green); }
}
//08
if(!($dev0801 == NULL)) {
    $d0801 = explode(" ",$dev0801);
    $d0801_5 = $d0801[5];//mode2
    if ($d0801_5 < 8) { imagestring($im,$font,1275,377,$text_off,$red); }
    if ($d0801_5 > 7) { imagestring($im,$font,1275,377,$text_on,$green); }
}
if(!($dev0802 == NULL)) {
    $d0802 = explode(" ",$dev0802);
    $d0802_5 = $d0802[5];//mode2
    if ($d0802_5 < 8) { imagestring($im,$font,1275,417,$text_off,$red); }
    if ($d0802_5 > 7) { imagestring($im,$font,1275,417,$text_on,$green); }
}
//09
if(!($dev0901 == NULL)) {
    $d0901 = explode(" ",$dev0901);
    $d0901_5 = $d0901[5];//mode2
    if ($d0901_5 < 8) { imagestring($im,$font,976,140,$text_off,$red); }
    if ($d0901_5 > 7) { imagestring($im,$font,976,140,$text_on,$green); }
}
if(!($dev0902 == NULL)) {
    $d0902 = explode(" ",$dev0902);
    $d0902_5 = $d0902[5];//mode2
    if ($d0902_5 < 8) { imagestring($im,$font,1235,319,$text_off,$red); }
    if ($d0902_5 > 7) { imagestring($im,$font,1235,319,$text_on,$green); }
}
if(!($dev0903 == NULL)) {
    $d0903 = explode(" ",$dev0903);
    $d0903_5 = $d0903[5];//mode2
    if ($d0903_5 < 8) { imagestring($im,$font,732,140,$text_off,$red); }
    if ($d0903_5 > 7) { imagestring($im,$font,732,140,$text_on,$green); }
}
if(!($dev0904 == NULL)) {
    $d0904 = explode(" ",$dev0904);
    $d0904_5 = $d0904[5];//mode2
    if ($d0904_5 < 8) { imagestring($im,$font,1254,140,$text_off,$red); }
    if ($d0904_5 > 7) { imagestring($im,$font,1254,140,$text_on,$green); }
}
if(!($dev0905 == NULL)) {
    $d0905 = explode(" ",$dev0905);
    $d0905_5 = $d0905[5];//mode2
    if ($d0905_5 < 8) { imagestring($im,$font,1133,140,$text_off,$red); }
    if ($d0905_5 > 7) { imagestring($im,$font,1133,140,$text_on,$green); }
}
if(!($dev0906 == NULL)) {
    $d0906 = explode(" ",$dev0906);
    $d0906_5 = $d0906[5];//mode2
    if ($d0906_5 < 8) { imagestring($im,$font,1082,323,$text_off,$red); }
    if ($d0906_5 > 7) { imagestring($im,$font,1082,323,$text_on,$green); }
}
if(!($dev0907 == NULL)) {
    $d0907 = explode(" ",$dev0907);
    $d0907_5 = $d0907[5];//mode2
    if ($d0907_5 < 8) { imagestring($im,$font,865,140,$text_off,$red); }
    if ($d0907_5 > 7) { imagestring($im,$font,865,140,$text_on,$green); }
}
//11
if(!($dev1101 == NULL)) {
    $d1101 = explode(" ",$dev1101);
    $d1101_5 = $d1101[5];//mode2
    if ($d1101_5 < 8) { imagestring($im,$font,572,351,$text_off,$red); }
    if ($d1101_5 > 7) { imagestring($im,$font,572,351,$text_on,$green); }
}
if(!($dev1102 == NULL)) {
    $d1102 = explode(" ",$dev1102);
    $d1102_5 = $d1102[5];//mode2
    if ($d1102_5 < 8) { imagestring($im,$font,779,351,$text_off,$red); }
    if ($d1102_5 > 7) { imagestring($im,$font,779,351,$text_on,$green); }
}
if(!($dev1103 == NULL)) {
    $d1103 = explode(" ",$dev1103);
    $d1103_5 = $d1103[5];//mode2
    if ($d1103_5 < 8) { imagestring($im,$font,783,474,$text_off,$red); }
    if ($d1103_5 > 7) { imagestring($im,$font,783,474,$text_on,$green); }
}
if(!($dev1104 == NULL)) {
    $d1104 = explode(" ",$dev1104);
    $d1104_5 = $d1104[5];//mode2
    if ($d1104_5 < 8) { imagestring($im,$font,578,475,$text_off,$red); }
    if ($d1104_5 > 7) { imagestring($im,$font,578,475,$text_on,$green); }
}
//13
if(!($dev1301 == NULL)) {
    $d1301 = explode(" ",$dev1301);
    $d1301_5 = $d1301[5];//mode2
    if ($d1301_5 < 8) { imagestring($im,$font,102,346,$text_off,$red); }
    if ($d1301_5 > 7) { imagestring($im,$font,102,346,$text_on,$green); }
}
if(!($dev1302 == NULL)) {
    $d1302 = explode(" ",$dev1302);
    $d1302_5 = $d1302[5];//mode2
    if ($d1302_5 < 8) { imagestring($im,$font,75,474,$text_off,$red); }
    if ($d1302_5 > 7) { imagestring($im,$font,75,474,$text_on,$green); }
}
if(!($dev1303 == NULL)) {
    $d1303 = explode(" ",$dev1303);
    $d1303_5 = $d1303[5];//mode2
    if ($d1303_5 < 8) { imagestring($im,$font,333,346,$text_off,$red); }
    if ($d1303_5 > 7) { imagestring($im,$font,333,346,$text_on,$green); }
}
if(!($dev1304 == NULL)) {
    $d1304 = explode(" ",$dev1304);
    $d1304_5 = $d1304[5];//mode2
    if ($d1304_5 < 8) { imagestring($im,$font,242,474,$text_off,$red); }
    if ($d1304_5 > 7) { imagestring($im,$font,242,474,$text_on,$green); }
}
if(!($dev1305 == NULL)) {
    $d1305 = explode(" ",$dev1305);
    $d1305_5 = $d1305[5];//mode2
    if ($d1305_5 < 8) { imagestring($im,$font,400,474,$text_off,$red); }
    if ($d1305_5 > 7) { imagestring($im,$font,400,474,$text_on,$green); }
}
//generate image
imagejpeg($im);
?>