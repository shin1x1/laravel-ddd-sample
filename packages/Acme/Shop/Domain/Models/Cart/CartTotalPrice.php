<?php
namespace Acme\Shop\Domain\Models\Cart;

use Acme\Shop\Domain\Models\Item\ItemSubtotal;
use Acme\Shop\Domain\Models\PositiveNumber;

final class CartTotalPrice extends PositiveNumber
{
    /**
     * @param ItemSubtotal $price
     * @return CartTotalPrice
     */
    public function add(ItemSubtotal $price): self
    {
        return self::of($this->value + $price->value());
    }

    /**
     * @return CartTotalPrice
     */
    public function clear(): self
    {
        return self::of(0);
    }
}
