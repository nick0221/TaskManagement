<?php

namespace App\Http\Controllers;

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
        return view('tasks.index');

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


}
