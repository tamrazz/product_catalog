<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductFilterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_filter_products_by_property_value()
    {
        $product1 = Product::factory()->create(['name' => 'Lamp']);
        $property1 = Property::factory()->create(['name' => 'Color']);
        $product1->properties()->attach($property1->id, ['value' => 'Red']);

        $product2 = Product::factory()->create(['name' => 'Table']);
        $property2 = Property::factory()->create(['name' => 'Color']);
        $product2->properties()->attach($property2->id, ['value' => 'Blue']);

        $response = $this->getJson('/api/v1/products?properties[Color][]=Red');
        $response->assertStatus(200)
                 ->assertJsonCount(1, 'data')
                 ->assertJsonFragment(['name' => 'Lamp']);
    }

    /** @test */
    public function it_returns_no_products_if_no_match_properties()
    {
        $product = Product::factory()->create(['name' => 'Chair']);
        $property = Property::factory()->create(['name' => 'Color']);
        $product->properties()->attach($property->id, ['value' => 'Red']);

        $response = $this->getJson('/api/v1/products?properties[Color][]=Blue');
        $response->assertStatus(200)
                 ->assertJsonCount(0, 'data');
    }
}
