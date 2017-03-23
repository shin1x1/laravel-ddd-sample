<?php

use Acme\Shop\Infrastructure\Eloquents\EloquentItem;
use Illuminate\Database\Connection;
use Illuminate\Database\Seeder;

class SampleSeeder extends Seeder
{
    /** @var Connection */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->connection->transaction(function () {
            $this->connection->table('items')->truncate();
            $this->createItems();
        });
    }

    private function createItems()
    {
        (new EloquentItem([
            'id' => 1,
            'name' => 'Laravelリファレンス',
            'price' => 4200,
            'stock' => 10,
        ]))->save();

        (new EloquentItem([
            'id' => 2,
            'name' => 'Laravelエキスパート養成読本',
            'price' => 2138,
            'stock' => 10,
        ]))->save();

        (new EloquentItem([
            'id' => 3,
            'name' => 'Laravel 5.1 Beauty: Creating Beautiful Web Apps in Laravel 5.1',
            'price' => 1250,
            'stock' => 10,
        ]))->save();
    }
}
