<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'cusomer_id',
        'total_price',
    ];

    // customer one to one relationship
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // product many to many relationship with pivot quanity and price
    public function product()
    {
        return $this->belongsToMany(Product::class)
        ->withPivot('quantity', 'price');
    }
}
