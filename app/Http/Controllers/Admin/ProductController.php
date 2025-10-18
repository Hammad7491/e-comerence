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
                    $paths[] = $this->saveToBoth($file);   // store to storage + public
                }
            }
        }

        // keep max 3
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

        // Remove selected existing images (from both locations)
        foreach ((array) $request->input('remove_images', []) as $relPath) {
            if (($idx = array_search($relPath, $images, true)) !== false) {
                $this->deleteFromBoth($relPath);
                unset($images[$idx]);
            }
        }
        $images = array_values($images);

        // Add newly uploaded images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file instanceof UploadedFile && $file->isValid()) {
                    $images[] = $this->saveToBoth($file);
                }
            }
        }

        // keep max 3
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
                $this->deleteFromBoth($rel);
            }
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Save uploaded file to BOTH:
     *  - storage/app/public/products (disk: public)
     *  - public/products (directly web-accessible for Live Server)
     * Return the DB path: 'products/filename.ext'
     */
    private function saveToBoth(UploadedFile $file): string
    {
        $ext = $file->getClientOriginalExtension() ?: 'bin';
        $filename = uniqid('', true) . '.' . strtolower($ext);
        $relative = 'products/' . $filename;

        // 1) Save to storage/app/public/products
        $file->storeAs('products', $filename, 'public');

        // 2) Copy to public/products
        $src = Storage::disk('public')->path($relative);
        $dstDir = public_path('products');
        if (!is_dir($dstDir)) {
            @mkdir($dstDir, 0755, true);
        }
        $dst = public_path($relative);
        @copy($src, $dst);

        // DB stores relative path without leading slash
        return $relative;
    }

    /**
     * Delete a relative path (e.g. 'products/abc.jpg') from BOTH locations.
     */
    private function deleteFromBoth(string $relativePath): void
    {
        $relativePath = ltrim($relativePath, '/');

        // storage/app/public/products/...
        Storage::disk('public')->delete($relativePath);

        // public/products/...
        $publicPath = public_path($relativePath);
        if (is_file($publicPath)) {
            @unlink($publicPath);
        }
    }
}
