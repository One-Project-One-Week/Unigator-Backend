<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RegisterUniversityRequest;
use App\Http\Resources\UniversityResource;
use App\Http\Resources\UserResource;
use App\Models\University;
use App\Models\User;
use App\Services\UniversityService;
use App\Traits\HttpResponses;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;

    protected $uniService;

    public function __construct(UniversityService $uniService)
    {
        $this->uniService = $uniService;
    }

    public function userRegister(RegisterRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['role'] = '0';

        $user = User::create($validatedData);
        $token = $user->createToken(time())->plainTextToken;

        return $this->success('success', ["token" => $token, "user" => UserResource::make($user)], "Registration success!", 200);
    }

    public function uniValidate(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        return $this->success("success", $validatedData, "Validation success", 200);
    }

    public function uniRegister(RegisterUniversityRequest $request)
    {
        $validatedData = $request->validated();

        if($request->hasFile('logo')) {
            $filename = $this->uniService->handleLogoUpload($request->file('logo'));
            if (!$filename) {
                return $this->fail('upload-error', null, "Logo Upload Failed", 400);
            }

            $validatedData['logo'] = $filename;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'bio' => $request->bio,
            'role' => '1',
            'password' => Hash::make($request->password)
        ]);

        $validatedData['user_id'] = $user->id;

        $university = University::create($validatedData);
        $university->load('user');

        $token = $user->createToken(time())->plainTextToken;

        return $this->success('success', ["token" => $token, "data" => UniversityResource::make($university)], "University registration success!", 200);
    }

    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::where('email', $validatedData['email'])->first();

        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return $this->fail('login-error', null, "Invalid email or password", 401);
        }

        $token = $user->createToken(time())->plainTextToken;

        if($user->role == '1') {
            $university = University::where('user_id', $user->id)->first();
            $university->load('user');
            return $this->success('success', ["token" => $token, "data" => UniversityResource::make($university)], "Login success!", 200);
        }
        return $this->success('success', ["token" => $token, "data" => UserResource::make($user)], "Login success!", 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success('success', null, "Logout success!", 200);
    }
}
