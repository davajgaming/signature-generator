<?php
/**
 *
 * @package Signature Generator
 * @copyright (c) 2010 Sam Thompson <sam@websyntax.net>
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link http://www.websyntax.net/projects/signature-generator/
 */

if(!defined('SIGGEN_ROOT'))
	exit;

class Field_Builder
{
	private $theme = array();

	public function __costruct()
	{
	}

	public function loadTheme($theme)
	{
		$this->theme = $theme;
	}

	public function loadDefaults($data)
	{
	}
}
