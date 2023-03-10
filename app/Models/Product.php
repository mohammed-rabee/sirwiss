<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'status',
        'type',
        'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function product_history() {
        return $this->hasMany(ProductHistory::class);
    }
}
