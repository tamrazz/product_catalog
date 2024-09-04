<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_property()
    {
        $property = Property::factory()->create([
            'name' => 'Size',
        ]);

        $this->assertDatabaseHas('properties', [
            'name' => 'Size',
        ]);
    }

    /** @test */
    public function it_can_attach_products_to_property()
    {
        $product = Product::factory()->create(['name' => 'Lamp']);
        $property = Property::factory()->create(['name' => 'Brand']);
        $property->products()->attach($product->id, ['value' => 'IKEA']);

        $this->assertDatabaseHas('product_property', [
            'product_id' => $product->id,
            'property_id' => $property->id,
            'value' => 'IKEA',
        ]);
    }
}
