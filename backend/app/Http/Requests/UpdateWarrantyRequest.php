<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWarrantyRequest extends FormRequest
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
            "warranty_id" => ['string', 'max:255'],
            "invoice_number" => ['string', 'max:255'],
            "product_name" => ['string', 'max:255'],
            "seller" => ['string', 'max:50'],
            "customer_name" => ['string', 'max:255'],
            "date_purchase" => ['max:255', 'date'],
            "warranty_end_date" => ['max:255', 'date','after:date_purchase'],
            'warranty_file' => ['sometimes','nullable', 'file', 'mimes:pdf,doc,docx,jpeg,png,jpg', 'max:1024'],
        ];
    }
}
