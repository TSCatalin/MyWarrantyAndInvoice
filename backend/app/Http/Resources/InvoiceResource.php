<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'invoice_number' => $this->invoice_number,
            'products_name' => $this->products_name,
            'seller' => $this->seller,
            'value' => $this->value,
            'currency' => $this->currency,
            'customer_name' => $this->customer_name,
            'date_purchase' => (new Carbon($this->date_purchase))->format('Y-m-d'),
            'invoice_file' => base64_encode($this->invoice_file),
            'created_at' => (new Carbon($this->created_at))->format('Y-m-d'),
        ];
    }
}
