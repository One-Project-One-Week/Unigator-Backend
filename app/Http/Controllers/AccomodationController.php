<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAccomodationRequest;
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

    public function getAllAccomodations(Request $request)
    {
        try {
            $accomodations = AccomodationResource::collection(Accomodation::all());
    
            return $this->success(
                'accomodation-success',
                $accomodations,
                'All accommodations fetched successfully',
                200
            );
        } catch (Exception $e) {
            return $this->fail(
                'accomodation-fail',
                null,
                $e->getMessage(),
                500
            );
        }
    }

    public function createAccomodation(CreateAccomodationRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $resAccomodation = AccomodationResource::make($this->accomodationService->createData($validatedData));
            return $this->success('program-success', $resAccomodation, 'Accomodation created successfully', 201);
        } catch (Exception $e) {
            return $this->fail('accomodation-fail', null, $e->getMessage(), 500);
        }
    }

    public function UpdateAccomodation($id, UpdateAccomodationRequest $request)
    {
        $validatedData = $request->validated();
        try {
            $accomodation = $this->accomodationService->updateData($id, $validatedData);
            $resAccomodation = AccomodationResource::make($this->accomodationService->getDataById($id));

            return $this->success('accomodation-success', $resAccomodation, 'Accomodation updated successfully', 200);
        } catch (Exception $e) {
            return $this->fail('accomodation-fail', null, $e->getMessage(), 500);
        }
    }

    public function deleteAccomodation($id)
    {
        try {
            $this->accomodationService->deleteData($id);
            return $this->success('accomodation-success', null, 'accomodation deleted successfully', 200);
        } catch (Exception $e) {
            return $this->fail('accomodation-fail', null, $e->getMessage(), 500);
        }
    }

}