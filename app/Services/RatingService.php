<?php
namespace App\Services;

use App\Models\Rating;
class RatingService{


    public function createRating(array $data){
        return Rating::create($data);
    }
    public function updateRating(Rating $rating,array $data)
    { 
        
        $rating->update($data);
        return $rating;
    }
    public function deleteRating(Rating $rating)
    {
        return $rating->delete();
    }


}