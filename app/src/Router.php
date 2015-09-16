<?php

namespace Lees;

class Router
{
    public static function getActionResponse(
        \Slim\App $app,
        $name,
        \Psr\Http\Message\ServerRequestInterface $request,
        \Psr\Http\Message\ResponseInterface $response,
        array $args
    ) {
        $actionName = sprintf('Lees\Action\%sAction', ucfirst($name));
        $action = new $actionName($app, $request, $response, $args);
        return $action->response();
    }
}
