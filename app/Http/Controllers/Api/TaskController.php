<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\TaskRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id = $request->user()->id;
        $tasks = $this->taskRepository->getAll($user_id);
        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            self::TITLE => 'required|max:255',
            self::DESCRIPTION => 'nullable|string',
            self::STATUS_ID => 'required|int'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $user_id = $request->user()->id;
        $task = $this->taskRepository->create($user_id, $data);

        if (is_null($task)) {
            return respose()->json([
                'status' => 'failed',
                'message' => 'Task was not created!',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Task was created successfully!',
            'data' => $task
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $user_id = $request->user()->id;
        $task = $this->taskRepository->getById($user_id, $id);

        if (is_null($task)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Task was not found!',
                'data' => $task
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Task was found!',
            'data' => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            self::TITLE => 'required|max:255',
            self::DESCRIPTION => 'nullable|string',
            self::STATUS_ID => 'required|int'
        ]);

        if ($validator->fails()) {
            return respose()->json([
                'status' => 'failed',
                'message' => $validator->errors()
            ], 422);
        }

        $user_id = $request->user()->id;
        $data = $validator->validated();

        $task = $this->taskRepository->getById($id);
        if (is_null($task)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Task not found!'
            ], 404);
        }

        if (!$this->taskRepository->update($user_id, $id, $data)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Task was not updated!'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Task was updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $user_id = $request->user()->id;
        $task = $this->taskRepository->getById($user_id, $id);

        $deleted = is_null($task);
        if (!$deleted) {
            $deleted = $this->taskRepository->delete($user_id, $id);
        }
        if ($deleted) {
            return response()->json([
                'status' => 'success',
                'message' => 'Task was deleted successfully!'
            ], 200);
        }

        return response()->json([
            'status' => 'failed',
            'message' => 'Task was not deleted!'
        ], 500);
    }
}
