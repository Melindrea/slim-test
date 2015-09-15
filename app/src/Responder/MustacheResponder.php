<?php

namespace Lees\Responder;

use Lees\Traits\Mustache;

class MustacheResponder implements \Lees\Interfaces\Respondable
{
    use Mustache;
    protected $response;

    public function __construct(\Slim\App $app, \Lees\Interfaces\Viewable $class)
    {
        $this->response = $this->renderMustache($app, $class);
    }

    public function response()
    {
        return $this->response;
    }
}
