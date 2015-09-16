<?php
namespace Lees;

$app->get('/', function ($request, $response, $args) {
    return Router::getActionResponse($this, 'index', $request, $response, $args);
})->setName('index');

$app->get('/p/{page}', function ($request, $response, $args) {
    // return $response->withStatus(404);
    return Router::getActionResponse($this, 'page', $request, $response, $args);
})->setName('page');
