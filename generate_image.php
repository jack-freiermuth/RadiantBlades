<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

print_r($_POST);
// $png_image = imagecreatefrompng ('bridge4.png');
$png_image = imagecreatefrompng ('guild_logo.png');

// Set Path to Font File
$font_path = 'fonts/CuppaJoe.ttf';

// Set Text to Be Printed On Image
$text = isset($_POST['name_text']) && '' != $_POST['name_text'] ? $_POST['name_text'] : '';

$text_color = hex2rgb($_POST['text_color']);
$text_color = imagecolorallocate($png_image, $text_color['r'], $text_color['g'], $text_color['b']);

$stroke_color = hex2rgb($_POST['stroke_color']);
$stroke_color = imagecolorallocate($png_image, $stroke_color['r'], $stroke_color['g'], $stroke_color['b']);

$stroke_size = $_POST['stroke_size'];

$strlen_to_font_size = array(
	1 => 140,
	2 => 140,
	3 => 140,
	4 => 120,
	5 => 120,
	6 => 100,
	7 => 95,
	8 => 81,
	9 => 873,
	10 => 69,
	11 => 67,
	12 => 60,
	13 => 59,
	14 => 50,
	15 => 41,
	16 => 30,
	);

$font_size = $strlen_to_font_size[strlen($text)];

// place some text (top, left)
imagettfstroketext($png_image, $font_size, 0, $_POST['x_axis_size'], 600, $text_color, $stroke_color, $font_path, $text, $stroke_size);

//Save image
imagepng($png_image, "generated_images/final_image_new.png", 9);

// Clear Memory
imagedestroy($png_image);



function imagettfstroketext(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px) {
	for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++) {
		for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++) {
			$bg = imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);
		}
	}
	return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);
}

function hex2rgb($hex) {
	$hex = str_replace("#", "", $hex);

	if(strlen($hex) == 3) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}
	$rgb = array( 'r' => $r,'g' => $g, 'b' => $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

function color_overlay($color, $img_type, $bg_image = false, $opacity = 50) {
	if ( 'bg' == $img_type ) {
			$picture = 'bridge4_background';
	} elseif ( 'symbol' == $img_type ) {
			$picture = 'bridge4_symbol';
	}
	echo '<pre>';
	echo "picture: $picture";
	echo '<br>color: ';print_r($color);
	echo '</pre>';
	$image = imagecreatefrompng($picture.'.png');
	imagefilter($image, IMG_FILTER_COLORIZE, $color['r'],$color['g'],$color['b'], $opacity);
	imagesavealpha($image, TRUE);
	imagepng($image, 'generated_images/'.$picture.'_new.png');

}

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
        echo ("<strong>ERROR, your conversion was Unsuccessful AND could not save file</strong><br/>Please verify if your PNG is truecolor<br/>Please verify that you have PERMISSION to save to directory $dirName <br/>input file $original_picture<br/>");
    }

    echo ("TargetName:$outputFilePathIn wid:$width height:$height CONVERTED:|$flagOK| SAVED:|$flagOK2|<br/>");
    imagedestroy($im_dst);
    imagedestroy($im_src);
}

function merge_images( $symbol, $background) {
	// exit(PHP_EOL.'<br>symbol: '.$symbol);
	
	//copy symbol onto shadow
	$symbol_new = imagecreatefrompng('generated_images/'.$symbol.'_symbol_new.png');
	$symbol_shadow = imagecreatefrompng($symbol.'_shadow.png');

	imagealphablending($symbol_shadow, true);
	imagesavealpha($symbol_shadow, true);
	imagecopy( $symbol_shadow, $symbol_new, 0, 0, 0, 0, 180, 180);

	imagepng($symbol_shadow, 'generated_images/'.$symbol.'_symbol_new.png');

	echo PHP_EOL.'<br>cmd: '.$cmd;

	//copy symbol border onto symbol
	$symbol_new = imagecreatefrompng('generated_images/'.$symbol.'_symbol_new.png');
	$symbol_border = imagecreatefrompng('generated_images/'.$symbol.'_symbol_border_new.png');

	imagealphablending($symbol_new, true);
	imagesavealpha($symbol_new, true);
	imagecopy($symbol_new, $symbol_border, 0, 0, 0, 0, 180, 180);

	imagepng($symbol_new, 'generated_images/'.$symbol.'_symbol_final.png');

	echo PHP_EOL.'<br>cmd: '.$cmd;

	//copy symbol with border onto background
	$background = imagecreatefrompng('generated_images/'.$background.'_background_new.png');
	$symbol_final = imagecreatefrompng('generated_images/'.$symbol.'_symbol_final.png');

	imagealphablending($background, true);
	imagesavealpha($background, true);
	imagecopy($background, $symbol_final, 0, 0, 0, 0, 180, 180);

	imagepng($background, 'generated_images/final_image_new.png');


}