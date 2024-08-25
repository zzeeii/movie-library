<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Services\RatingService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class RatingController extends Controller
{
    protected $ratingService;

    /**
     * Constructor to initialize the RatingService.
     *
     * @param \App\Services\RatingService $ratingService
     */
    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    /**
     * Display a listing of the resource.
     *
     *return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
     /*   // You can implement a method to list all ratings if needed
        try {
            $ratings = $this->ratingService->getAllRatings();
            return response()->json($ratings);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while retrieving ratings.'], 500);
        }*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $validateData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'movie_id' => 'required|exists:movies,id',
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'nullable|string|max:255',
            ]);

            // Create a new rating using the validated data
            $rating = $this->ratingService->createRating($validateData);

            return response()->json($rating, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the rating.'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Rating $rating
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Rating $rating)
    {
        try {
            // Return the specified rating
            return response()->json($rating);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Rating not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while retrieving the rating.'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * param \Illuminate\Http\Request $request
     * param \App\Models\Rating $rating
     * return \Illuminate\Http\JsonResponse
     */
   /* public function update(Request $request, Rating $rating)
    {
        try {
            // Validate the incoming request data
            $validateData = $request->validate([
                'user_id' => 'sometimes|required',
                'movie_id' => 'sometimes|required',
                'rating' => 'sometimes|required|integer|min:1|max:5',
                'review' => 'nullable|string|max:255',
            ]);

            // Update the rating using the validated data
            $rating = $this->ratingService->updateRating($rating, $validateData);

            return response()->json($rating, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Rating not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the rating.'], 500);
        }
    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Rating $rating
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Rating $rating)
    {
        try {
            // Delete the specified rating
            $this->ratingService->deleteRating($rating);

            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Rating not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the rating.'], 500);
        }
    }
}

