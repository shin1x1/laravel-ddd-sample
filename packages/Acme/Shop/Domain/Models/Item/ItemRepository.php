<?php
namespace Acme\Shop\Domain\Models\Item;

use Acme\Shop\Domain\Exceptions\NotFoundException;
use Illuminate\Support\Collection;

interface ItemRepository
{
    /**
     * @param ItemId $id
     * @return Item
     * @throws NotFoundException
     */
    public function findById(ItemId $id): Item;

    /**
     * @return Collection
     */
    public function findAll(): Collection;
}
