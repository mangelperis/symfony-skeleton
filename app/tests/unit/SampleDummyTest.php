<?php

namespace App\Tests;

use SampleTest;
use PHPUnit\Framework\TestCase;

class SampleDummyTest extends TestCase
{
    private Calculator $calculator;
    public function setUp(): void
    {
        $this->calculator = new Calculator();
    }

    public function testAdd(): void
    {
        $result = $this->calculator->add(a:2, b:3);
        $this->assertEquals(5, $result);
    }

    public function testSub(): void
    {
        $calculator = new Calculator();
        $result = $calculator->substract(a:2, b:3);
        $this->assertEquals(-1, $result);
    }
}

class Calculator
{
    public function add(int $a, int $b): int
    {
        return $a + $b;
    }

    public function substract(int $a, int $b): int
    {
     return $a - $b;
    }
}
