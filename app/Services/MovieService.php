<?php
namespace App\Services;

use App\Models\Movie;
class MovieService{


    public function createMove(array $data){
        return Movie::create($data);
    }
    public function updateMovie(Movie $movie,array $data)
    { 
        
        $movie->update($data);
        return $movie;
    }
    public function deleteMovie(Movie $movie)
    {
        return $movie->delete();
    }
    public function  filterMovie($genre,$director,$sort_by){
        $query=Movie::with('ratings.user');
        if ($genre) {
            $query->byGenre($genre)->get();

            if ($director) {
                $query->byDirector($director)->get();
            }
            if ($sort_by) {
                $query->orderBy('release_year',$sort_by);
            }
        }
        return $query;
    }

}