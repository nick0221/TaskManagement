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
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:4048',
            'content' => 'required|min:3',
            'published' => Rule::in(PublishStatus::toSelectArray()),
            'status' => Rule::in(TaskStatus::toSelectArray())

        ];
    }
}
