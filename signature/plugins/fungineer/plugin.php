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

class Plugin_Fungineer
{
	public static function getInfo()
	{
		return array(
			'id'		=> 'Fungineer',
			'name'		=> 'Fungineering License',
			'height'	=> 100,
			'width'		=> 300,
			'font'		=> 'tf2build.ttf',
			'imgtype'	=> 'jpg',
			'imgqual'	=> 90,
			'fields'	=> array(

				'name'		=> array(
					'input'		=> 'system',
					'output'	=> 'text',
					'pos-x'		=> 0,
					'pos-x'		=> 0,
					'size'		=> 10,
					'data'		=> get_global_variable('steamid'),
				),

				'bg'		=> array(
					'title'		=> 'RED or BLU',
					'desc'		=> 'Your prefered color',
					'input'		=> 'radio',
					'output'	=> 'img',
					'pos-x'		=> 0,
					'pos-x'		=> 0,
					'data'		=> get_imgs_by_prefix('bg_'),
				),

				'level'		=> array(
					'input'		=> 'level',
					'output'	=> 'text',
					'pos-x'		=> 0,
					'pos-x'		=> 0,
					'size'		=> 14,
				),

				'nickname'	=> array(
					'title'		=> 'What name do your fellow fungineers know you by?',
					'input'		=> 'text:0:30',
					'output'	=> 'text',
					'pos-x'		=> 0,
					'pos-x'		=> 0,
					'size'		=> 14,
				),

				'wrench'	=> array(
					'title'		=> 'Which wrench do you use?',
					'desc'		=> 'Select one',
					'input'		=> 'select:1:1',
					'output'	=> 'img',
					'pos-x'		=> 0,
					'pos-x'		=> 0,
					'data'		=> self::getWrenchs(),
				),

				'hat'		=> array(
					'title'		=> 'Which hat do you wear?',
					'desc'		=> 'Select one',
					'input'		=> 'select:1:1',
					'output'	=> 'img',
					'pos-x'		=> 0,
					'pos-x'		=> 0,
					'data'		=> get_imgs_by_list('hats.list'),
				),
			),
		);
	}

	public static function getWrenchs()
	{
		return array(
			'w_original.png' => 'Vanilla Wrench',
			'w_gunslinger.png' => 'Gun Slinger',
			'w_southernhos.png' => 'Southern Hospitality',
		);
	}
}