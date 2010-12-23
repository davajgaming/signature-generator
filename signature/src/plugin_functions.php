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

/*
 * Get images by prefix
 *
 * Scans the directory
 */
function get_imgs_by_prefix($prefix)
{
	static $contents;

	if(empty($contents))
	{
		// Open and scan
		$dir = opendir(PLUGIN_ROOT);
		$contents = scandir($dir);
		closedir($dir);
	}

	// Collect the valid images 
	$images = array();
	foreach($contents as $file)
	{
		if(strpos($contents, $prefix) === 0)
		{
			$images[$file] = str_replace(array('_', "\r"), array(' ', ''), substr($contents, strlen($prefix)));
		}
	}

	return $images;
}

/*
 * Get Images by List
 *
 * Reads the file line by line and produces an array containing the filename
 * and human readable text.
 *
 * $list['some_image.png'] => 'This is the text as it appears to the user'
 */
function get_imgs_by_list($listfile)
{
	$file = fopen(PLUGIN_ROOT . $listfile, 'r');

	$list = array();
	while(!feof($file))
	{
		// Read line
		$line = fgets($file);

		// Make sure it's what we're expecting
		if(!strpos($line, ':'))
		{
			continue;
		}

		// Explode and map to vars
		list($filename, $text) = explode(':', $line);

		// Make sure the file exists
		if(!file_exists(PLUGIN_ROOT . $filename))
		{
			continue;
		}

		// done with this element
		$list[$filename] = $text;
	}

	return $list;
}

/*
* Get an arbitrary global variable
*/
function get_global_variable($var)
{
	global $$var;

	return $$var;
}
