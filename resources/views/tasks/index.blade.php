@extends('layouts.app')
@section('content')
    @if(session('task-success-created'))
        <div class="alert alert-success" role="alert">
            {{ session('task-success-created') }}
        </div>
    @elseif(session('task-success-removed'))
        <div class="alert alert-success" role="alert">
            {{ session('task-success-removed') }}
        </div>
    @endif

    <a class="btn btn-primary mb-3" href="{{ route('tasks.create') }}" role="button">Create</a>

    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Status</th>
            <th>Edit</th>
            <th>Remove</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
            <tr class="table-primary">
                <th>{{ $task->id }}</th>
                <th><a href="{{ route('tasks.show', $task->id) }}">{{ $task->title }}</a></th>
                <th class="{{ ($task->status->name === 'New')         ? 'text-primary':
                             (($task->status->name === 'In progress') ? 'text-warning' : 'text-success') }}">{{ $task->status->name }}</th>
                <th><a class="btn text-primary" href="{{ route('tasks.edit', $task->id) }}"><i
                            class="bi bi-pen"></i></a></th>
                <th>
                    <form data-form-type="destroy" action="{{ route('tasks.destroy', $task->id) }}" method="post">
                        @csrf @method('delete')
                        <button class="btn text-danger" type="submit"><i class="bi bi-trash"></i></button>
                    </form>
                </th>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $tasks->links() }}
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
        setTimeout(function () {
            const alerts = document.querySelectorAll("div[role='alert']");
            for (let divAlert of alerts) {
                divAlert.style.display = "none";
            }
        }, 3000);

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
