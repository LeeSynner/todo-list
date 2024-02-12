@extends('layouts.app')
@section('content')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}">Todo List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit task</li>
        </ol>
    </nav>

    @if(session('task-success-updated'))
        <div class="alert alert-success" role="alert">
            {{ session('task-success-updated') }}
        </div>
    @endif

    <form action="{{ route('tasks.update', $task->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $task->title }}"
                   aria-describedby="titleHelp">
            @error('title')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"
                      rows="3">{{ $task->description }}</textarea>
            @error('description')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="status_id" class="form-label">Status</label>
            <select class="form-select mb-3" aria-label="status" id="status_id" name="status_id">
                @foreach($statuses as $status)
                    <option
                        {{ ($task->status_id == $status->id) ? 'selected' : '' }} value="{{ $status->id }}">{{ $status->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
        setTimeout(function () {
            const alerts = document.querySelectorAll("div[role='alert']");
            for (let divAlert of alerts) {
                divAlert.style.display = "none";
            }
        }, 3000);
    });
</script>
