@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Add New “What’s New” Item</h2>
    <form action="{{ route('admin.new.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required placeholder="e.g. Ready To Wear">
        </div>

        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('admin.new.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
