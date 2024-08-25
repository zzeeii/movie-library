<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Movie extends Model
{
    use HasFactory, Notifiable;
    protected $fillable=[
        'title',
        'director',
        'genre',
        'release_year',
        'description',
    ];
    protected $hidden = [
        'id',
        'updated_at'
    ];
    public function scopeByGenre($query,$genre){
        return $query->where('genre',$genre);
    }
    public function scopeByDirector($query,$director){
        return $query->where('director',$director);
    }
   /* public function scopeByGenre($query,$genre){
        return $query->where('genre',$genre);
    }*/
    public function descriptionWordCount(){
        return str_word_count($this->description);
    }
    public function ratings()
    {
        return $this->hasOne(Rating::class)->with('user:id,name');
    }
}
