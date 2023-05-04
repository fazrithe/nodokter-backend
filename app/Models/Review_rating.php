<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review_rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'comments',
        'star_rating',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
