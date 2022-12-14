<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectWithPagesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'settings' => 'required|array',
            'settings.update_range' => 'required|integer|in:24,168,720',
            'settings.telegram_fail_notify' => 'required|boolean',
            'settings.telegram_success_notify' => 'required|boolean',
            'pages' => 'required|array',
            'pages.*.url' => 'required|url',
            'pages.*.filters' => 'required|array',
            'pages.*.filters.type' => 'required|in:text,html',
        ];
    }
}
