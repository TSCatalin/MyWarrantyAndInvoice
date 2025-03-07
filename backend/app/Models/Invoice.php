<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceFactory> */
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = ['user_id','invoice_number', 'products_name', 'seller', 'value', 'currency', 'customer_name', 'date_purchase', 'invoice_file'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

}
