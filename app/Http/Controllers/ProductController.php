<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductDetail;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("pages.product.index", [
            "products" => Product::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.product.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validate([
            "name" => "required",
            'price' => 'required',
            'picture' => 'required'
        ]);

        $request->validate([
            'stok' => 'required'
        ]);

        $file = $request->file('picture');

        $filename = $file->store('product'); // Store the file
        $validated['picture'] = $filename;

        Product::create($validated);

        $product = Product::latest('id')->first();

        for ($i = 1; $i <= intval($request->get('stok')); $i++) {
            ProductDetail::create([
                'product_id' => $product->id,
                'product_code' => strtoupper(Str::random(10))
            ]);
        }

        return redirect()->route('products.index')->with('success', 'tambah produk berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->back();
    }
}
