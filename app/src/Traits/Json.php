<?php

namespace Lees\Traits;

trait Json
{
    protected function renderJson($data)
    {
        return json_encode($data);
    }
}
