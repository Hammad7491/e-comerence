<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WhatNew;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class NewController extends Controller
{
    public function index()
    {
        $items = WhatNew::latest()->get();
        return view('admin.new.index', compact('items'));
    }

    public function create()
    {
        // same Blade is used for edit when $item is passed
        return view('admin.new.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096', // 4MB
        ]);

        $path = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file instanceof UploadedFile && $file->isValid()) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('products'), $filename);      // <-- same as products
                $path = 'products/' . $filename;                      // save relative public path
            }
        }

        WhatNew::create([
            'title' => $request->title,
            'image' => $path,
        ]);

        return redirect()->route('admin.new.index')->with('success', 'New item added successfully!');
    }

    /** SHOW EDIT FORM (reuses create view) */
    public function edit($id)
    {
        $item = WhatNew::findOrFail($id);
        return view('admin.new.create', compact('item'));
    }

    /** HANDLE UPDATE */
    public function update(Request $request, $id)
    {
        $item = WhatNew::findOrFail($id);

        $request->validate([
            'title'        => 'required|string|max:255',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'remove_image' => 'nullable|in:0,1',
        ]);

        $data = ['title' => $request->title];

        // remove existing file if requested OR if a new one will replace it
        $shouldRemoveExisting = $request->boolean('remove_image') || $request->hasFile('image');
        if ($shouldRemoveExisting && $item->image) {
            $full = public_path($item->image);
            if (File::exists($full)) {
                File::delete($full);
            }
            $item->image = null;
        }

        // upload new image (same path pattern as products)
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file instanceof UploadedFile && $file->isValid()) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('products'), $filename);
                $data['image'] = 'products/' . $filename;
            }
        }

        $item->update($data);

        return redirect()->route('admin.new.index')->with('success', 'Item updated successfully!');
    }

    public function destroy($id)
    {
        $item = WhatNew::findOrFail($id);

        if ($item->image) {
            $full = public_path($item->image);
            if (File::exists($full)) {
                File::delete($full);
            }
        }

        $item->delete();

        return back()->with('success', 'Item deleted successfully!');
    }
}
