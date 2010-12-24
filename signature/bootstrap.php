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

error_reporting(E_ALL);

include SIGGEN_ROOT . 'config.php';
include SIGGEN_ROOT . 'src/url_handler.php';
include SIGGEN_ROOT . 'src/signature_factory.php';
include SIGGEN_ROOT . 'src/field_builder.php';
include SIGGEN_ROOT . 'src/plugin_functions.php';
include SIGGEN_ROOT . 'src/SteamSignIn.php';
include SIGGEN_ROOT . 'src/Twig/lib/Twig/Autoloader.php';
include SIGGEN_ROOT . 'src/input_templates.php';

// URLs
$url = new Url_Handler(URL_BASE);
$page = $url->get('');

// Start Twig
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(SIGGEN_ROOT . '/views');

$twig = new Twig_Environment($loader, array(
	'debug' => true,
	'cache'	=> false, //SIGGEN_ROOT . 'cache/',
));

// Session settings
session_save_path(SIGGEN_ROOT . 'sessions');
session_start();
$now = time();

// Validate or create new session
if(	empty($_SESSION)
	|| $_SESSION['sessionexpire'] < $now
	|| $_SESSION['ipaddress'] != md5($_SERVER['REMOTE_ADDR'])
	|| $_SESSION['useragent'] != md5($_SERVER['HTTP_USER_AGENT']))
{
	$_SESSION = array(
		'useragent'		=> md5($_SERVER['HTTP_USER_AGENT']),
		'ipaddress'		=> md5($_SERVER['REMOTE_ADDR']),
		'sessionexpire'	=> $now + 3, // Hour
		'steamID'		=> '0', // Needs to be a string
	);
}
else
{
	$_SESSION['sessionexpire'] = $now + 3;
}
