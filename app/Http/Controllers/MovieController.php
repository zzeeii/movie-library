<?php
namespace App\Http\Controllers;

use App\Services\MovieService;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class MovieController extends Controller
{
    protected $movieService;

    /**
     * Constructor to initialize the MovieService.
     *
     * @param \App\Services\MovieService $movieService
     */
    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    /**
     * Display a listing of movies with optional filtering and pagination.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $genre = $request->genre;
            $director = $request->director;
            $sort_by = $request->sort_by;

            // Get filtered and sorted movies from MovieService
            $query = $this->movieService->filterMovie($genre, $director, $sort_by);

            // Paginate the result and remove the links from the response
            $movies = $query->paginate($request->input('per_page', 10));
            $moviesArray = $movies->toArray();
            unset($moviesArray['links']);
            return response()->json($moviesArray,200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while retrieving movies.'], 500);
        }
    }

    /**
     * Store a newly created movie in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validateData = $request->validate([
                'title' => 'required|string|max:255',
                'director' => 'required|string|max:255',
                'genre' => 'required|string|max:255',
                'release_year' => 'required|integer',
                'description' => 'required|string',
            ]);

            // Create a new movie using the validated data
            $movie = $this->movieService->createMove($validateData);

            return response()->json($movie, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the movie.'], 500);
        }
    }

    /**
     * Display the specified movie along with the word count of the description.
     *
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Movie $movie)
    {
        try {
            // Get the word count of the movie's description
            $word_count = $movie->descriptionWordCount();
            $movie->with('ratings.user');
            return response()->json(
                [
                    'movie' => $movie,
                    'word_count' => $word_count,
                ],
                200
            );
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Movie not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while retrieving the movie.'], 500);
        }
    }

    /**
     * Update the specified movie in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Movie $movie)
    {
        try {
            // Validate the request data, using 'sometimes' to allow partial updates
            $validateData = $request->validate([
                'title' => 'sometimes|required|string|unique:movies|max:255',
                'director' => 'sometimes|required|string|max:255',
                'genre' => 'sometimes|required|string|max:255',
                'release_year' => 'sometimes|required|integer',
                'description' => 'sometimes|required|string',
            ]);

            // Update the movie with the validated data
            $movie = $this->movieService->updateMovie($movie, $validateData);

            return response()->json($movie, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Movie not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the movie.'], 500);
        }
    }

    /**
     * Remove the specified movie from storage.
     *
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Movie $movie)
    {
        try {
            // Delete the specified movie
            $this->movieService->deleteMovie($movie);

            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Movie not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the movie.'], 500);
        }
    }
}
