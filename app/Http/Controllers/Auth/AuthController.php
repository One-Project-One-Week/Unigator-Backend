<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RegisterUniversityRequest;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function userRegister(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::create($validatedData);
        $token = $user->createToken(time())->plainTextToken;

    }

    public function uniValidate(RegisterRequest $request)
    {
        $validatedData = $request->validated();

    }

    public function uniRegister(RegisterUniversityRequest $request)
    {
        $validatedData = $request->validated();
        $validateData['role'] = '1';

        if($request->hasFile('logo')) {
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('logos', $filename, 'r2');

            $validatedData['logo'] = $filename;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'bio' => $request->bio,
            'password' => Hash::make($request->password)
        ]);

        $university = University::create($validatedData);

        $token = $user->createToken(time())->plainTextToken;
    }

    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::where('email', $validatedData['email']->first());

        if (!$user || Hash::check($validatedData['password'], $user->password)) {
            return response()->json(['message' => 'Invalid email or password.'], 401);
        }

        $token = $user->CreateToken(time())->plainTextToken;

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }
}
