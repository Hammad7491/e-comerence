<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WhatNew;
use Illuminate\Support\Facades\Storage;

class NewController extends Controller
{
    public function index()
    {
        $items = WhatNew::latest()->get();
        return view('admin.new.index', compact('items'));
    }

    public function create()
    {
        // create view (same Blade as edit, but without $item)
        return view('admin.new.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            // match UI text: 4MB
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('whatnew', 'public');
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

        // If user clicked "Remove" on existing image OR a new image is uploaded, delete old file first
        $shouldRemoveExisting = $request->boolean('remove_image') || $request->hasFile('image');
        if ($shouldRemoveExisting && $item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
            $item->image = null;
        }

        // Save new image if provided
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('whatnew', 'public');
        }

        $item->update($data);

        return redirect()->route('admin.new.index')->with('success', 'Item updated successfully!');
    }

    public function destroy($id)
    {
        $item = WhatNew::findOrFail($id);

        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return back()->with('success', 'Item deleted successfully!');
    }
}
