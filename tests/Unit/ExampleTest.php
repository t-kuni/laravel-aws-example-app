<?php

namespace Tests\Unit;

use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function canAccessDatabase()
    {
        Carbon::setTestNow(Carbon::create(2000, 1, 1, 0, 0, 0));

        $item = new Item();
        $item->name = "dummy item";
        $item->image = "dummy image";
        $item->save();

        $this->assertDatabaseHas('items', [
            'name' => 'dummy item'
        ]);
    }
}
