<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EditRaceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'competition_id' => ['required', 'integer', 'exists:competitions,id'],
            'title' => ['required', 'string', 'max:255'],
            'venue' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'season_year' => ['required', 'integer', 'min:2000', 'max:2100'],
            'classes' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image'],
            'tickets_url' => ['nullable', 'url', 'max:255'],
            'details_url' => ['nullable', 'url', 'max:255'],
            'status' => ['required', 'string', 'in:scheduled,cancelled,completed'],
            'is_featured' => ['nullable', 'boolean'],
        ];
    }
}

