<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActionHistoryRequest extends FormRequest
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
            "type_action" => ['required', 'string'],
            "info_action" => ['required', 'string'],
            "date_action" => [
                'required',
                'max:255',
                'date',
                'date_format:Y-m-d H:i:s',
                'before_or_equal:' . now()->toDateTimeString(),
            ],
        ];
    }
}
