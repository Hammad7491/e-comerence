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
        return view('admin.new.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
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
