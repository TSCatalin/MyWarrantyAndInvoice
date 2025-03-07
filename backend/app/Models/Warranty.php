<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warranty extends Model
{
    /** @use HasFactory<\Database\Factories\WarrantyFactory> */
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = ['user_id', 'warranty_id', 'invoice_number', 'product_name', 'seller', 'customer_name', 'date_purchase', 'warranty_end_date', 'status', 'warranty_file'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
