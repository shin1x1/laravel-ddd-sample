<?php
namespace Acme\Shop\Domain\Models\Item;

use Acme\Shop\Domain\Models\PositiveNumber;

final class Stock extends PositiveNumber
{
    /**
     * @param ItemCount $count
     * @return bool
     */
    public function isSufficient(ItemCount $count): bool
    {
        return $this->value >= $count->value();
    }
}