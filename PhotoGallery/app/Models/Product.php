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

    //order many-to-many relationship
    public function order()
    {
        return $this->hasMany(Order::class);
    }

}
