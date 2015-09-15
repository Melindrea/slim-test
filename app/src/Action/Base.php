<?php

namespace Lees\Action;

abstract class Base implements \Lees\Interfaces\Respondable
{
    protected $response;
    protected $responser;

    public function __construct(
        \Slim\App $app,
        \Psr\Http\Message\ServerRequestInterface $request,
        \Psr\Http\Message\ResponseInterface $response,
        \Lees\Interfaces\Respondable $responder) {

        $this->response = $response;
        $this->responder = $responder;
    }

    public function response()
    {
        $this->response->write(
            $this->responder->response()
        );

        return $this->response;
    }
}
