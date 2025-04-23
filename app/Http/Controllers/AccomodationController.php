<?php

namespace App\Http\Controllers;

use App\Models\Accomodation;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Validation\ValidationException;
use Exception;

class AccomodationController extends Controller
{
    //

    use HttpResponses;

    public function createAccomodation(Request $request)
    {
        try{
            $accomodation = $request->validate([
                'university_id' => 'required|integer|exists:universities,id',
                'estimated_cost' => 'required|numeric',
                'type' => 'required|in:dorm,private-rental',
            ]);
    
            
            $newAccomodation = Accomodation::create([
                'university_id' => $accomodation['university_id'],
                'estimated_cost' => $accomodation['estimated_cost'],
                'type' => $accomodation['type'],
            ]);
            
            return $this->success('Success', $newAccomodation, 'Accomodation created successfully', 201);
        }
        catch(Exception $e){
            return $this->fail('fail', $e->getMessage(), 'Failed to create accomodation', 500);
        }
        
    }


    public function updateAccomodation(Request $request, $id)
    {
        try{
            $validatedData = $request->validate([
                'estimated_cost' => 'required|numeric',
                'type' => 'required|in:dorm,private-rental',
            ]);

            $accomodation = Accomodation::findOrFail($id);

            $accomodation->update([
                'university_id' => $accomodation->university_id,
                'estimated_cost' => $validatedData['estimated_cost'],
                'type' => $validatedData['type'],
            ]);

            return $this->success('Success', $accomodation, 'Accomodation updated successfully', 200);

        }
        catch(ValidationException $e){
            return $this->fail('fail', $e->validator->errors(), 'Failed to update accomodation', 500);
        }
    }

    public function deleteAccomodation($id)
    {
        try{
            $accomodation = Accomodation::findOrFail($id);
            $accomodation->delete();

            return $this->success('Success', null, 'Accomodation deleted successfully', 200);
        }
        catch(Exception $e){
            return $this->fail('fail', $e->getMessage(), 'Failed to delete accomodation', 500);
        }
    }
   
}
