<?php

App::uses('AppShell', 'Console/Command');

class CleanupShell extends AppShell {
	public function main() {
		$rmGit = strtoupper($this->in('Remove the .git directory? [y/n]'));
		if ($rmGit === 'Y') {
			$this->out('Removing ' . APP . '.git');
			shell_exec('rm -rf ' . APP . '.git');
		} elseif ($rmGit !== 'N') {
			$this->out("You didn't respond with y or n, so .git was not removed");
		}
		$this->hr();

		$lnCore = strtoupper($this->in('Symlink CakePHP core in Lib? [y/n]'));
		if ($lnCore === 'Y') {
			$this->out('Symlinking CakePHP core in ' . APP . 'Lib');
			shell_exec('ln -s ' . CAKE_CORE_INCLUDE_PATH . DS . 'Cake ' . APP . 'Lib/Cake');
			foreach (array('index.php', 'test.php') as $file) {
				$path = APP.WEBROOT_DIR.DS.$file;
				$content = file_get_contents($path);
				$handle = fopen($path, 'w');
				$content = preg_replace(
					"/define\('CAKE_CORE_INCLUDE_PATH', .+\);/",
					"define('CAKE_CORE_INCLUDE_PATH', ROOT . DS . APP_DIR . DS . 'Lib');",
					$content
				);
				fwrite($handle, $content);
				fclose($handle);
			}
			shell_exec('mv '.APP.'Console'.DS.'cake.php.default '.APP.'Console'.DS.'cake.php');
		} elseif ($lnCore !== 'N') {
			$this->out("You didn't respond with y or n, so core was not symlinked");
		}
		$this->hr();

		$cpDatabase = strtoupper($this->in('Copy database.php.default to database.php? [y/n]'));
		if ($cpDatabase === 'Y') {
			$this->out('Copying Config/database.php.default to Config/database.php');
			shell_exec('cp ' . APP . 'Config' . DS . 'database.php.default ' . APP . 'Config' . DS . 'database.php');
		} elseif ($cpDatabase !== 'N') {
			$this->out("You didn't respond with y or n, so database.php.default was not copied");
		}
		$this->hr();

		$mvHome = strtoupper($this->in('Move the ember home.ctp into place? [y/n]'));
		if ($mvHome === 'Y') {
			$base = APP . 'View' . DS . 'Pages' . DS . 'home.ctp';
			if (file_exists($base.'.ember')) {
				$this->out('Moving ember home.ctp into place.');
				shell_exec('mv ' . $base . '.ember ' . $base);
			} else {
				$this->out('home.ctp.ember does not exist in ' . str_replace('home.ctp', '', $base));
			}
		} elseif ($mvHome !== 'N') {
			$this->out("You didn't respond with y or n, so ember home.ctp was not moved");
		}
		$this->hr();
	}
}
