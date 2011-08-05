<?php
/*
 * Signature Generator Framework
 *
 * Copyright (c) 2011 Sam Thompson <sam@websyntax.net>
 * http://www.opensource.org/licenses/mit-license.php The MIT License
 *
 */

namespace Signature;

if (!defined('\IN_SIGNATURE')) exit;

/*
 * Core API
 */
class Core
{
	/*
	 * Paths to themes
	 */
	public $themePath = '';

	/*
	 * Paths to source images
	 */
	public $sourcePath = '';	

	/*
	 * Paths to completed images
	 */
	public $storePath = '';

	/*
	 * Set the theme path
	 *
	 * @param string $path - Path to the themes. Should be an absolute path obtained via __DIR__ or something similar
	 * @return object - Instance of \SignatureGenerator\Core
	 */
	public function setThemePath($path)
	{
		$this->themePath = $path;

		return $this;
	}

	/*
	 * Set the theme source path
	 *
	 * @param string $path - Path to the source. Should be an absolute path obtained via __DIR__ or something similar
	 * @return object - Instance of \SignatureGenerator\Core
	 */
	public function setSourcePath($path)
	{
		$this->sourcePath = $path;

		return $this;
	}

	/*
	 * Set the store path for completed signatures. MUST be writable by PHP
	 *
	 * @param string $path - Path to completed signatures. Should be an absolute path obtained via __DIR__ or something similar
	 * @return object - Instance of \SignatureGenerator\Core
	 */
	public function setStorePath($path)
	{
		$this->storePath = $path;

		return $this;
	}

	/*
	 * Get all the theme info
	 * This function checks for existence, includes, and runs other things. I
	 * recommend caching this data for production sites because it is unlikely
	 * the data here changes very often.
	 *
	 * @return array - Theme info
	 */
	public function getThemes()
	{
		$files = scandir($this->themePath);
		$themes = array();

		foreach($files as $file)
		{
			if ($file[0] == '.' || substr(strrchr($file, '.'), 1) != 'php')
			{
				continue;
			}

			include $this->themePath . '/' . $file;
			
			$class = substr($file, 0, strpos($file, '.'));
			if (!class_exists($file))
			{
				continue;
			}

			$themes[] = $class::getInfo();
		}

		return $themes;
	}
}
