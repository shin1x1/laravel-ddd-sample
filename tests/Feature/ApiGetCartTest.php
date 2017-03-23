<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiGetCartTest extends TestCase
{
    /**
     * @test
     */
    public function get_()
    {
        $response = $this->get('/api/cart');

        $response->assertStatus(404);
    }
}
