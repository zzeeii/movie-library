<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable=[
        'rating',
        'review',
        'user_id',
        'movie_id',
    ];
    protected $hidden = [
        'id',
        'updated_at'
    ];
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name');
    }
}
