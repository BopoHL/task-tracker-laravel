<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'assigner_id' => 'nullable|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'task_name' => 'required|string|max:100',
            'task_description' => 'nullable|string|max:400',
            'status' => 'nullable|in:not_started,in_progress,done,pause',
            'priority' => 'nullable|in:low,medium,high',
            'deadline' => 'nullable|date',
        ];
    }
}
