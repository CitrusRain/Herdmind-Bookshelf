<?PHP
/* 
 * Becomes a resized version of whatever image is at the URL specified by the i parameter to the width specified by the w
 * parameter, the height specified by the h parameter, or both.
 * 
 * @param i the image being resized
 * @param w [OPTIONAL] the new width of the image
 * 		If this is omitted, the new width is derived from the new height
 * @param h [OPTIONAL] the new width of the image
 * 		If this is omitted, the new height is derived from the new width
 * 		If both h and w are omitted, then the image is created in its original size
 * @since 2013-08-25
 * @version 1.0.0
 */
 //bool imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
$debug = isset($_GET["debug"]); $start = 0;
if ($debug)
{
    $start = microtime (true);
}
if (!isset($_GET['i']))
{
    $text = 'parameter “i” is required';


    $width = isset($_GET['w']) ? $_GET['w'] : 1024;
    $height = isset($_GET['h']) ? $_GET['h'] : 512;
    $image_p = @imagecreatetruecolor($width, $height)
        or die('parameter “i” is required');
    imagefilledrectangle($image_p, 0, 0, $width, $height, imagecolorallocate($image_p, 34, 119, 187));
    $textSize = ($width / strlen($text));
    $textColor = imagecolorallocate($image_p, 255, 255, 255);
    $font = imagettftext($image_p, $textSize, 0, ($width / 2) - (($textSize / 4) * strlen($text)), $height / 2, $textColor, '../_css/fonts/Inconsolata-Regular.ttf', $text);
    //imagestring($image_p, 1, 5, 5,  'parameter “i” is required', $textColor);

    header ('Content-Type: image/png');
    ob_clean(); // ensure a completely clean, headerless file
    flush(); // Write any bits waiting to be written
    imagepng($image_p/*, "http://placehold.it/1024x512&text=parameter%20%E2%80%9Ci%E2%80%9D%20is%20required"*/);
    imagedestroy($image_p);
    exit;
}
 
// The file
$filename = $_SERVER['DOCUMENT_ROOT'] . $_GET['i'];
#if($debug)var_dump($filename);

// Get new dimensions
list($width, $height) = getimagesize($filename);

if (isset($_GET['w']))
{
	$new_width = $_GET['w'];
	
	if (isset($_GET['h']))
		$new_height = $_GET['h'];
	else
		$new_height = ($new_width / $width) * $height;
}
else
{
	if (isset($_GET['h']))
	{
		$new_height = $_GET['h'];
		if (isset($_GET['w']))
			$new_width = $_GET['w'];
		else
			$new_width = ($new_height / $height) * $width;
	}
	else
	{
		$new_width = $width;
		$new_height = $height;
	}
}
#if($debug)
    echo "\r\n\tspecified height: " . $_GET['h'] .
         "\r\n\tspecified width: " . $_GET['w'] .
         "\r\n\toriginal height: " . $height .
         "\r\n\toriginal width: " . $width . 
         "\r\n\tcalculated height: " . $new_height .
         "\r\n\tcalculated width: " . $new_width . "\r\n";

// Resample
$image_p = imagecreatetruecolor($new_width, $new_height); // creates a blank black image
#if($debug)var_dump($image_p);
$image = imagecreatefrompng($filename); // creates a conceptual representation of the source image
#if($debug)var_dump($image);

imagealphablending( $image_p, false ); // tells PHP that the alpha channel is pre-blended
imagesavealpha( $image_p, true ); // tells PHP to save the alpha channel with the end output

imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height); // Resamples the original image to the specified size
#if($debug)var_dump($image_p);
if ($debug)
{
    $end = microtime (true);
	$text =
           'Took ' . ($end - $start) . " seconds to calculate\r\n"
         .   'specified height: '  . (isset($_GET['h']) ? $_GET['h'] : 'x')
         . '; specified width: '   . (isset($_GET['w']) ? $_GET['w'] : 'x')
         . '; original height: '   . $height
         . '; original width: '    . $width
         . '; calculated height: ' . $new_height
         . '; calculated width: '  . $new_width;
    echo $text;
	
	$textSize = 8;
	$textColor = imagecolorallocate($image_p, 34, 119, 187);
    imagefilledrectangle($image_p, 0, 0, $width, ($textSize + 4) * 2, imagecolorallocate($image_p, 255, 255, 255));
	imagettftext($image_p, $textSize, 0, 0, $textSize + 2, $textColor, '../_css/fonts/Inconsolata-Regular.ttf', $text);
	//imagestring($image_p, $textSize, 0, 0,  $text, $textColor);
}

// Output
flush(); // Write any bits waiting to be written
#if($debug)echo "\r\n\r\nPNG CODE:\r\n\r\n";
ob_clean(); // ensure a completely clean, headerless file. This also has the benefit of removing the debug echoes and var_dumps
header('Content-Type: image/png'); // specify that this is a PNG
imagepng($image_p); // Write the image and all its headers
imagedestroy($image_p); // Remove the image from memory
exit; // Stop executing code in this file
?>