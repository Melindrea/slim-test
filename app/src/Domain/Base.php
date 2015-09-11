<?php

namespace Lees\Domain;

abstract class Base
{
    protected $fields = [];

    public function __debugInfo()
    {
        return $this->fields;
    }
    public function __toString()
    {
        return json_encode($this->fields);
    }

    public function __call($name, $arguments)
    {
        $action = substr($name, 0, 3);
        $key = strtolower(substr($name, 3));

        switch ($action) {
            case 'get':
                if (isset($this->fields[$key])) {
                    return $this->fields[$key];
                } else {
                    return null;
                }
                break;
            case 'set':
                $this->fields[$key] = $arguments[0];
                break;
            default:
                return null;
        }
    }
}
