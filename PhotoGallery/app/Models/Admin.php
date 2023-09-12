<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'is_admin',
        'user_id',
        'phone'
    ];

    //User one-to-one relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //products one-to-many relationship
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
