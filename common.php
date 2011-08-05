<?php
/*
 * Signature Generator Framework
 *
 * Copyright (c) 2011 Sam Thompson <sam@websyntax.net>
 * http://www.opensource.org/licenses/mit-license.php The MIT License
 *
 */

use SignatureGenerator\Core;

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

