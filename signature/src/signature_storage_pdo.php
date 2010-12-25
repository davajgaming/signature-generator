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

class Signature_Storage_PDO extends Signature_Storage_Base
{
	private $conn;

	const SIGS_TABLE = 'signature_generator';

	public function __construct()
	{
	}

	public function connect($dsn, $user, $pass)
	{
		try
		{
			$this->conn = new PDO($dsn, $user, $pass);
		}
		catch(PDOException $e)
		{
			echo 'Failed to connect to the database: ' . $e->getMessage();
			exit;
		}
	}

	/*
	 * Grab the signature data given a signature id
	 *
	 * @return array Rowset of the signature
	 */
	public function grabSignatureData($sigId)
	{
		$sql = 'SELECT *
			FROM ' . self::SIGS_TABLE . '
			WHERE sig_id = ' . (int) $sigId;
		$row = current($this->conn->query($sql));
		
		$row['sig_data'] = unserialize($row['sig_data']);

		return $row['sig_data'];
	}

	/**
	 * Store the signature data
	 *
	 * @param int $sigId The signature ID
	 * @param string $owner The signature owner identifier as it's known to the applicaiton
	 * @param string $theme The theme identifier
	 * @param array $data Data from the signature fields
	 */
	public function storeSignatureData($sigId, $owner, $theme, $data);
	{
		// update and check affected rows

		// insert if no rows affected
	}
}