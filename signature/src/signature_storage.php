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

abstract class Signature_Storage_Base
{
	/*
	 * Grab the signature data given a signature id
	 *
	 * @param int $sigId The signature ID
	 * @return array Rowset of the signature
	 */
	abstract public function grabSignatureData($sigId);

	/**
	 * Store the signature data
	 *
	 * @param int $sigId The signature ID
	 * @param string $owner The signature owner identifier as it's known to the applicaiton
	 * @param string $theme The theme identifier
	 * @param array $data Data from the signature fields
	 */	
	abstract public function storeSignatureData($sigId, $owner, $theme, $data);
}