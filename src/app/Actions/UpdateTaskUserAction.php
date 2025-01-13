<?php

namespace App\Actions;

use App\Models\Task;

class UpdateTaskUserAction
{
    public function execute(Task $task, int $userId): void
    {
        $task->assigned_user_id = $userId;
        $task->save();
    }
}
