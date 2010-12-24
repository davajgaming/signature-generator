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

// All the templates for HTML generation
define('TPL_INPUT_HIDDEN',      '<input type="hidden" name="data[%s]" value="%s" />');
define('TPL_INPUT_CHECKBOX',    '<input type="checkbox" name="data[%s]" value="%s"%s />');
define('TPL_INPUT_RADIO',       '<input type="radio" name="data[%s]" value="%s" %s/> %s<br />');
define('TPL_INPUT_SELECT',      '<select name="%s"%s>%s</select>');
define('TPL_INPUT_OPTION',      '<option value="%s"%s>%s</option>');
define('TPL_INPUT_TEXT',        '<input type="text" name="data[%s]" value="%s" />');

/*
 * Signature Fields
 *
 * Genreate HTML and input data
 */
class Signature_Fields
{
	private $theme = array();
	private $dbRow = array();

	public function __costruct()
	{
	}

	public function loadTheme($theme)
	{
		$this->theme = $theme;
		return $this;
	}

	public function loadDefaults($data)
	{
		$this->dbRow = $data;
		return $this;
	}

	/**
	 * Builds everything for the template
	 *
	 * @return array
	 */
	public function factory()
	{
		// our container for the value to be returned
		$html = array();

		// The loop... of somewhat epic proportions
		foreach($this->theme['fields'] as $id => $field)
		{
			$max = $min = false;

			if(strpos(':', $field['input']))
			{
				@list($type, $max, $min) = explode(':', $field['input']);
			}
			else
			{
				$type = $field['input'];
			}

			// switch out our fields
			switch($type)
			{
				case 'text':
				case 'int':
					$input = sprintf(TPL_INPUT_TEXT, $id, $this->dbRow[$id]);
				break;

				case 'select':
					$multiple = ($max || $min)  ? ' multiple="multiple"' : '';
					$options = '';

					foreach($field['data'] as $val => $text)
					{
						$sel = ($this->dbRow[$id] == $val) ? ' selected="selected' : '';
						$options .= sprintf(TPL_INPUT_OPTION, $val, $sel, $text);
					}

					$input = sprintf(TPL_INPUT_SELECT, $id, $multiple, $options);
				break;

				case 'radio':
					$input = '';
					foreach($field['data'] as $val => $text)
					{
						$sel = ($this->dbRow[$id] == $val) ? ' checked="checked' : '';
						$input .= sprintf(TPL_INPUT_RADIO, $id, $val, $sel, $text);
					}

				break;

				case 'color':
					// @todo
				break;

				case 'checkbox':
					$sel = ($this->dbRow[$id] == $val) ? ' checked="checked' : '';
					$input = sprintf(TPL_INPUT_CHECKBOX, $id, $sel, $this->dbRow[$id]);
				break;

				case 'system':
				case 'level':
					$input = sprintf(TPL_INPUT_HIDDEN, $id, $this->dbRow[$id]);
				break;

				default:
					continue;
				break;
			}

			$html[] = array(
				'title'	=> empty($field['title']) ? '' : $field['title'],
				'desc'	=> empty($field['desc']) ? '' : $field['desc'],
				'input'	=> $input,
			);
		}
	}
}