<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(12);
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();

        $paths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file instanceof UploadedFile && $file->isValid()) {
                    $paths[] = $file->store('products', 'public');
                }
            }
        }

        $data['images'] = array_slice($paths, 0, 3);
        $data['is_active'] = $request->boolean('is_active');

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('admin.product.create', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();

        $images = is_array($product->images) ? $product->images : [];

        foreach ((array) $request->input('remove_images', []) as $relPath) {
            if (($idx = array_search($relPath, $images, true)) !== false) {
                Storage::disk('public')->delete($relPath);
                unset($images[$idx]);
            }
        }
        $images = array_values($images);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file instanceof UploadedFile && $file->isValid()) {
                    $images[] = $file->store('products', 'public');
                }
            }
        }

        $data['images'] = array_slice($images, 0, 3);
        $data['is_active'] = $request->boolean('is_active');

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if (is_array($product->images)) {
            foreach ($product->images as $rel) {
                Storage::disk('public')->delete($rel);
            }
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
