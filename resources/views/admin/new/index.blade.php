@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>“What’s New” Items</h2>

    <a href="{{ route('admin.new.create') }}" class="btn btn-success mb-3">Add New</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Title</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @forelse($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>
                    @if($item->image)
                        <img src="{{ asset('storage/'.$item->image) }}" width="80" height="80" style="object-fit:cover;border-radius:8px;">
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>
                <td>{{ $item->title }}</td>
                <td>
                    <form action="{{ route('admin.new.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this item?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center text-muted">No items found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
