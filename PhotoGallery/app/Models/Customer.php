<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'is_customer',
        'user_id',
        'phone',
        'address',
    ];

    //User one-to-one relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //orders one-to-many relationship
    public function order()
    {
        return $this->hasMany(Order::class);
    }

    //cart one to many  relationship
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

}
