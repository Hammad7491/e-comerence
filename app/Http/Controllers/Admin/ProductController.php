<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

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

        // Upload images to public/products
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file instanceof UploadedFile && $file->isValid()) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('products'), $filename);
                    $images[] = 'products/' . $filename;
                }
            }
        }

        $data['images'] = array_slice($images, 0, 3);
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

        // Remove selected images
        foreach ((array) $request->input('remove_images', []) as $path) {
            if (($key = array_search($path, $images)) !== false) {
                $fullPath = public_path($path);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
                unset($images[$key]);
            }
        }
        $images = array_values($images);

        // Add new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file instanceof UploadedFile && $file->isValid()) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('products'), $filename);
                    $images[] = 'products/' . $filename;
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
            foreach ($product->images as $path) {
                $fullPath = public_path($path);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}