<x-filament::page>
    <div class="text-2xl font-bold mb-4">
        {{ __('Kanban Board') }}
    </div>

    <div class="flex gap-4">
        @foreach(\App\Enums\TaskStateEnum::listState() as $state)
            <div
                class="bg-gray-100 p-4 rounded grow"
                ondrop="drop(event, '{{ $state->value }}')"
                ondragover="allowDrop(event)"
            >
                <h3 class="text-lg font-semibold mb-2">{{ $state->label() }}</h3>
                @forelse($this->tasks[$state->value] as $task)
                    <div
                        draggable="true"
                        ondragstart="drag(event, '{{ $task->id }}')"
                        class="bg-white p-2 my-2 rounded shadow"
                    >
                        <div class="font-bold">
                            <a href="{{ route('filament.admin.resources.tasks.view', $task) }}">{{ $task->name }}</a>
                        </div>
                        <div class="text-sm mt-1">
                            {{ __('Assigned to') }}:
                            {{ $task->assignedUser ? $task->assignedUser->name : __('Empty') }}
                        </div>
                        <select
                            class="mt-2 border rounded"
                            wire:change="assignUser({{ $task->id }}, $event.target.value)"
                        >
                            <option value="">-- {{ __('Select') }} --</option>
                            @foreach(\App\Models\User::all() as $user)
                                <option
                                    value="{{ $user->id }}"
                                    @if($task->assigned_user_id == $user->id) selected @endif
                                >
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @empty
                    <div class="text-gray-500">{{ __('No tasks') }}</div>
                @endforelse
            </div>
        @endforeach

    <script>
        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev, taskId) {
            ev.dataTransfer.setData("task_id", taskId);
        }

        function drop(ev, newStatus) {
            ev.preventDefault();
            const taskId = ev.dataTransfer.getData("task_id");
            @this.call('updateTaskStatus', taskId, newStatus);
        }
    </script>
</x-filament::page>
