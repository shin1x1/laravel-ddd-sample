<?php
namespace Acme\Shop\Infrastructure\Eloquents;

use Acme\Shop\Domain\Models\Domainable;
use Acme\Shop\Domain\Models\Item\Item;
use Acme\Shop\Domain\Models\Item\ItemId;
use Acme\Shop\Domain\Models\Item\ItemPrice;
use Acme\Shop\Domain\Models\Item\Stock;

/**
 * @property int $id
 * @property string $name
 * @property int $price
 * @property int $stock
 */
class EloquentItem extends AppEloquent implements Domainable
{
    protected $table = 'items';

    /**
     * @return Item
     */
    public function toDomain(): Item
    {
        return new Item(
            ItemId::of($this->id),
            $this->name,
            ItemPrice::of($this->price),
            Stock::of($this->stock)
        );
    }
}
