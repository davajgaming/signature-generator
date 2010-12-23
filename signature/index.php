<?php
/**
 *
 * @package Signature Generator
 * @copyright (c) 2010 Sam Thompson <sam@websyntax.net>
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link http://www.websyntax.net/projects/signature-generator/
 */

define('SIGGEN_ROOT', dirname(__FILE__) . '/');

include SIGGEN_ROOT . 'config.php';
include SIGGEN_ROOT . 'src/url_handler.php';
include SIGGEN_ROOT . 'src/signature_factory.php';
include SIGGEN_ROOT . 'src/field_builder.php';

$url = new Url_Handler(URL_BASE);
$page = $url->get('');
switch($page)
{
	case '':
	break;

	case 'levelup':
	break;

	default:
		if(!file_exists(SIGGEN_ROOT . 'plugins/' . $page))
		{
			// 404 page
			header('HTTP/1.1 404 Not Found');
			echo "<html><head><title>Not Found</title></head><body><h1>404 Not Found</h1><p>The page you requeted does not exist.</p></body></html>";
			exit;
		}

		include SIGGEN_ROOT . 'plugins/' . $page . '/plugin.php';

	break;
}

exit;
