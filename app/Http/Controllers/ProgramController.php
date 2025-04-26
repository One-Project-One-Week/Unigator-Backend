<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Http\Resources\ProgramDetailResource;
use App\Http\Resources\ProgramResource;
use App\Models\Program;
use App\Services\ProgramService;
use App\Traits\HttpResponses;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
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
            $programList = ProgramResource::collection($this->programmservice->getAll()->load('category'));
            return $this->success('program-success', $programList, 'Programs retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->fail('program-fail', null, $e->getMessage(), 404);
        }
    }

    public function getPrograms(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $search = $request->query('search');
        $country = $request->query('country');
        $city = $request->query('city');
        $budget = $request->query('budget');
        $type = $request->query('type');
        $level = $request->query('level');

        // Calculate max budget if budget parameter exists
        $maxBudget = $budget ? $budget * 1.15 : null;

        \Log::info('Budget filter:', [
            'requested_budget' => $budget,
            'calculated_max_budget' => $maxBudget
        ]);

        // Build query
        $query = Program::with(['category', 'universities']) // Using 'universities' as per your relationship
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhereHas('category', fn($q) => $q->where('name', 'like', "%$search%"));
                });
            })
            ->when($country, function ($query, $country) {
                $query->whereHas('universities', fn($q) => $q->where('country', $country));
            })
            ->when($city, function ($query, $city) {
                $query->whereHas('universities', fn($q) => $q->where('city', $city));
            })
            ->when($type, function ($query, $type) {
                $query->whereHas('universities', fn($q) => $q->where('type', $type));
            })
            ->when($maxBudget, function ($query) use ($maxBudget) {
                $query->where('average_cost', '<=', $maxBudget);
            })
            ->when($level, fn($query, $level) => $query->where('level', $level));

        // Apply ordering based on budget presence
        if ($budget) {
            $query->orderBy('average_cost', 'desc');  // Most expensive first when budget exists
        } else {
            $query->orderBy('name', 'asc');  // A-Z when no budget
        }

        // Debug the final query
        \Log::debug('Final query:', [
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings()
        ]);

        // Execute paginated query
        $programs = $query->paginate($perPage);

        return $this->success('program-success', [
            'data' => ProgramResource::collection($programs),
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

    public function getAverageProgramCost()
    {
        $programs = Program::all(); // Get all programs
        $averageFeesPerProgram = [];

        foreach ($programs as $program) {
            // Decode the 'detail' field if it's a JSON string
            $details = $program->detail;

            // Check if the decoded details are valid
            if (is_array($details)) {
                $tuitionFees = [];

                // Loop through each detail to get the tuition fees
                foreach ($details as $detail) {
                    // Assuming 'tuitionFees' is a key inside each detail
                    $tuitionFees[] = $detail['tuition_fees'];
                }

                // Calculate the average for this program
                $averageFeesPerProgram[] = [
                    'program_id' => $program->name,
                    'average_tuition_fee' => collect($tuitionFees)->avg()
                ];
            }
        }

        return response()->json([
            'average_fees_per_program' => $averageFeesPerProgram
        ]);
        // return $averageFeesPerProgram;
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

        // $validatedData['detail'] = json_encode($validatedData['detail']);
        // $validatedData['application_requirement'] = json_encode($validatedData['application_requirement']);
        try {
            $totalFees = array_sum(array_column($validatedData['detail'], 'tuition_fees'));
            $yearsCount = count($validatedData['detail']);
            $average = $yearsCount > 0 ? $totalFees / $yearsCount : 0;
            $validatedData['average_cost'] = round($average, 2);
            $resProgram = ProgramResource::make($this->programmservice->createData($validatedData)->load('category'));
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
            $program = ProgramDetailResource::make($this->programmservice->getDataById($id)->load(['universities', 'category']));
            return $this->success('program-success', $program, 'Program retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->fail('program-fail', null, $e->getMessage(), 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        try {
            $program = ProgramDetailResource::make($this->programmservice->getDataById($id)->load(['universities', 'category']));
            return $this->success('program-success', $program, 'Program retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->fail('program-fail', null, $e->getMessage(), 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProgramRequest $request, string $id)
    {
        $validatedData = $request->validated();

        try {
            // Calculate average cost if detail is provided in the update
            if (isset($validatedData['detail'])) {
                $totalFees = array_sum(array_column($validatedData['detail'], 'tuition_fees'));
                $yearsCount = count($validatedData['detail']);
                $average = $yearsCount > 0 ? $totalFees / $yearsCount : 0;
                $validatedData['average_cost'] = round($average, 2);
            }

            $program = $this->programmservice->updateData($id, $validatedData);

            $resProgram = ProgramResource::make($this->programmservice->getDataById($id)->load('category'));

            return $this->success('program-update-success', $resProgram, 'Program updated successfully', 200);
        } catch (\Exception $e) {
            return $this->fail('program-update-fail', null, $e->getMessage(), 500);
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
            return $this->fail('program-fail', null, $e->getMessage(), 404);
        }
    }
}