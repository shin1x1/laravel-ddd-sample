<?php
namespace Acme\Shop\Domain\Models\Item;

use Acme\Shop\Domain\Models\PositiveNumber;

final class ItemPrice extends PositiveNumber
{
    /**
     * @param ItemCount $count
     * @return ItemSubtotal
     */
    public function calcSubtotal(ItemCount $count): ItemSubtotal
    {
        return ItemSubtotal::of($this->value * $count->value());
    }
}