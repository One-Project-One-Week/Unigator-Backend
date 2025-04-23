<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;

class AccomodationController extends Controller
{
    //

    use HttpResponses;

    public function create(Request $request)
    {
        $request->validate([
            'university_id' => 'required|integer|exists:universities,id',
            'avg_cost' => 'required|numeric',
            'type' => 'required|in:dorm,private-rental',
        ]);

        // Create accomodation logic here

        
    }
   
}
