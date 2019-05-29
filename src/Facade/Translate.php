<?php

namespace Youdao\Translate\Facade;

use Illuminate\Support\Facades\Facade;

class Translate extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'translator';
    }
}