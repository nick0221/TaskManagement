<?php

namespace App\Http\Requests;

use App\Enums\PublishStatus;
use App\Enums\TaskStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TaskStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        // Convert the title to lowercase before validation
        $this->merge([
            'title' => strtolower($this->input('title')),
        ]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'min:3',
                'max:100',
                Rule::unique('tasks')->where(function ($query) {
                    // Get the authenticated user's ID
                    $userId = Auth::id();
                    // Add a condition to check uniqueness only within the user's task records
                    return $query->where('user_id', $userId);
                }),
            ],
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:4048',//4MB Max size
            'content' => 'required|min:3',
            'published' => Rule::in(PublishStatus::toSelectArray()),
            'status' => Rule::in(TaskStatus::toSelectArray())

        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'title.unique' => 'The title already exists, please choose a unique title',
            'title.min' => 'Minimum of 3 characters for title',
            'title.max' => 'Maximum of 100 characters only for the field title',
            'content.required' => 'Content is required',
            'image.image' => 'The file must be an image',
            'image.mimes' => 'Supported image formats are jpeg, png, jpg, and gif',
            'image.max' => 'Maximum image size allowed is 4MB',
            'published.in' => 'Invalid published status',
            'status.in' => 'Invalid task status',
        ];
    }
}
