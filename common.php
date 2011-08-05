<?php
/*
 * Signature Generator Framework
 *
 * Copyright (c) 2011 Sam Thompson <sam@websyntax.net>
 * http://www.opensource.org/licenses/mit-license.php The MIT License
 *
 */

use SignatureGenerator\Core;
use SignatureGenerator\Theme;

if (!defined('IN_SIGNATURE')) exit;

// Let's run some system tests real quick.
if (version_compare(PHP_VERSION, '5.3.0') >= 0)
{
	throw new RuntimeException("The Signature Generator Framework requires PHP 5.3.0 or greater.");
}

if (!class_exists('Mongo'))
{
	throw new RuntimeException("MongoDB Driver not found");
}

if (!file_exists(__DIR__ . '/config.php'))
{
	throw new RuntimeException("config.php not found");
}

require __DIR__ . '/config.php';

// Connect to MongoDB
$options = array();
$options['connect'] = true;

if (!empty($mdbUsername))
{
	$options['username'] = $mdbUsername;
}

if (!empty($mdbPassword))
{
	$options['password'] = $mdbPassword;
}

$mdbHost = ($mdbHost) ?: 'localhost';
$mdbPort = ($mdbPort) ?: 27017;
$mdbman = new Mongo("mongodb://{$mdbHost}:{$mdbPort}", $options);

$db = $mdbman->selectDB($mdbDatabase);

require __DIR__ . '/includes/Core.php';
require __DIR__ . '/includes/Theme.php';

$siggen = new Core();
