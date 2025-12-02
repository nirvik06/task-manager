<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        // user must be logged in for web forms (middleware handles it) but keep true
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'due_date' => ['required','date'],
            'status' => ['in:pending,in_progress,done'],
        ];
    }
}