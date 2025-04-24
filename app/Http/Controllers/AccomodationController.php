<?php

namespace App\Http\Controllers;

use App\Models\Accomodation;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\CreateAccomodationRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Services\AccomodationService;
use App\Http\Resources\AccomodationResource;
use Exception;

class AccomodationController extends Controller
{
    //

    use HttpResponses;


    protected $accomodationService;

    public function __construct(AccomodationService $accomodationService)
    {
        $this->accomodationService = $accomodationService;
    }

    public function createAccomodation(CreateAccomodationRequest $request)
    {
        // try{
        //     $accomodation = $request->validate([
        //         'university_id' => 'required|integer',
        //         'estimated_cost' => 'required|numeric',
        //         'type' => 'required|in:dorm,private-rental',
        //     ]);
    
            
        //     $newAccomodation = Accomodation::create([
        //         'university_id' => $accomodation['university_id'],
        //         'estimated_cost' => $accomodation['estimated_cost'],
        //         'type' => $accomodation['type'],
        //     ]);
            
        //     return $this->success('Success', $newAccomodation, 'Accomodation created successfully', 201);
        // }
        // catch(Exception $e){
        //     return $this->fail('fail', $e->getMessage(), 'Failed to create accomodation', 500);
        // }

        $validatedData = $request->validated();

        try{
            $resAccomodation = AccomodationResource::make($this->accomodationService->createData($validatedData));
            return $this->success('program-success', $resAccomodation, 'Accomodation created successfully', 201);
        }catch(Exception $e)
        {
            return $this->fail('accomodation-fail', null, $e->getMessage(), 500);
        }
    }


    public function updateAccomodation(UpdateProgramRequest $request, $id)
    {
        // try{
        //     $validatedData = $request->validate([
        //         'estimated_cost' => 'required|numeric',
        //         'type' => 'required|in:dorm,private-rental',
        //     ]);

        //     $accomodation = Accomodation::findOrFail($id);

        //     $accomodation->update([
        //         'university_id' => $accomodation->university_id,
        //         'estimated_cost' => $validatedData['estimated_cost'],
        //         'type' => $validatedData['type'],
        //     ]);

        //     return $this->success('Success', $accomodation, 'Accomodation updated successfully', 200);

        // }
        // catch(ValidationException $e){
        //     return $this->fail('fail', $e->validator->errors(), 'Failed to update accomodation', 500);
        // }

        $validatedData = $request->validated();

        // $accomodation = $this->accomodationService->updateData($id, $validatedData);
        // $resAccomodation = AccomodationResource::make($this->accomodationService->getDataById($id));

        // dd($resAccomodation);
   
        try {
            $accomodation = $this->accomodationService->updateData($id, $validatedData);
            $resAccomodation = AccomodationResource::make($this->accomodationService->getDataById($id));

            // dd($resAccomodation);
            // return $this->success('accomodation-success', $resAccomodation, 'Accomodation updated successfully', 200);

            return response()->json([
                "test"=> $resAccomodation,
                "status" => $accomodation
            ]);
        } catch (Exception $e) {
            return $this->fail('accomodation-fail', null, $e->getMessage(), 500);
        }
    }

    public function deleteAccomodation($id)
    {
        // try{
        //     $accomodation = Accomodation::findOrFail($id);
        //     $accomodation->delete();

        //     return $this->success('Success', null, 'Accomodation deleted successfully', 200);
        // }
        // catch(Exception $e){
        //     return $this->fail('fail', $e->getMessage(), 'Failed to delete accomodation', 500);
        // }

        try {
            $this->accomodationService->deleteData($id);
            return $this->success('accomodation-success', null, 'accomodation deleted successfully', 200);
        } catch (Exception $e) {
            return $this->fail('accomodation-fail', null, $e->getMessage(), 500);
        }
    }
   
}
