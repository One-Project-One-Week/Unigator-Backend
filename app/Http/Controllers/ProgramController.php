<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Http\Resources\ProgramResources;
use App\Services\ProgramService;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    use HttpResponses;
    protected $programmservice;
    public function __construct(ProgramService $programService)
    {
        $this->programmservice = $programService;
    }

    public function index()
    {
        //
        try {
            $programList = ProgramResources::collection($this->programmservice->getAll());
            return $this->success('program-success', $programList, 'Programs retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->fail('program-fail', null, 'Failed to retrieve programs', 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProgramRequest $request)
    {
        //
        $validatedData = $request->validated();
        try {
            $resProgram = ProgramResources::make($this->programmservice->createData($validatedData));
            return $this->success('program-success', $resProgram, 'Program created successfully', 201);
        } catch (\Exception $e) {
            return $this->fail('program-fail', null, 'Failed to create program', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        try {
            $program = ProgramResources::make($this->programmservice->getDataById($id));
            return $this->success('program-success', $program, 'Program retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->fail('program-fail', null, 'Failed to retrieve program', 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        try {
            $program = ProgramResources::make($this->programmservice->getDataById($id));
            return $this->success('program-success', $program, 'Program retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->fail('program-fail', null, 'Failed to retrieve program', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProgramRequest $request, string $id)
    {
        //
        $validatedData = $request->validated();
        try {
            $program = $this->programmservice->updateData($id, $validatedData);
            $resProgram = ProgramResources::make($this->programmservice->getDataById($id));
            return $this->success('program-success', $resProgram, 'Program updated successfully', 200);
        } catch (\Exception $e) {
            return $this->fail('program-fail', null, 'Failed to update program', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $this->programmservice->deleteData($id);
            return $this->success('program-success', null, 'Program deleted successfully', 200);
        } catch (\Exception $e) {
            return $this->fail('program-fail', null, 'Failed to delete program', 500);
        }
    }
}