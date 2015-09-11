<?php

namespace Lees\Domain\Identity;

class User extends \Lees\Domain\Base
{
    public function __construct(array $values = [])
    {
        foreach ($values as $property => $value) {
            $function = sprintf('set%s', ucfirst($property));
            $this->{$function}($value);
        }
    }
}
