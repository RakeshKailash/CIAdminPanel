<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ImageManipulation {

	public function compress($source, $destination, $quality) {

		$info = getimagesize($source);

		if ($info['mime'] == 'image/jpeg') 
			$image = imagecreatefromjpeg($source);

		elseif ($info['mime'] == 'image/gif') 
			$image = imagecreatefromgif($source);

		elseif ($info['mime'] == 'image/png') 
			$image = imagecreatefrompng($source);

		imagejpeg($image, $destination, $quality);

		unlink($source);

		return $destination;
	}

	public function squareCrop ($src, $dest, $size=100, $quality=80) {
		if (! $src) {
			return false;
		}

		try {

			list($width, $height) = getimagesize($src);

			$myImage = imagecreatefromjpeg($src);

			if ($width > $height) {
				$y = 0;
				$x = ($width - $height) / 2;
				$smallestSide = $height;
			} else {
				$x = 0;
				$y = ($height - $width) / 2;
				$smallestSide = $width;
			}

			$thumb = imagecreatetruecolor($size, $size);
			imagecopyresampled($thumb, $myImage, 0, 0, $x, $y, $size, $size, $smallestSide, $smallestSide);

			imagejpeg($thumb, $dest, $quality);
			return true;
		} catch (Exception $e) {
			return false;
		}
	}
}