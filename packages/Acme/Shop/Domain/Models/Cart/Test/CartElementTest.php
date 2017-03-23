<?php
namespace Acme\Shop\Domain\Models\Cart\Test;

use Acme\Shop\Domain\Models\Cart\CartElement;
use Acme\Shop\Domain\Models\Item\ItemCount;
use Acme\Shop\Domain\Models\Item\ItemId;

class CartElementTest extends \PHPUnit_Framework_TestCase
{
    use FakeItem;

    /**
     * @test
     */
    public function match()
    {
        $cartElement = new CartElement($this->item(), ItemCount::of(1));

        $this->assertTrue($cartElement->match(ItemId::of(1)));
        $this->assertFalse($cartElement->match(ItemId::of(2)));
    }
}
