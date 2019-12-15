<?php

namespace App\Helpers;

use Prophecy\Exception\Doubler\MethodNotFoundException;

abstract class HelperFunctions
{
    public function call(string $method, string $value)
    {
        if (!in_array($method, get_class_methods($this))) {
            throw new MethodNotFoundException("Current method is not defined", $this, $method);
        }

        return $this->$method($value);
    }
}
