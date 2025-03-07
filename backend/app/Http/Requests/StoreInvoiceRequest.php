<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            "invoice_number" => ['required', 'string', 'max:255'],
            "products_name" => ['required', 'string', 'max:500'],
            "seller" => ['required', 'string', 'max:50'],
            "value" => ['required', 'string', 'max:50'],
            "currency" => ['required', 'string', 'max:10'],
            "customer_name" => ['required', 'string', 'max:255'],
            "date_purchase" => ['required', 'max:255', 'date' ,'before_or_equal:' . now()->toDateString()],
            "invoice_file" => ['required', 'file', 'mimes:pdf,doc,docx,jpeg,png,jpg','max:1024'],
        ];
    }
}
