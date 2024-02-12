<?php

namespace App\Repositories;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAll($user_id)
    {
        return Task::where('user_id', $user_id)->orderByDesc('id')->get();
    }

    public function getPaginate($user_id, $count)
    {
        return Task::where('user_id', $user_id)->orderByDesc('id')->paginate($count);
    }

    public function getById($user_id, $id): Task|null
    {
        return Task::where('user_id', $user_id)->find($id);
    }

    public function delete($user_id, $id): bool
    {
        return Task::where('user_id', $user_id)
                ->where('id', $id)
                ->delete();
    }

    public function create($user_id, array $task): Task|null
    {
        $task['user_id'] = $user_id;
        return Task::create($task);
    }

    public function update($user_id, $id, array $task): bool
    {
        return Task::where('user_id', $user_id)
                ->whereId($id)
                ->update($task);
    }
}
