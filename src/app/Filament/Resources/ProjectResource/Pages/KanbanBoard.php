<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Actions\UpdateTaskStateAction;
use App\Actions\UpdateTaskUserAction;
use App\Enums\TaskStateEnum;
use App\Filament\Resources\ProjectResource;
use App\Models\Project;
use App\Models\Task;
use Filament\Resources\Pages\Page;

class KanbanBoard extends Page
{
    protected static string $resource = ProjectResource::class;

    protected static string $view = 'filament.resources.project-resource.pages.kanban-board';

    protected static ?string $navigationIcon = 'heroicon-o-view-columns';

    private Project $project;

    public $tasks;

    public function mount(Project $project): void
    {
        $this->project = $project;
        $this->loadTasks();
    }

    private function loadTasks(): void
    {
        $this->tasks = collect([]);

        collect(TaskStateEnum::listState())->map(function ($state) {
            $this->tasks->put($state->value, Task::where([['project_id', $this->project->id], ['state', $state->value]])->with('assignedUser')->get());
        });
    }

    // Actions

    public function updateTaskStatus(Task $task, $newState, UpdateTaskStateAction $updateTaskStateAction): void
    {
        $updateTaskStateAction->execute($task, $newState);

        $this->loadTasks();
    }

    public function assignUser(Task $task, $userId, UpdateTaskUserAction $updateTaskUserAction): void
    {
        $updateTaskUserAction->execute($task, $userId);

        $this->loadTasks();
    }
}
