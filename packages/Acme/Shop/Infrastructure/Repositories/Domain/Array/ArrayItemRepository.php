<?php
namespace Acme\Shop\Infrastructure\Repositories\Domain\Eloquent;

use Acme\Shop\Domain\Models\Item\Item;
use Acme\Shop\Domain\Models\Item\ItemId;
use Acme\Shop\Domain\Models\Item\ItemPrice;
use Acme\Shop\Domain\Models\Item\ItemRepository;
use Acme\Shop\Domain\Models\Item\Stock;
use Illuminate\Support\Collection;

final class ArrayItemRepository implements ItemRepository
{
    /**
     * @param ItemId $id
     * @return Item
     */
    public function findById(ItemId $id): Item
    {
        return new Item(
            $id,
            'テスト商品',
            ItemPrice::of(0),
            Stock::of(0)
        );
    }

    /**
     * @return Collection
     */
    public function findAll(): Collection
    {
        return Collection::make([]);
    }
}