<?php

// Image manip abstraction for the GD library

class gd
{
	private $img;
	
	private $theme = '';
	private $font_file = '';
	private $font_type = '';
	private $final_type = '';
	
	private $color = 0;
	private $height = 0;
	private $width = 0;
	private $quality = 0;
	
	public function __construct($theme, $width, $height, $final_img_type = 'jpg', $quality = 0)
	{
		$this->theme = $theme;
		$this->img = imagecreatetruecolor($width, $height);
		$this->height = $height;
		$this->width = $width;
		$this->final_type = $final_img_type;
		$this->quality = $quality;
		
		return;
	}
	
	public function set_font($font_file)
	{
		global $root_path;
		
		$this->font_file = $root_path . 'img/sig_source/fonts/' . $font_file;
		$this->font_type = substr(strrchr($font_file, '.'), 1);
		
		return;
	}
	
	public function set_bg($bgimage)
	{
		$bg = $this->imagecreatefrom($bgimage);
		imagecopy($this->img, $bg, 0, 0, 0, 0, $this->width, $this->height);
		
		return;
	}
	
	public function set_color($html_hex)
	{
		$hex = str_replace('#', '', $html_hex);
		$red = hexdec(substr($hex, 0, 2)); 
		$gre = hexdec(substr($hex, 2, 2));
		$blu = hexdec(substr($hex, 4, 2));
		
		$this->color = imagecolorallocate($this->img, $red, $gre, $blu);
		
		return;
	}
	
	public function print_text($text, $size, $x, $y, $angle = 0)
	{
		switch($this->font_type)
		{
			case 'otf':
			case 'ttf':
				imagefttext($this->img, $size, $angle, $x, $y, $this->color, $this->font_file, $text);
			break;
		}
		
		return;
	}
	
	public function print_img($source_img, $dest_x, $dest_y, $src_x, $src_y, $pct = 100)
	{
		$filename = './img/sig_source/' . $this->theme . '/' . $source_img;
		list($src_width, $src_height) = getimagesize($filename);

		$source = $this->imagecreatefrom($filename);
		imagecopymerge($this->img, $source, $dest_x, $dest_y, $src_x, $src_y, $src_width, $src_height, $pct);
		
		return;
	}
	
	public function output_img($save_file = null)
	{
		if(empty($save_file))
		{
			header("Content-type: image/{$this->final_type}");
		}
		else
		{
			$save_file = './img/sigs/' . $save_file;
		}
		
		switch($this->final_type)
		{
			case 'jpg':
			case 'jpeg':
				imagejpeg($this->img, $save_file, $this->quality);
			break;
			
			case 'gif':
				// Null as the 2nd param is invalid if the quality is not there, gif must be separated
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