<?php

namespace Tests\Unit;


use Tests\TestCase;
use App\Utilities\Spam;

class SpamTest extends TestCase
{
    public function test_it_validates_spam()
    {
       $spam = new Spam();

       $this->assertFalse($spam->detect('Innocent reply here'));

       $this->expectException(\Exception::class);

       $spam->detect('yahoo customer support');
    }


}
