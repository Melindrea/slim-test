<?php

namespace Lees\Responder;

abstract class Base implements \Lees\Interfaces\Respondable
{
    protected $response;
    protected $request;
    protected $responseString;

    public function __construct(
        \Slim\App $app,
        \Psr\Http\Message\ServerRequestInterface $request,
        \Psr\Http\Message\ResponseInterface $response
    ) {

        $this->response = $response;
        $this->request = $request;
    }

    public function response()
    {
        $this->response->write(
            $this->responseString
        );

        return $this->response;
    }
}
