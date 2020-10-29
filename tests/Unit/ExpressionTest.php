<?php

namespace Tests\Unit;

use App\Services\VerbalExpression;
use Tests\TestCase;

class ExpressionTest extends TestCase
{

    public function test_verbal_expression_api_chained()
    {
        $regex = new VerbalExpression();

        $regex->startOfLine()
            ->then("http")
            ->maybe('s')
            ->then("://")
            ->maybe("www.")
            ->anythingBut(" ")
            ->endOfLine();

        $this->assertEquals('/^http(?:s)?\:\/\/(?:www\.)?(?:[^ ]*)?$/',$regex->getRegex());
        $this->assertRegExp($regex->getRegex(),'http://www.asdfasdf.asdf');
        $this->assertTrue($regex->test('http://www.asdfasdf.asdf'));
        $this->assertFalse($regex->test('http://www.asdf asdf.asdf'));
    }

    function test_verbal_expression_api_single()
    {

        $regex = new VerbalExpression();

        $regex->startOfLine();

        $this->assertEquals('/^/',$regex->getRegex());
        $this->assertRegExp($regex->getRegex(),'');

        $regex->endOfLine();

        $this->assertEquals('/^$/',$regex->getRegex());
        $this->assertRegExp($regex->getRegex(),'');

        $regex->then('http');

        $this->assertEquals('/^http$/',$regex->getRegex());
        $this->assertRegExp($regex->getRegex(),'http');

        $regex->maybe("www.");
        $this->assertEquals('/^http(?:www\.)?$/',$regex->getRegex());
        $this->assertRegExp($regex->getRegex(),'httpwww.');
    }


}
