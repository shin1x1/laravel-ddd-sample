<?php
namespace Acme\Shop\Infrastructure\Repositories\Domain\Eloquent;

use Acme\Shop\Domain\Exceptions\NotFoundException;
use Acme\Shop\Domain\Models\Domainable;
use Acme\Shop\Domain\Models\Item\Item;
use Acme\Shop\Domain\Models\Item\ItemId;
use Acme\Shop\Domain\Models\Item\ItemRepository;
use Acme\Shop\Infrastructure\Eloquents\EloquentItem;
use Illuminate\Support\Collection;

final class EloquentItemRepository implements ItemRepository
{
    /** @var  EloquentItem */
    private $eloquent;

    /**
     * @param EloquentItem $eloquent
     */
    public function __construct(EloquentItem $eloquent)
    {
        $this->eloquent = $eloquent;
    }

    /**
     * @param ItemId $id
     * @return Item
     * @throws NotFoundException
     */
    public function findById(ItemId $id): Item
    {
        /** @var Domainable $item */
        /** @noinspection PhpUndefinedMethodInspection */
        $item = $this->eloquent->find($id->value());
        if (empty($item)) {
            throw new NotFoundException();
        }

        return $item->toDomain();
    }

    /**
     * @return Collection
     */
    public function findAll(): Collection
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->eloquent->orderBy('id')->get()->map(function (Domainable $eloquent) {
            return $eloquent->toDomain();

        });
    }
}