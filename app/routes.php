<?php
namespace Lees;

$app->get('/', function ($request, $response, $args) {
    return Router::getActionResponse($this, 'index', $request, $response, $args);
})->setName('index');
