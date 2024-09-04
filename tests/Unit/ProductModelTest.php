<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_product()
    {
        $product = Product::factory()->create([
            'name' => 'Test Product',
            'price' => 99.99,
            'quantity' => 10,
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 99.99,
            'quantity' => 10,
        ]);
    }

    /** @test */
    public function it_can_attach_properties_to_product()
    {
        $product = Product::factory()->create();
        $property = Property::factory()->create(['name' => 'Color']);
        $product->properties()->attach($property->id, ['value' => 'Red']);

        $this->assertDatabaseHas('product_property', [
            'product_id' => $product->id,
            'property_id' => $property->id,
            'value' => 'Red',
        ]);
    }
}
