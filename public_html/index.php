<?php

// The root is the parent directory of the directory that index.php is in
define('ROOT', realpath(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR);

/**
 * The default extension of resource files. If you change this, all resources
 * must be renamed to use the new extension.
 *
 */
define('EXT', '.php');

/**
 * Set the PHP error reporting level. If you set this in php.ini, you remove this.
 * @link http://www.php.net/manual/errorfunc.configuration#ini.error-reporting
 *
 * When developing your application, it is highly recommended to enable notices
 * and strict warnings. Enable them by using: E_ALL | E_STRICT
 *
 * In a production environment, it is safe to ignore notices and strict warnings.
 * Disable them by using: E_ALL ^ E_NOTICE
 *
 * When using a legacy application with PHP >= 5.3, it is recommended to disable
 * deprecated notices. Disable with: E_ALL & ~E_DEPRECATED
 */
error_reporting(E_ALL | E_STRICT);

require(ROOT . 'bootstrap' . EXT);

// Define the absolute paths for configured directories
define('APP_PATH', realpath(ROOT . $config->get('dirs.app')) . DIRECTORY_SEPARATOR);
define('MODULES_PATH', realpath(ROOT . $config->get('dirs.modules')) . DIRECTORY_SEPARATOR);

// Start actual stuff here

require(APP_PATH . 'routes' . EXT);

$app->run();
