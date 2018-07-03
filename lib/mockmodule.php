<?php

namespace Plusforta;

/**
 * Class MockModule
 * @package Plusforta
 */
class MockModule extends \Obj
{
    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = new MockField($key, $value);
        }
    }
}
