<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Http\Resources\ProgramResources;
use App\Models\Program;
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
            $programList = ProgramResources::collection($this->programmservice->getAll()->load('category'));
            return $this->success('program-success', $programList, 'Programs retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->fail('program-fail', null, $e->getMessage(), 500);
        }
    }

    public function getPrograms(Request $request)
    {
        $perPage = $request->query('per_page');
        if ($perPage) {
            $perPage = $request->query('per_page') > 0 ? $request->query('per_page') : 10;
        } else {
            $perPage = 10;
        }
        $search = $request->query('search');

        $programs = Program::with('category')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->orderBy('created_at', 'desc')->paginate($perPage);

        $resProgram = ProgramResources::collection($programs);
        return $this->success('program-success', [
            'data' => $resProgram,
            'meta' => [
                'current_page' => $programs->currentPage(),
                'last_page' => $programs->lastPage(),
                'per_page' => $programs->perPage(),
                'total' => $programs->total(),
                'next_page_url' => $programs->nextPageUrl(),
                'prev_page_url' => $programs->previousPageUrl(),
                'first_page_url' => $programs->url(1),
                'last_page_url' => $programs->url($programs->lastPage()),
            ]
        ], 'Programs retrieved successfully', 200);
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
        $validatedData['detail'] = json_encode($validatedData['detail']);
        $validatedData['application_requirement'] = json_encode($validatedData['application_requirement']);
        try {
            $resProgram = ProgramResources::make($this->programmservice->createData($validatedData)->load('category'));
            return $this->success('program-success', $resProgram, 'Program created successfully', 201);
        } catch (\Exception $e) {
            return $this->fail('program-fail', null, $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        try {
            $program = ProgramResources::make($this->programmservice->getDataById($id)->load('category'));
            return $this->success('program-success', $program, 'Program retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->fail('program-fail', null, $e->getMessage(), 500);
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
            return $this->fail('program-fail', null, $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProgramRequest $request, string $id)
    {
        //
        $validatedData = $request->validated();
        $validatedData['detail'] = json_encode($validatedData['detail']);
        $validatedData['application_requirement'] = json_encode($validatedData['application_requirement']);
        try {
            $program = $this->programmservice->updateData($id, $validatedData);
            $resProgram = ProgramResources::make($this->programmservice->getDataById($id)->load('category'));
            return $this->success('program-success', $resProgram, 'Program updated successfully', 200);
        } catch (\Exception $e) {
            return $this->fail('program-fail', null, $e->getMessage(), 500);
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
            return $this->fail('program-fail', null, $e->getMessage(), 500);
        }
    }
}