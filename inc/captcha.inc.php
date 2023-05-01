<?php
	$alphanum = '0123456789albcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$captcha_len = 6;
	$captcha_width = 100;
	$captcha_height = 30;
	$captcha_code = '';
		for ($i = 0; $i < $captcha_len; $i++){
			$index = rand(0,61);
			$captcha_code .= substr($alphanum, $index, 1);
		}
	session_start();
	$_SESSION['cap_code'] = $captcha_code;

	$img = imagecreatetruecolor($captcha_width, $captcha_height);
	$bc_color = imagecolorallocate($img, 255, 255, 255); 
	$text_color = imagecolorallocate($img, 250, 0, 0);
	$graphic_color = imagecolorallocate($img, 64, 64, 64);
	imagefill($img, 0, 0, $bc_color);

	for ($i = 0; $i<5; $i++){
		imageline($img, 0, rand() % $captcha_height,
				$captcha_width, rand() % $captcha_height,$graphic_color);
		}
		for ($i = 0; $i <25; $i++){
			imagesetpixel($img, rand() % $captcha_width, rand() % $captcha_height,
						$graphic_color);
		}
		imagestring($img, 5, 5, $captcha_height/2, $captcha_code, $text_color);
		header('Content-type: image/jpeg');
		imagejpeg($img);
		imagedestory($img);

?>