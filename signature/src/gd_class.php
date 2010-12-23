<?php

// GD Library... OOP Wrapper build just for the sig gen

class gd
{
	private $img;
	
	private $font_file = '';
	private $font_type = '';
	private $final_type = '';
	
	private $color = 0;
	private $height = 0;
	private $width = 0;
	private $quality = 0;
	
	public function __construct($width, $height, $final_img_type = 'jpg', $quality = 75)
	{
		$this->img = imagecreatetruecolor($width, $height);
		$this->height = $height;
		$this->width = $width;
		$this->final_type = $final_img_type;

		// Quality is a percent, so we must make it behave as such
		switch($final_img_type)
		{
			case 'jpg':
			case 'jpeg':
				// with jpeg this works quite well, the number is already
				// between 1-100 for the quality, with 0 being the worst
				$this->quality = $quality; 
			break;
			
			case 'png':
				// We have to jump to percent here because unlike jpeg
				// it's not 'quality' but a compression level, 1-9.
				$float_comp = ($quality / 100) * 9;
				$this->quality = round($float_comp); 
			break;
		}
		// @note: GIF does not have a quality quantifier
	
		return;
	}

	// Set the font
	public function set_font($font_file)
	{
		$this->font_file = PLUGIN_ROOT . $font_file;
		$this->font_type = substr(strrchr($font_file, '.'), 1);
		
		return $this;
	}

	// Set the text color
	public function set_color($html_hex = '000000')
	{
		$hex = str_replace('#', '', $html_hex);
		$red = hexdec(substr($hex, 0, 2)); 
		$gre = hexdec(substr($hex, 2, 2));
		$blu = hexdec(substr($hex, 4, 2));
		
		$this->color = imagecolorallocate($this->img, $red, $gre, $blu);
		
		return $this;
	}

	// Print text on the image
	public function print_text($text, $size, $x, $y, $angle = 0)
	{
		switch($this->font_type)
		{
			case 'otf':
			case 'ttf':
				imagefttext($this->img, $size, $angle, $x, $y, $this->color, $this->font_file, $text);
			break;
		}

		return $this;
	}

	// Pint an image on the image
	public function print_img($source_img, $dest_x, $dest_y, $src_x = 0, $src_y = 0, $pct = 100)
	{
		$filename = PLUGIN_ROOT . $source_img;
		list($src_width, $src_height) = getimagesize($filename);

		$source = $this->imagecreatefrom($filename);
		imagecopymerge($this->img, $source, $dest_x, $dest_y, $src_x, $src_y, $src_width, $src_height, $pct);

		return $this;
	}

	// Output the image 
	public function output_img($filename = null)
	{
		if(empty($filename))
		{
			header("Content-type: image/{$this->final_type}");
		}
		else
		{
			$save_file = SIGGEN_SAVE_PATH . $filename . '.' $this->final_type;
		}

		switch($this->final_type)
		{
			case 'jpg':
			case 'jpeg':
				imagejpeg($this->img, $save_file, $this->quality);
			break;
			
			case 'gif':
				// Null as the 2nd param is invalid if the quality is not there,
				// gif must be separated. Addtionally, gif have NO compression or
				// quality quantifier.
				if($save_file)
				{
					imagegif($this->img, $save_file);
				}
				else
				{
					imagegif($this->img);
				}
			break;
			
			case 'png':
				imagepng($this->img, $save_file, $this->quality);
			break;
		}

		imagedestroy($this->img);

		// Output to stream? Exit out.
		if(!$save_file)
		{
			exit;
		}
	}

	// Create an image from a file
	private function imagecreatefrom($filename)
	{
		$type = substr(strrchr($filename, '.'), 1);

		switch($type)
		{
			case 'jpg':
			case 'jpeg':
				return imagecreatefromjpeg($filename);
			break;
			
			case 'gif':
				return imagecreatefromgif($filename);
			break;
			
			case 'png':
				return imagecreatefrompng($filename);
			break;
		}

		return;
	}
}

?>