<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
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
            "invoice_number" => ['string', 'max:255'],
            "products_name" => ['string', 'max:500'],
            "seller" => ['string', 'max:50'],
            "value" => ['string', 'max:50'],
            "currency" => ['string', 'max:10'],
            "customer_name" => ['string', 'max:255'],
            "date_purchase" => ['max:255', 'date' ,'before_or_equal:' . now()->toDateString()],
            'invoice_file' => ['sometimes', 'nullable', 'file', 'mimes:pdf,doc,docx,jpeg,png,jpg', 'max:1024'],
        ];
    }
}
