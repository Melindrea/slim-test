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

Mustache_Autoloader::register();

// $template = 'Hello, {{name}},<br /> Today is {{dayoftheweek}}, and the time is {{currentime}}';
// //set the template values
// $values = array(
//     'name'=>'John',
//     'dayoftheweek'=>date('l'),
//     'currentime'=>date('H:i:s')
// );

// //start the mustache engine
// $m = new Mustache_Engine;
// //render the template with the set values
// echo $m->render($template, $values);

// Database - https://github.com/illuminate/database
// Various handlers and stuff
$container = $app->getContainer();
$m = new Mustache_Engine;

$container['View'] = function ($c) {
    return new Mustache_Engine;
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
