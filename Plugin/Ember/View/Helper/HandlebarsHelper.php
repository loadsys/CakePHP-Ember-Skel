<?php

App::uses('AppHelper', 'View/Helper');

class HandlebarsHelper extends AppHelper {
	protected $_templateTag = "<script type=\"text/x-handlebars\" data-template-name=\"%s\">\n%s\n</script>";

	/**
	 * Public inteface to load all handlebars templates in $path as script tags.
	 *
	 * @access public
	 * @param string $path
	 * @return string
	 */
	public function templates($path = null) {
		if (!$path) { return ''; }
		return implode("\n", $this->_loadTemplates($this->_fullPath($path)));
	}

	/**
	 * Takes a directory and loads the template files inside. Recursively calls
	 * itself for valid contained directories.
	 *
	 * @access protected
	 * @param string $path
	 * @return array
	 */
	protected function _loadTemplates($path) {
		$templates = array();
		if ($this->_validDirectory($path)) {
			if ($handle = opendir($path)) {
				while (false !== ($file = readdir($handle))) {
					if (is_dir($file)) {
						array_merge($templates, $this->_loadTemplates($path . DS . $file));
					} else {
						$templates[] = $this->_loadTemplate($path . DS . $file);
					}
				}
			} else {
				throw new Exception('Templates directory not found');
			}
			closedir($handle);
		}
		return array_filter($templates);
	}

	/**
	 * Is given the absolute path to a file and will load its contents and wrap
	 * it in a script tag with a data-template-name equal to the file name.
	 *
	 * @access protected
	 * @param string $path
	 * @return mixed
	 */
	protected function _loadTemplate($path) {
		if ($this->_validTemplate($path)) {
			return sprintf($this->_templateTag, $this->_templateName($path), file_get_contents($path));
		}
		return null;
	}

	/**
	 * All templates must exist in the applications webroot directory.
	 *
	 * @access protected
	 * @param string $path
	 * @return string
	 */
	protected function _fullPath($path) {
		return APP . WEBROOT_DIR . str_replace(DS.DS, DS, DS . $path);
	}

	/**
	 * Given a path to a file, this will convert the name to a hyphenated
	 * template name.
	 *
	 * @access protected
	 * @param string $path
	 * @return string
	 */
	protected function _templateName($path) {
		$parts = explode('.', $this->_fileName($path));
		$normalized = str_replace('_', '-', $parts[0]);
		$parts = explode('-', $normalized);
		$first = array_shift($parts);
		return $first . implode('', array_map('ucfirst', $parts));
	}

	/**
	 * Decides if a file for given path is a valid handlebars file.
	 *
	 * @access protected
	 * @param string $path
	 * @return boolean
	 */
	protected function _validTemplate($path) {
		$name = $this->_fileName($path);
		return preg_match('/.+\.(handlebars|hbs){1}/', $name) === 1;
	}

	/**
	 * Decides if a path is a directory and not . or ..
	 *
	 * @access protected
	 * @param string $path
	 * @return boolean
	 */
	protected function _validDirectory($path) {
		return is_dir($path) && !in_array($this->_fileName($path), array('.', '..'));
	}

	/**
	 * For a given path, returns just the file name and extension.
	 *
	 * @access protected
	 * @param string $path
	 * @return string
	 */
	protected function _fileName($path) {
		$parts = explode(DS, $path);
		return $parts[count($parts) - 1];
	}
}
