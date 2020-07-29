<?php

namespace Tests\Unit;


use Tests\TestCase;
use App\Inspections\Spam;

class SpamTest extends TestCase
{
    public function test_it_checks_for_invalid_keywords()
    {

        $spam = new Spam();

        $this->assertFalse($spam->detect('Innocent reply here'));

        $this->expectException(\Exception::class);

        $spam->detect('yahoo customer support');
    }

    public function test_it_checks_for_any_key_being_held_down()
    {

        $spam = new Spam();

        $this->expectException(\Exception::class);

        $spam->detect('Hello world aaaaaaaaaaaa');
    }


}
