<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;
    protected $table = 'product';

    protected $fillable = [        
        'id',
        'user_id',
        'name',
        'price',
        'model',
        'ProductDescription',
        'ProductImg',
        'is_active',
        'created_at',
        'updated_at',
    ];
}
