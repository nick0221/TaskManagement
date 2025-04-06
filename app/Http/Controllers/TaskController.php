<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Requests\TaskStoreRequest;
use App\Models\Task;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class TaskController extends Controller
{

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

    public function create(): View
    {
        return view('tasks.create');
    }

    public function show(Task $task)
    {

        return view('tasks.show', compact('task'));
    }

    public function edit(Request $request)
    {
        $task = Task::find($request->task);
        $this->authorize('update', $task);

        if ($task) {
            return view('tasks.edit', compact('task'));
        } else {
            Log::error('An error occurred, while retrieving task details');

            /** @phpstan-ignore-next-line */
            flash()->success('Failed to edit!');
            return back();
        }
    }


}
