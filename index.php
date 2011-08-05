<?php
/*
 * Signature Generator Framework
 *
 * Copyright (c) 2011 Sam Thompson <sam@websyntax.net>
 * http://www.opensource.org/licenses/mit-license.php The MIT License
 *
 */

define('IN_SIGNATURE', true);
include __DIR__ . '/common.php';

/*
 * !!! THIS IS A SAMPLE FRONT-END FILE !!!
 *
 * While it is usable, it is not recomeneded for use on a live website. Create your own
 * front-facing file using the APIs demonstrated here.
 */

$mode = htmlspecialchars($_GET['mode']);

switch($mode)
{
	// Leveling up
	case 'level':
		break;

	// Main Page
	case '':
		break;

	default:
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: index.php');
		break;
}