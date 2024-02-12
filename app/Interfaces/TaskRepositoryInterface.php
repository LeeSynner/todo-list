<?php

namespace App\Interfaces;

use App\Models\Task;
use mysql_xdevapi\Collection;

interface TaskRepositoryInterface
{
    public function getAll($user_id);
    public function getPaginate($user_id, $count);
    public function getById($user_id, $id): Task|null;
    public function delete($user_id, $id): bool;
    public function create($user_id, array $task): Task|null;
    public function update($user_id, $id, array $task): bool;
}
