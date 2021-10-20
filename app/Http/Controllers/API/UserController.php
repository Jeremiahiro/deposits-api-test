<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Fetch all users
     * return @json
    */
    public function index()
    {
        $users = User::latest()->get();
        return response()->json(UserResource::collection($users));
    }

    /**
     * Fetch current user
     * return @json
    */
    public function user()
    {
        return response()->json(['users' => new UserResource(auth()->user())]);
    }

    /**
     * Fetch single user
     * return @json
    */
    public function show(User $id)
    {
        return response()->json(['user' => new UserResource($id)]);
    }

    /**
     * Fetch all users who logged in today
     * return @json
    */
    public function today()
    {
        return response()->json(UserResource::collection(User::whereDate('last_login', Carbon::today())->get()));
    }

    /**
     * Fetch all users based on date of registration
     * return @json
    */
    public function date_of_registration(Request $request)
    {
        if(!$request['date']) {
            $user = User::groupBy('created_at')->get();
        } else {
            $date = Carbon::createFromFormat('d/m/Y', $request['date']);
            $user = User::where('created_at', $date)->get();
        }
        return response()
                ->json(UserResource::collection($user));
    }

}
