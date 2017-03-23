<?php
namespace Acme\Shop\Test\Domain\Models;

use Acme\Shop\Domain\Models\PositiveNumber;

class PositiveNumberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function 正の数()
    {
        $this->assertSame(1, ConcretePositiveNumber::of(1)->value());
    }

    /**
     * @test
     * @expectedException \Acme\Shop\Domain\Exceptions\InvariantException
     */
    public function 負の数()
    {
        ConcretePositiveNumber::of(-1);
    }
}

class ConcretePositiveNumber extends PositiveNumber
{
}
