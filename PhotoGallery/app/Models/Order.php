<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'customer_id',
        'number',
        'status',
        'date',
    ];

    //customer many-to-one relationship
    public function order()
    {
        return $this->belongsTo(Customer::class);
    }

    //product many-to-many relationship
    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
