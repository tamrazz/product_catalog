<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    const PRODUCTS_PER_PAGE = 40;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with('properties');
        if ($request->has('properties')) {
            foreach ($request->get('properties') as $property => $values) {
                $products->whereHas('properties', function($q) use ($property, $values) {
                    $q->where('name', $property)
                      ->whereIn('value', $values);
                });
            }
        }

        return ProductResource::collection($products->paginate(static::PRODUCTS_PER_PAGE));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
