<?php
/**
*
* @package Signature Generator Framework
* @copyright (c) 2010 Sam Thompson
* @license http://www.opensource.org/licenses/mit-license.php The MIT License
*
*/

if(!defined('SIGGEN_ROOT_PATH'))
	exit;

// Mongo DB compatible only
$dbHost	= '';
$dbUser	= '';
$dbPass	= '';
$dbName	= '';

$imgSrcPath		= ''; // Path to the image source files to build the sgnature
$imgSavePath	= ''; // Path to save the generated images to