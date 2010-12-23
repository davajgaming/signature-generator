<?php
// Config file
if(!defined('SIGGEN_ROOT'))
	exit;

/**
 * !!! THIS IS A SAMPLE CONFIGURATION FILE !!!
 *
 * In order to get the signature generator to work, you must
 * edit in your own database login information.
 *
 * $dsn - Connection string
 * $dbuser - The user to log in to the database with
 * $dbpass - The password for the user above
 *
 * SIGGEN_SAVE_PATH is a constant that must be defined in order to 
 * save the static signature images.
 *
 * URL_BASE is root web directory that the signature generator index.php
 * is located at relative to the domain.
 */
$dsn = 'mysql:host=localhost;dbname=siggen';
$dbuser = 'root';
$dbpass = 'myGoodPassword321';

// Save path
define('SIGGEN_SAVE_PATH', SIGGEN_ROOT . 'images/');
// URL base
define('URL_BASE', 'siggen/signature/');