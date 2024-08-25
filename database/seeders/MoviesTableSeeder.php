<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $movies=[
        [
            'title'=>'movie1' ,
            'director'=>'Ali',
            'genre'=>'action',
            'release_year'=>2010,
            'description'=>'movie1',
        ],
        [ 'title'=>'movie2' ,
        'director'=>'Ali',
        'genre'=>'comedy',
        'release_year'=>2015,
        'description'=>'movie2',
    ],
    [
        'title'=>'movie3' ,
        'director'=>'zein',
        'genre'=>'action',
        'release_year'=>2019,
        'description'=>'movie3',
    ],
    [ 'title'=>'movie4' ,
    'director'=>'zein',
    'genre'=>'comedy',
    'release_year'=>2011,
    'description'=>'movie4',
],
];
foreach ($movies as $movie) {
    Movie::create($movie);
}    

    }
}
