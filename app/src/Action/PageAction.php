<?php

namespace Lees\Action;

use Lees\Responder\MarkdownResponder as Responder;
use Lees\Library;

class PageAction extends Base
{
    public function __construct(
        \Slim\App $app,
        \Psr\Http\Message\ServerRequestInterface $request,
        \Psr\Http\Message\ResponseInterface $response,
        array $args = []
    ) {

        $page = Library\Arr::get($args, 'page');

        parent::__construct(new Responder($app, $request, $response, $page));
    }
}
