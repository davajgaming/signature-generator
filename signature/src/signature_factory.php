<?php
/**
 *
 * @package Signature Generator
 * @copyright (c) 2010 Sam Thompson <sam@websyntax.net>
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link http://www.websyntax.net/projects/signature-generator/
 */

class Signature_Factory
{
	public $sigId = 0;
	private $sigData = array();
	private $themeData = array();
	private $img;

	public function __construct()
	{
		if(class_exists('gd'))
		{
			include SIGGEN_ROOT . 'includes/gd_class.php';
		}
	}

	/*
	 * Load theme
	 */
	public function loadTheme($theme)
	{
		if(file_exists(SIGGEN_ROOT . 'plugins/' . $theme))
		{
			define(PLUGIN_ROOT, SIGGEN_ROOT . 'plugins/' . $theme . '/');
			$classname = 'Plugin_' . $theme;

			if(!class_exists($classname))
			{
				include PLUGIN_ROOT . 'plugin.php';
			}

			$this->themeData = $classname::getInfo();
		}

		return $this;
	}

	/*
	 * Loads user data into our class properties
	 *
	 * @param array $sigRow Database row
	 */
	public function loadUserData($sigRow)
	{
		$this->sigId = (int) $sigRow['sig_id'];
		$this->sigData = $sigRow['sig_data'];

		return $this;
	}

	/*
	 * Builds the signature
	 *
	 * @return $this
	 */
	public function buildSignature()
	{
		$this->img = new gd(
			$this->themeData['width'],
			$this->themeData['height'],
			$this->themeData['imgtype'],
			$this->themeData['imgqual'],
		);

		// Set up the text
		$this->img
			->set_font($this->themeData['font'])
			->set_color($this->themeData['color']);

		// Loop through the fields
		foreach($this->themeData['fields'] as $name => $data)
		{
			// Check for an empty value 
			if(empty($this->sigData[$name]))
			{
				continue;
			}

			if($data['output'] == 'text')
			{
				$this->img->print_text(
					$this->sigData[$name],
					$this->themeData['size'],
					$this->themeData['pos-x'],
					$this->themeData['pos-y']
				);
			}
			else if($data['output'] == 'img')
			{
				$this->img->print_img(
					$this->sigData[$name],
					$this->themeData['pos-x'],
					$this->themeData['pos-y']
				);
			}
		}

		return $this;
	}

	/*
	 * Output to stream
	 */
	public function outputStream()
	{
		if($this->img == null)
		{
			return false;
		}
		
		$this->img->output_img();
	}

	/*
	 * Output to file
	 * {sigid}.{ext}
	 */
	public function outputFile()
	{
		if($this->img == null)
		{
			return false;
		}

		$this->img->output_img($this->sigId);
	}
}
