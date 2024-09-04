<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Property;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    const PRODUCTS_NUMBER = 100;
    const PROPERTIES_MAX_NUMBER = 5;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory(self::PRODUCTS_NUMBER)->create()->each(function ($product) {
            $propertiesNumber = rand(1, self::PROPERTIES_MAX_NUMBER);
            Property::factory($propertiesNumber)
                ->create()
                ->each(function ($prop) use($product) {
                    $product->properties()->attach($prop->id, [
                        'value' => 'Property value ' . $product->id . '-' . $prop->id,
                    ]);
                });
        });
    }
}
