<?php
$letters = "ABCDEFGKIJKLMNOPQRSTUVWXYZ"; 
$caplen = 6;
$width = 200;
$height = 60;
$font = "JosefinSans-Bold.ttf";
$fontsize = 17;

header('Content-type: image/png');

$im = imagecreatetruecolor($width, $height);
imagesavealpha($im, true);
$bg = imagecolorallocatealpha($im, 0, 0, 0, 127);
imagefill($im, 0, 0, $bg);


$img_arr = array("back1.png","back2.png","back3.png", "back4.png");
$img_fn = $img_arr[rand(0, count($img_arr)-1)];
$im = imagecreatefrompng($img_fn);

$linenum = rand(3,7);

for($i = 0; $i < $linenum ; $i++) {
    $color = imagecolorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));
    imageline   ($im,
                rand(0, 10), rand(1, 60),
                rand(160, 200), rand(1, 60), $color);
}

$captcha = '';
for ($i = 0; $i < $caplen; $i++) {
    $captcha .= $letters[ rand(0, strlen($letters)-1) ];
    $x = ($width - 20) / $caplen * $i + 10;
    $x = rand($x, $x + 4);
    $y = $height - ( ($height - $fontsize) / 2 );
    $curcolor = imagecolorallocate( $im, rand(0, 100), rand(0, 100), rand(0, 100) );
    $angle = rand(-25, 25);
    imagettftext($im, $fontsize, $angle, $x, $y, $curcolor, $font, $captcha[$i]);
}

session_start();
$_SESSION['captcha'] = $captcha;
imagepng($im);
imagedestroy($im);

?>