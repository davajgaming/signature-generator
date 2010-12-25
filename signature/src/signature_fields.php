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
define('TPL_INPUT_RADIO',       '<input type="radio" name="data[%s]" value="%s"%s /> %s<br />');
define('TPL_INPUT_SELECT',      '<select name="data[%s][]"%s>%s</select>');
define('TPL_INPUT_OPTION',      '<option value="%s"%s>%s</option>');
define('TPL_INPUT_TEXT',        '<input type="text" name="data[%s]" value="%s" />');

/*
 * Signature Fields
 *
 * Genreate HTML and input data
 */
class Signature_Fields
{
	/*
	 * Validation errors
	 */
	public $errors = array();

	/*
	 * Defaults for the HTML fields
	 */
	public $defaults = array();
	

	/*
	 * Array returned from the them getInfo() method
	 */
	private $theme = array();

	/*
	 * Constructor (not used now)
	 */
	public function __costruct()
	{
	}

	/*
	 * Load the theme into a property
	 */
	public function loadTheme($theme)
	{
		$this->theme = $theme;
		return $this;
	}

	/*
	 * Load defaults from an array (database)
	 */
	public function loadDefaults($data)
	{
		$this->defaults = $data;
		return $this;
	}

	/**
	 * Builds everything for the template
	 *
	 * @return array
	 */
	public function buildFields()
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
					$input = sprintf(TPL_INPUT_TEXT, $id, $this->defaults[$id]);
				break;

				case 'select':
					$multiple = ($max || $min)  ? ' multiple="multiple"' : '';
					$options = '';

					foreach($field['data'] as $val => $text)
					{
						$sel = ($this->defaults[$id] == $val) ? ' selected="selected' : '';
						$options .= sprintf(TPL_INPUT_OPTION, $val, $sel, $text);
					}

					$input = sprintf(TPL_INPUT_SELECT, $id, $multiple, $options);
				break;

				case 'radio':
					$input = '';
					foreach($field['data'] as $val => $text)
					{
						$sel = ($this->defaults[$id] == $val) ? ' checked="checked"' : '';
						$input .= sprintf(TPL_INPUT_RADIO, $id, $val, $sel, $text);
					}

				break;

				case 'color':
					// @todo
				break;

				case 'checkbox':
					$sel = ($this->defaults[$id] == $val) ? ' checked="checked"' : '';
					$input = sprintf(TPL_INPUT_CHECKBOX, $id, $sel, $this->defaults[$id]);
				break;

				case 'system':
				case 'level':
					$input = sprintf(TPL_INPUT_HIDDEN, $id, $this->defaults[$id]);
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

		return $html;
	}

	/*
	 * Loads and validates defauts from Post Data
	 */
	public function getPostData()
	{
		if(sizeof($_POST['data']))
		{
			foreach($_POST['data'] as $key => $val)
			{
				// Check to make sure a few things are good:
				// - The data posted is properly mapped to a key in the theme
				// - The data is not a system or level input type which is non-user input
				if (isset($this->theme['fields'][$key]) && 
					$this->theme['fields'][$key]['input'] != 'system' &&
					$this->theme['fields'][$key]['input'] != 'level')
				{
					$max = $min = false;
					if(strpos(':', $this->theme['fields'][$key]['input']))
					{
						@list($type, $max, $min) = explode(':', $this->theme['fields'][$key]['input']);
					}
					else
					{
						$type = $this->theme['fields'][$key]['input'];
					}

					switch($type)
					{
						case 'text':
							// Santize
							$val = htmlspecialchars($val);

							// First set defaults for our max and min
							$max = ($max) ? $max : 255;
							$min = ($min) ? $min : 0;

							// Validate
							if(strlen($val) > $max || strlen($val) < $min)
							{
								$this->errors[$key] = 'Incorrect length';
							}

							// We are giving the value each time so it will
							// appear on the page. This is to ensure that they
							// can fix accordingly
							$this->defaults[$key] = $val;
						break;

						case 'int':
							$val = (int) $val;

							// Set defaults for max and min for our integer
							$max = ($max) ? $max : 10000;
							$min = ($min) ? $min : 0;

							// Validate and set
							if($val > $max || $val < $min)
							{
								$this->errors[$key] = 'Incorrect size';
							}

							$this->defaults[$key] = $val;
						break;

						case 'select':
							$max = ($max) ? $max : 1;
							$min = ($min) ? $min : 1;

							if(!is_array($val))
							{
								$val = array($val);
							}

							if(sizeof($val) > $max || sizeof($val) < $min)
							{
								$this->errors[$key] = "The number selected needs to be between $min and $max";
							}

							$this->defaults[$key] = array();
							foreach($val as $_v)
							{
								$this->defaults[$key][] = htmlspecialchars($_v);
							}
						break;

						case 'checkbox':
							// It's either true of false for a checkbox, take your pick.
							$this->defaults[$key] = ($val) ? true : false;
						break;

						case 'raido':
							// We're not going to give this a default value if there is nothing to set as default
							if(in_array($val, $this->theme['fields'][$key]['data']))
							{
								$this->defaults[$key] = ($val) ? $val : false;
							}
							else
							{
								$this->errors[$key] = 'An invalid option was selected';
							}
						break;

						case 'color':
							// @todo
						break;
					}
				}
			}
		}

		return $this;
	}
}