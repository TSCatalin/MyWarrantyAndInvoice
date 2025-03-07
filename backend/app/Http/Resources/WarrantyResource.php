<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarrantyResource extends JsonResource
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
            'warranty_id' => $this->warranty_id,
            'invoice_number' => $this->invoice_number,
            'product_name' => $this->product_name,
            'seller' => $this->seller,
            'customer_name' => $this->customer_name,
            'date_purchase' => (new Carbon($this->date_purchase))->format('Y-m-d'),
            'warranty_end_date' => (new Carbon($this->warranty_end_date))->format('Y-m-d'),
            'status' => $this->status,
            'warranty_file' => base64_encode($this->warranty_file),
            'created_at' => (new Carbon($this->created_at))->format('Y-m-d'),
        ];
    }
}
