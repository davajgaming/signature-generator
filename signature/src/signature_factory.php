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
	public $sigOwner = '';
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
	 * Levels up the signature
	 *
	 * @param int $inc Increment to level up by (default: 1)
	 * @return $this
	 */
	public function loadUserData($sigRow)
	{
		$this->sigId = (int) $sigRow['sig_id'];
		$this->sigOwner = $sigRow['sig_owner'];
		$this->sigData = $sigRow['sig_data'];

		return $this;
	}

	/*
	 * Levels up the signature
	 *
	 * @param int $inc Increment to level up by (default: 1)
	 * @return $this
	 */
	public function levelUp($fieldName = 'level', $inc = 1)
	{
		if(!is_int($this->sigData[$fieldName]))
		{
			$this->sigData[$fieldName] = (int) $this->sigData[$fieldName];
		}

		$this->sigData[$fieldName]++;

		return $this;
	}

	/*
	 * Builds the signature
	 *
	 * @return $this
	 */
	public function buildSignature()
	{
		return $this;
	}

	public function getUserData()
	{
		return $this->sigData;
	}

	public function outputStream()
	{
	}

	public function outputFile()
	{
	}
}