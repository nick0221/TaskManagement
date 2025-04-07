<?php

namespace App\Http\Controllers;

use App\Enums\PublishStatus;
use App\Enums\TaskStatus;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Task;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class TaskController extends Controller
{

    /**
     * @param  Request  $request
     * @return View
     */
    public function index(Request $request): View
    {
        $user = (int) auth()->id();

        // Ensure $perPage is an integer or defaults to 5
        $perPage = (int) $request->query('per_page') ? (int) $request->query('per_page') : 5;

        $statusOptions = TaskStatus::toSelectArray();
        $sortColumn = (string) $request->filled('sort') ? (string) $request->query('sort') : 'created_at';
        $sortOrder = (string) $request->filled('order') ? (string) $request->query('order') : 'desc';

        $searchQuery = $request->query('search');

        // Call the filterTasks function from Task model
        $tasksQuery = Task::filterTasks($user, $request);
        $tasks = $tasksQuery->orderBy($sortColumn, $sortOrder)->paginate($perPage);

        return view('tasks.index', compact('tasks', 'statusOptions', 'sortColumn', 'sortOrder', 'searchQuery'))
            ->with('sort', $sortColumn)
            ->with('order', $sortOrder)
            ->with('status', $request->input('status', ''));


    }

    /**
     * @param  TaskStoreRequest  $request
     * @return RedirectResponse
     */
    public function store(TaskStoreRequest $request): RedirectResponse
    {

        try {
            $validatedData = $request->validated();
            $validatedData['user_id'] = auth()->user()->id;

            if ($request->hasFile('image')) {
                $image = $request->file('image');

                // Generate a unique image name
                $imageName = sprintf("%s.%s", uniqid(), $image->getClientOriginalExtension());

                // Store the image in the 'task-images' directory
                $image->storeAs('task-images', $imageName, 'public');

                // Add the image path to the validated data
                $validatedData['image'] = $imageName;
            }

            Task::create($validatedData);
            flash()->success('Product created successfully!');

        } catch (Exception $e) {
            // Log the error
            Log::error('An error occurred: '.$e->getMessage());
            flash()->error('Failed to create task!');
        }

        return redirect()->route('tasks.index');


    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('tasks.create');
    }

    /**
     * @param  Task  $task
     * @return View
     */
    public function show(Task $task): View
    {
        Gate::authorize('view', $task);
        return view('tasks.show', compact('task'));
    }


    /**
     * @param  Request  $request
     * @return Factory|View|Application|RedirectResponse|object
     */
    public function edit(Request $request)
    {
        $task = Task::find($request->task);
        Gate::authorize('update', $task);

        if ($task) {
            return view('tasks.edit', compact('task'));
        } else {
            Log::error('An error occurred, while retrieving task details');

            /** @phpstan-ignore-next-line */
            flash()->success('Failed to edit!');
            return back();
        }
    }

    /**
     * @param  TaskUpdateRequest  $request
     * @param  Task  $task
     * @return RedirectResponse
     */
    public function update(TaskUpdateRequest $request, Task $task): RedirectResponse
    {
        Gate::authorize('update', $task);
        $validated = $request->validated();

        // Store the image
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $imageName = uniqid().'.'.$image->getClientOriginalExtension();
            $image->storeAs('task-images', $imageName, 'public'); // Store the image in the 'task-images' directory
            $validated['image'] = $imageName;
        }

        $validated['published'] = $request->published ?? 0;
        $task->update($validated);


        /** @phpstan-ignore-next-line */
        flash()->success('Data has been successfully updated!');
        return back();
    }


    /**
     * @param $id
     * @param $progress
     * @return RedirectResponse
     */
    public function upStatus($id, $progress): RedirectResponse
    {
        $task = Task::find($id);

        if ($task === null) {
            return back()->withErrors('Task not found.');
        }

        $checkStatus = TaskStatus::hasValue($progress);
        if ($checkStatus) {
            /** @var string $progress */
            $task->status = $progress;
            $task->save();

            /** @phpstan-ignore-next-line */
            flash()->success("Task <b>{$task->limitedTitle}</b> has been set as <b>{$progress}</b>.");


        } else {
            $task->published = PublishStatus::fromValue(PublishStatus::PUBLISHED)->toValueBool(true);
            $task->save();

            /** @phpstan-ignore-next-line */
            flash()->success("Task <b>{$task->limitedTitle}</b> has been <b>published</b>.");

        }

        return back();
    }


    /**
     * @param  Task  $task
     * @return RedirectResponse
     */
    public function destroy(Task $task): RedirectResponse
    {
        // Delete the task (soft delete)
        $task->delete();
        $title = Str::words($task->title, 3);

        /** @phpstan-ignore-next-line */
        flash()->success("Task {$title} has been moved to trash.");
        return back();
    }


}
