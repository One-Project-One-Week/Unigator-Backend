<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRateRequest;
use Illuminate\Http\Request;
use App\Models\University;
use App\Models\Rating;
use App\Traits\HttpResponses;
use Exception;

use App\Models\User;

class RatingController extends Controller
{
    //
    use HttpResponses;
    public function getRating(Request $request)
    {
        $request->validate([
            'university_id' => 'required|integer|exists:universities,id',
        ]);

        $university = University::findOrFail($request->university_id);

        // Get total rating count and total rating from the 'ratings' table
        $ratingCount = $university->ratings()->count();
        $totalRating = $university->ratings()->sum('rating_rate');
        $averageRating = $ratingCount > 0 ? round($totalRating / $ratingCount, 1) : 0;

        $data = [
            'university_id' => $university->id,
            'rating_count' => $ratingCount,
            'average_rating' => $averageRating,
        ];

        return $this->success("success", $data, "Rating data fetched successfully", 200);
    }


    public function createRating(CreateRateRequest $request)
    {

        try {
            $validatedData = $request->validated();

            $user = User::findOrFail($validatedData['user_id']);
            if (!$user || $user->role !== "0") {
                return $this->fail('forbidden', null, "Only student accounts can give ratings", 403);
            } 
            else {


                $data = Rating::create([
                    "user_id" => $validatedData['user_id'],
                    "university_id" => $validatedData['university_id'],
                    "rating_rate" => $validatedData['rating_rate'],
                ]);

                return $this->success("success", $data, "Rating created successfully", 201);
            }
        } catch (Exception $e) {
            return $this->fail('rating-fail', null, $e->getMessage(), 500);
        }
    }
}
