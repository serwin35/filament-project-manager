<?php

namespace App\Actions;

use App\Models\Task;

class UpdateTaskStateAction
{
    public function execute(Task $task, string $state): void
    {
        $task->state = $state;
        $task->save();
    }
}
