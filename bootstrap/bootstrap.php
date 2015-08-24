<?php

require(__DIR__ . '/../vendor/autoload.php');

$app = new \Slim\App();
$dotenv = new \Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load();
