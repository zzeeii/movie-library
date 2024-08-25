<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected $userService;

    /**
     * Constructor to initialize the UserService.
     *
     * @param \App\Services\UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // You can implement a method to list all users if needed
        try {
            $users = User::all();
            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while retrieving users.'], 500);
        }
    }

    /**
     * Store a newly created user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $validateData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|string|max:20',
            ]);

            // Create a new user using the validated data
            $user = $this->userService->createUser($validateData);

            return response()->json($user, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the user.'], 500);
        }
    }

    /**
     * Display the specified user.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        try {
            

            return response()->json($user ,200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'user not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while retrieving the user.'], 500);
        }
    }

    /**
     * Update the specified user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {
        try {
            echo $request->name;
            // Validate the incoming request data
            $validateData = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|max:255',
                'password' => 'sometimes|required|string|max:20',
            ]);

            // Update the user using the validated data
            $user = $this->userService->updateUser($user, $validateData);

            return response()->json($user, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'User not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the user.'], 500);
        }
    }

    /**
     * Remove the specified user from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        try {
            // Delete the specified user
            $this->userService->deleteUser($user);

            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'User not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the user.'], 500);
        }
    }
}
