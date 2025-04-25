<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    //
    use HttpResponses;

    public function getUserProfile()
    {

        try {
            $user = Auth::user();
            // $user = User::findOrFail(1);

            if (!$user) {
                return $this->fail('not-found', null, "User not found", 404);
            }

            $returnableUser = [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "phone" => $user->phone,
                "bio" => $user->bio,
            ];

            return $this->success('success', ["user" => $returnableUser], "User profile fetched successfully", 200);
        } catch (\Exception $e) {
            return $this->fail('error', null, $e->getMessage(), 500);
        }
    }


    public function updateProfile(Request $request)
    {

        try {


            $authenticatedUser = Auth::user(); // get the logged-in user

            if (!$authenticatedUser) {
                return response()->json(['message' => 'Not authenticated'], 401);
            }

            $user = User::find($authenticatedUser->id);

            // Validate input
            $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email,' . $authenticatedUser->id,
                'phone' => 'sometimes|string|max:15|min:7',
                'password' => 'sometimes|string|min:8|confirmed',
            ]);

            // Update fields if present
            if ($request->has('name')) {
                $user->name = $request->name;
            }

            if ($request->has('email')) {
                $user->email = $request->email;
            }

            if ($request->has('phone')) {
                $user->phone = $request->phone;
            }
            if ($request->has('password')) {
                $user->password = bcrypt($request->password);
            }

            if( $request->has('bio')) {
                $user->bio = $request->bio;
            }   

            $user->save();

            return $this->success(
                'success',
                ["user" => [
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email,
                    "phone" => $user->phone,
                    "bio" => $user->bio,
                ]],
                "User profile updated successfully",
                200
            );
        } catch (\Exception $e) {
            return $this->fail('error', null, $e->getMessage(), 500);
        }
    }
}
