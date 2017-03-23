<?php
namespace Acme\Shop\Domain\Models\Item;

use Acme\Shop\Domain\Models\PositiveNumber;

final class ItemCount extends PositiveNumber
{
    /**
     * @param ItemCount $count
     * @return ItemCount
     */
    public function add(self $count): self
    {
        return self::of($this->value + $count->value);
    }
}