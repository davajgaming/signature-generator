<?php
/*
 * Signature Generator Framework
 *
 * Copyright (c) 2011 Sam Thompson <sam@websyntax.net>
 * http://www.opensource.org/licenses/mit-license.php The MIT License
 *
 */

/*
 *
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * !!! THIS IS A SAMPLE FRONT-END FILE !!!
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * 
 * While it is usable, it is not recommended for use on a live website. Create your own
 * front-facing file using the APIs demonstrated here.
 *
 *
 */
 
define('IN_SIGNATURE', true);
require __DIR__ . '/common.php';

// Quick n Dirty(tm)
function pageHeader($title)
{
	echo "<html><head><title>$title</title></head><body>";
}

function pageFooter()
{
	echo "</body></html>";
}

$siggen->setThemePath(__DIR__ . '/themes')
	->setSourcePath(__DIR__ . '/imagsrc')
	->setStorePath(__DIR__ . '/images');
 
$mode = htmlspecialchars($_GET['mode']);

switch($mode)
{
	// Leveling up
	case 'level':
		pageHeader('Level Up :: Signature Generator');
		
		pageFooter();
		break;

	case 'create':
		pageHeader('Create :: Signature Generator');
		
		pageFooter();
		break;

	// Main Page
	case '':
		pageHeader('Signature Generator');
		$themes = $siggen->getThemes();
		
		echo "Choose a theme to get started<br />";
		foreach($themes as $theme)
		{
			echo '<br /><a href="index.php?mode=create&amp;theme=' . $theme['url'] . '">' . $theme['name'] . '</a>';
		}
		pageFooter();

		break;

	default:
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: index.php');
		break;
}
