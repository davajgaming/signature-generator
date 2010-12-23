<?php
/**
 *
 * @package Signature Generator
 * @copyright (c) 2010 Sam Thompson <sam@websyntax.net>
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link http://www.websyntax.net/projects/signature-generator/
 */

define('SIGGEN_ROOT', dirname(__FILE__) . '/');
include SIGGEN_ROOT . 'signature_factory.php';

$theme = preg_replace("#[^a-z0-9]#i", '', $_REQUEST['theme']);
$signature = new Signature_Factory();

$signature->loadTheme($theme)
	->loadUserData(array(0, $_POST['data']))
	->buildSignature()
	->outputStream();