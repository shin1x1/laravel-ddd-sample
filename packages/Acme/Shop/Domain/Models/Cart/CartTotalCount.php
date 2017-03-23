<?php
namespace Acme\Shop\Domain\Models\Cart;

use Acme\Shop\Domain\Models\Item\ItemCount;
use Acme\Shop\Domain\Models\PositiveNumber;

final class CartTotalCount extends PositiveNumber
{
    /**
     * @param ItemCount $number
     * @return CartTotalCount
     */
    public function add(ItemCount $number): self
    {
        return self::of($this->value + $number->value());
    }

    /**
     * @return CartTotalCount
     */
    public function clear(): self
    {
        return self::of(0);
    }
}
