@extends('layouts.app')
@section('content')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}">Todo List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create task</li>
        </ol>
    </nav>
    <form action="{{ route('tasks.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}"
                   aria-describedby="titleHelp">
            @error('title')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"
                      rows="3">{{ old('description') }}</textarea>
            @error('description')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="status_id" class="form-label">Status</label>
            <select class="form-select mb-3" aria-label="status" id="status_id" name="status_id">
                @foreach($statuses as $status)
                    <option
                        {{ (old('status_id') === $status->id) ? 'selected' : '' }} value="{{ $status->id }}">{{ $status->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
