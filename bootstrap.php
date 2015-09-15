<?php

/**
 * Set the default time zone.
 *
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('Europe/Stockholm');

/**
 * Set the default locale.
 *
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'sv_SE.utf-8');

// Autoloader
require(ROOT . 'vendor/autoload' . EXT);

// Load environment -- Maybe? http://jpbetley.com/php-dotenv/
$dotenv = new \Dotenv\Dotenv(ROOT);
$dotenv->load();

$configPaths = function ($basePath) {
    $configDir = (getenv('CONFIG')) ?: 'app/config';
    $configPath = realpath($basePath . $configDir);
    $paths = [
        $configPath,
    ];

    $envPath = $configPath . DIRECTORY_SEPARATOR . getenv('ENV');
    if (file_exists($envPath) && is_dir($envPath)) {
        $paths[] = $envPath;
    }

    return $paths;
};

// Load config
$config = new \Noodlehaus\Config($configPaths(ROOT));

// Maybe set an environment to be used elsewhere too?

// Initiate app
$app = new \Slim\App();

// Database - https://github.com/illuminate/database
// Various handlers and stuff
$container = $app->getContainer();

$container['view'] = function ($c) {
    return new Mustache_Engine([
        'loader' => new Mustache_Loader_FilesystemLoader(ROOT . 'app/views'),
        'partials_loader' => new Mustache_Loader_FilesystemLoader(ROOT . 'app/views/partials'),
    ]);
};

// Logger - http://akrabat.com/logging-errors-in-slim-3/
// https://github.com/akrabat/slim3-skeleton
$container['Logger'] = function($c) {
    $logger = new Monolog\Logger('logger');
    $filename = _DIR__ . '/../log/error.log'; // Should be from config
    $stream = new Monolog\Handler\StreamHandler(
        $filename,
        Monolog\Logger::DEBUG
    );
    $fingersCrossed = new Monolog\Handler\FingersCrossedHandler(
        $stream,
        Monolog\Logger::ERROR
    );
    $logger->pushHandler($fingersCrossed);

    return $logger;
};
