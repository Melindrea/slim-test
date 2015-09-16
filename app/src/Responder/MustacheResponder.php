<?php

namespace Lees\Responder;

use Lees\Traits\Mustache;
use Lees\View;

class MustacheResponder extends Base
{
    use Mustache;

    public function __construct(
        \Slim\App $app,
        \Psr\Http\Message\ServerRequestInterface $request,
        \Psr\Http\Message\ResponseInterface $response,
        $content
    ) {
        parent::__construct($app, $request, $response);

        $layout = new View\Layouts\Master($content);
        $this->responseString = $this->renderMustache($app, $layout);
    }
}
