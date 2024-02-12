@extends('layouts.app')
@section('content')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}">Todo List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Task</li>
        </ol>
    </nav>
    <div class="card text-center">
        <div class="card-header">
            Task #{{ $task->id }}
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $task->title }}</h5>
            <p class="card-text">{{ $task->description }}</p>
            <p>Status: {{ $task->status->name }}</p>
        </div>
        <div class="card-footer">
            <form class="col-md-12" data-form-type="destroy" action="{{ route('tasks.destroy', $task->id) }}" method="post">
                @csrf @method('delete')
                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary">Edit</a>
                <button class="btn btn-primary" type="submit">Delete</button>
            </form>
        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const forms = document.querySelectorAll('form[data-form-type="destroy"]');
        for (const form of forms) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                if (confirm('Are you sure you want to delete the task?')) {
                    this.submit();
                }
            });
        }
    });
</script>
