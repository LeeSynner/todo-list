<?php

namespace App\Http\Controllers;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    private const TITLE = 'title';
    private const DESCRIPTION = 'description';
    private const STATUS_ID = 'status_id';
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index(Request $request)
    {
        $user_id = $request->user()->id;
        $tasks = $this->taskRepository->getPaginate($user_id,15);
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $statuses = Status::all();
        return view('tasks.create', compact('statuses'));
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            self::TITLE => 'required|max:255',
            self::DESCRIPTION => 'nullable|string',
            self::STATUS_ID => 'required|int'
        ]);

        $user_id = $request->user()->id;
        $this->taskRepository->create($user_id, $data);

        return redirect()
            ->route('tasks.index')
            ->with('task-success-created', 'Task was created successfully!');
    }

    public function show(Request $request, $id)
    {
        $user_id = $request->user()->id;
        $task = $this->taskRepository->getById($user_id, $id);
        return view('tasks.show', compact('task'));
    }

    public function edit(Request $request, $id)
    {
        $user_id = $request->user()->id;
        $statuses = Status::all();
        $task = $this->taskRepository->getById($user_id, $id);

        return view('tasks.edit', compact('task', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $data = request()->validate([
            self::TITLE => 'required|max:255',
            self::DESCRIPTION => 'nullable|string',
            self::STATUS_ID => 'required|int'
        ]);

        $user_id = $request->user()->id;
        $this->taskRepository->update($user_id, $id, $data);

        return redirect()->route('tasks.edit', $id)
            ->with('task-success-updated', 'Task was updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $user_id = $request->user()->id;
        $this->taskRepository->delete($user_id, $id);

        return redirect()
            ->route('tasks.index')
            ->with('task-success-removed', 'Task was removed successfully!');
    }
}
