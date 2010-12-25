<?php
/**
 *
 * @package Signature Generator
 * @copyright (c) 2010 Sam Thompson <sam@websyntax.net>
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link http://www.websyntax.net/projects/signature-generator/
 */

define('SIGGEN_ROOT', dirname(__FILE__) . '/');

require SIGGEN_ROOT . 'bootstrap.php';
$tpl_vars = array();

switch($page)
{
	case '':
		$template = $twig->loadTemplate('index_body.html');
	break;

	case 'levelup':
		$template = $twig->loadTemplate('levelup.html');
	break;

	case 'login':
		$template = $twig->loadTemplate('login.html');
	break;

	default:
		$template = $twig->loadTemplate('create.html');
	break;
}

// Display
$template->display($tpl_vars);
exit;