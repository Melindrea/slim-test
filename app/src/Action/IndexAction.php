<?php

namespace Lees\Action;

use Lees\Responder\ViewModelResponder as Responder;
use Lees\View\Pages\Index;

class IndexAction extends Base
{
    public function __construct(
        \Slim\App $app,
        \Psr\Http\Message\ServerRequestInterface $request,
        \Psr\Http\Message\ResponseInterface $response,
        array $args = []
    ) {

        // This is where we do all the things to turn args/etc
        // into a view to be consumed by whichever responder we're using
        // $
        $view = new Index();

        parent::__construct(new Responder($app, $request, $response, $view));
    }
}
