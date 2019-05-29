<?php

use Youdao\Translate\Translate;
use PHPUnit\Framework\TestCase;
use Youdao\Translate\TranslateServiceProvider;

class TranslateTest extends TestCase
{
    protected $translate;

    public function setUp()
    {
        $this->translate = new Translate();
    }

    public function testTranslateText()
    {
        $this->assertInstanceOf(Translate::class, $this->translate);
    }
}