<?php

namespace Lees\Action;

abstract class Base implements \Lees\Interfaces\Respondable
{
    protected $responser;

    public function __construct(\Lees\Interfaces\Respondable $responder)
    {

        $this->responder = $responder;
    }

    public function response()
    {
        return $this->responder->response();
    }
}
