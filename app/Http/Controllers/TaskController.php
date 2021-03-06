<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    ) {
        $this->authorizeResource(Task::class);
    }

    public function show(Task $task): Factory|View|Application
    {
        return view('tasks.show', compact('task'));
    }

    public function index(Request $request): Factory|View|Application
    {
        $filter = $request->input('filter', []);
        $filter = array_filter($filter);
        $filter = array_merge(TaskService::FILTER_FIELDS, $filter);

        $tasks = $this->taskService->filterTasks($filter);
        $users = User::pluck('name', 'id');
        $statuses = TaskStatus::pluck('name', 'id');

        return view('tasks.index', compact('tasks', 'users', 'statuses', 'filter'));
    }

    public function create(): Factory|View|Application
    {
        $task = new Task();

        $users = User::pluck('name', 'id');
        $statuses = TaskStatus::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');

        return view('tasks.create', compact('task', 'users', 'statuses', 'labels'));
    }

    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $this->taskService->createTask($request);

        flash(__('messages.flash.task.success.create'))->success();

        return redirect()->route('tasks.index');
    }

    public function edit(Task $task): Factory|View|Application
    {
        $users = User::pluck('name', 'id');
        $statuses = TaskStatus::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');

        return view('tasks.edit', compact('task', 'users', 'statuses', 'labels'));
    }

    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $this->taskService->updateTask($request, $task);

        flash(__('messages.flash.task.success.update'))->success();

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        flash(__('messages.flash.task.success.delete'))->success();

        return redirect()->route('tasks.index');
    }
}
