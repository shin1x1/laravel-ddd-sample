<?php
namespace Acme\Shop\Domain\Models\Cart\Test;

use Acme\Shop\Domain\Models\Item\Item;
use Acme\Shop\Domain\Models\Item\ItemId;
use Acme\Shop\Domain\Models\Item\ItemPrice;
use Acme\Shop\Domain\Models\Item\Stock;

trait FakeItem
{
    private function item(array $options = []): Item
    {
        $id = ItemId::of($options['id'] ?? 1);
        $name = $options['name'] ?? '商品1';
        $price = ItemPrice::of($options['price'] ?? 100);
        $stock = Stock::of($options['stock'] ?? 10);

        return new Item($id, $name, $price, $stock);
    }
}
