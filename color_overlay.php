
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$image = imagecreatefrompng('generated_images/bridge4_symbol_final.png');

$original_picture = 'generated_images/bridge4_symbol_final.png';
$outputFilePathIn = 'generated_images/bridge4_symbol_shadow.png';

colorizeKeepAplhaChannnel($original_picture, 0, 0, 0, $outputFilePathIn);
	

$symbol = imagecreatefrompng($original_picture);
$shadow_image = imagecreatefrompng($outputFilePathIn);

//blur the shadow
$i=10;
while($i--) 
imagefilter($shadow_image,IMG_FILTER_GAUSSIAN_BLUR);

imagesavealpha($shadow_image,true);
imagesavealpha($symbol,true);

//define image as transparent
imagecolortransparent($shadow_image);

//copy symbol on top of shadow
// imagecopy($symbol, $shadow_image, 0, 0, 0, 0, 180, 180);
imagecopy($shadow_image, $symbol, 0, 0, 0, 0, 180, 180);


//example
// $shadow_image = blur($shadow_image,10);
imagepng($symbol, $outputFilePathIn, 9);
// imagedestroy($shadow_image);









// // for ($x=1; $x<=15; $x++) imagefilter($shadow_image,IMG_FILTER_GAUSSIAN_BLUR);
// // // imagefilter($shadow_image,IMG_FILTER_CONTRAST,-100);
// function blur($img, $radius=10) {

// 	if ($radius>100) $radius=100; //max radius
// 	if ($radius<0) $radius=0; //nin radius

// 	$radius=$radius*4;
// 	$alphaStep=round(100/$radius)*1.7;
// 	$width=imagesx($img);
// 	$height=imagesy($img);
// 	$beginX=floor($radius/2);
// 	$beginY=floor($radius/2);

// 	//make clean image sample for multiply
//     $cleanImageSample = $img;
// 	// $cleanImageSample=imagecreatetruecolor($width, $height);
// 	imagefill($cleanImageSample, 0, 0, IMG_COLOR_TRANSPARENT);
//     imagesavealpha($cleanImageSample,true);
//     imagealphablending($cleanImageSample, true);

// 	// imagecopy($cleanImageSample, $img, 0, 0, 0, 0, $width, $height);

// 	//make h blur
// 	for($i = 1; $i < $radius+1; $i++) {
// 		$xPoint=($beginX*-1)+$i-1;
// 		imagecopymerge($img, $cleanImageSample, $xPoint, 0, 0, 0, $width, $height, $alphaStep);
// 	}
// 	//make v blur
// 	imagecopy($cleanImageSample, $img, 0, 0, 0, 0, $width, $height);
// 	for($i = 1; $i < $radius+1; $i++) {
// 		$yPoint=($beginY*-1)+$i-1;
// 		imagecopymerge($img, $cleanImageSample, 0, $yPoint, 0, 0, $width, $height, $alphaStep);
// 	}
// 	//finish
// 	// imagedestroy($cleanImageSample); 
// 	return $img;
// }




function colorizeKeepAplhaChannnel( $original_picture, $r, $g, $b, $outputFilePathIn ) {
	$im_src = imagecreatefrompng( $original_picture );
	$im_dst = imagecreatefrompng( $original_picture );
	$width = imagesx($im_src);
	$height = imagesy($im_src);

// Note this: FILL IMAGE WITH TRANSPARENT BG
	imagefill($im_dst, 0, 0, IMG_COLOR_TRANSPARENT);
	imagesavealpha($im_dst,true);
	imagealphablending($im_dst, true);

	$flagOK = 1;
	for( $x=0; $x<$width; $x++ ) {
		for( $y=0; $y<$height; $y++ ) {
			$rgb = imagecolorat( $im_src, $x, $y );
			$colorOldRGB = imagecolorsforindex($im_src, $rgb);
			$alpha = $colorOldRGB["alpha"];
			$colorNew = imagecolorallocatealpha($im_src, $r, $g, $b, $alpha);

			$flagFoundColor = true;

			if ( false === $colorNew ) {
//echo( "FALSE COLOR:$colorNew alpha:$alpha<br/>" );
				$flagOK = 0; 
			} else if ($flagFoundColor) {
				imagesetpixel( $im_dst, $x, $y, $colorNew );
//echo "x:$x y:$y col=$colorNew alpha:$alpha<br/>";
			} 
		}
	}
	$flagOK2 = imagepng($im_dst, $outputFilePathIn);

	if ($flagOK && $flagOK2) {
		echo ("<strong>Congratulations, your conversion was successful </strong><br/>new file $outputFilePathIn<br/>");
	} else if ($flagOK2 && !$flagOK) {
		echo ("<strong>ERROR, your conversion was UNsuccessful</strong><br/>Please verify if your PNG is truecolor<br/>input file $original_picture<br/>");
	} else if (!$flagOK2 && $flagOK) {
		$dirNameOutput = dirname($outputFilePathIn)."/";
		echo ("<strong>ERROR, your conversion was successful, but could not save file</strong><br/>Please verify that you have PERMISSION to save to directory $dirName <br/>input file $original_picture<br/>");
	} else {
		$dirNameOutput = dirname($outputFilePathIn)."/";
		echo ("<strong>ERROR, your conversion was UNsuccessful AND could not save file</strong><br/>Please verify if your PNG is truecolor<br/>Please verify that you have PERMISSION to save to directory $dirName <br/>input file $original_picture<br/>");
	}

	echo ("TargetName:$outputFilePathIn wid:$width height:$height CONVERTED:|$flagOK| SAVED:|$flagOK2|<br/>");
	imagedestroy($im_dst);
	imagedestroy($im_src);
}

?>
<img src="generated_images/bridge4_symbol_final.png" alt="Radiant Blades">
<img src="generated_images/bridge4_symbol_shadow.png" alt="Radiant Blades">

