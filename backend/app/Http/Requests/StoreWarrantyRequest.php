<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWarrantyRequest extends FormRequest
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
            "warranty_id" => ['required', 'string', 'max:255'],
            "invoice_number" => ['required', 'string', 'max:255'],
            "product_name" => ['required', 'string', 'max:255'],
            "seller" => ['required', 'string', 'max:50'],
            "customer_name" => ['required', 'string', 'max:255'],
            "date_purchase" => ['required', 'max:255', 'date', 'before_or_equal:' . now()->toDateString()],
            "warranty_end_date" =>['required', 'max:255', 'date','after:date_purchase'],
            "warranty_file" => ['required', 'file', 'mimes:pdf,doc,docx,jpeg,png,jpg','max:1024'],
        ];
    }
}
