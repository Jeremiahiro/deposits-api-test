<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Password::min(8)->letters()->uncompromised()]
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);       
        };

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $user->assignRole(
            Role::where('name', 'user')->get()
        );;

        return $this->respondWithToken(new UserResource($user), $token, 200);
    }

    /**
     * Store a new blog post.
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $request->authenticate();

        $user = User::where('email', $request['email'])->firstOrFail();
        $user->has_logged_in()->save();
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->respondWithToken(new UserResource($user), $token, 200);

    }

    public function user()
    {
        return response()->json(['user' => new UserResource(auth()->user())]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out'
        ];
    }

    protected function respondWithToken($data, $token, $http_code)
    {
      return response()->json([
        'data' => $data,
        'message' => 'Operation Successful',
        'access_token' => $token,
        'token_type' => 'bearer',
      ], $http_code);
    }
}
