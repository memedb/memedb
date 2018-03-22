<?php

function HSVtoRGB(array $hsv) {
    list($H,$S,$V) = $hsv;
    //1
    $H *= 6;
    //2
    $I = floor($H);
    $F = $H - $I;
    //3
    $M = $V * (1 - $S);
    $N = $V * (1 - $S * $F);
    $K = $V * (1 - $S * (1 - $F));
    //4
    switch ($I) {
        case 0:
            list($R,$G,$B) = array($V,$K,$M);
            break;
        case 1:
            list($R,$G,$B) = array($N,$V,$M);
            break;
        case 2:
            list($R,$G,$B) = array($M,$V,$K);
            break;
        case 3:
            list($R,$G,$B) = array($M,$N,$V);
            break;
        case 4:
            list($R,$G,$B) = array($K,$M,$V);
            break;
        case 5:
        case 6: //for when $H=1 is given
            list($R,$G,$B) = array($V,$M,$N);
            break;
    }
    return array($R, $G, $B);
}

$handle = $_GET['handle'];

if ($handle == null) {
  exit();
}

if (file_exists($_SERVER['DOCUMENT_ROOT']."/images/users/".$handle.".png")) {
  header("Location: /images/users/".$handle.".png");
} else {
  $seed = base_convert($handle, 36, 10);
  mt_srand((int)$seed);
  $img = imagecreate(128,128);
  $background = imagecolorallocate($img, 220, 220, 220);
  $hsv = array(mt_rand() / mt_getrandmax(), 0.73, 0.96);
  $rgb = HSVtoRGB($hsv);
  $main = imagecolorallocate($img, (int) ($rgb[0] * 255), (int) ($rgb[1] * 255), (int) ($rgb[2] * 255));

  $imgsize = 128;

  imagefilledrectangle($img, 0, 0, $imgsize, $imgsize, $background);

  $size = 6;
  $pixelsize = $imgsize / $size;

  for ($x = 0; $x < $size / 2; $x++) {
    for ($y = 0; $y < $size; $y++) {
      if (mt_rand() < (mt_getrandmax() / 2)) {
        imagefilledrectangle($img, $x * $pixelsize, $y * $pixelsize, $x * $pixelsize + $pixelsize, $y * $pixelsize + $pixelsize, $main);
        imagefilledrectangle($img, ($imgsize - $pixelsize) - ($x * $pixelsize), $y * $pixelsize, ($imgsize - $pixelsize) - ($x * $pixelsize) + $pixelsize, ($y * $pixelsize) + $pixelsize, $main);
      }
    }
  }

  header("Content-type: image/png");
  imagepng($img);
  imagecolordeallocate($img, $background);
  imagecolordeallocate($img, $main);
  imagedestroy($img);
}

?>
