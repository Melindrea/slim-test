<?php

namespace Lees\Responder;

use Lees\View;
use Lees\Library;

class ViewModelResponder extends MustacheResponder
{
    public function __construct(
        \Slim\App $app,
        \Psr\Http\Message\ServerRequestInterface $request,
        \Psr\Http\Message\ResponseInterface $response,
        \Lees\Interfaces\Viewable $viewModel
    ) {

        $content = $this->renderMustache($app, $viewModel);

        parent::__construct($app, $request, $response, $content);
    }
}
