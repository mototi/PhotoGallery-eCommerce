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

    //customer many-to-many relationship
    public function customer()
    {
        return $this->belongsToMany(Customer::class)
            -> withPivot('quantity', 'price')
            ->useing(ProductCustomer::class);
    }

}
