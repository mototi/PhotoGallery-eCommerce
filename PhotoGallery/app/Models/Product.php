<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'admin_id',
        'description',
        'price',
        'image',
        'category',
        'stock',
    ];

    //admin many-to-one
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    //cart many-to-many relationship with pivot quantity and price
    public function carts()
    {
        return $this->belongsToMany(Cart::class)
        ->withPivot('quantity', 'price');
    }

}
