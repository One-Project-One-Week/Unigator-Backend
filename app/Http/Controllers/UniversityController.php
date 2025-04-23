<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUniversityRequest;
use App\Http\Resources\UniversityResource;
use App\Models\University;
use App\Services\UniversityService;
use App\Traits\HttpResponses;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    use HttpResponses;

    protected $university;
    public function __construct(UniversityService $university)
    {
        $this->university = $university;
    }

    public function all()
    {
        $universities = University::all();

        return $this->success('success', UniversityResource::collection($universities), "All Universities", 200);
    }

    public function topUniversities()
    {
        $universities = University::orderBy('ranking', 'asc')->take(6)->get();

        return $this->success('success', UniversityResource::collection($universities), "Top Universities", 200);
    }

    public function detail($slug)
    {
        $university = University::where('slug', $slug)->first();

        if (!$university) {
            return $this->fail('not-found', null, "University Not Found", 404);
        }

        return $this->success('success', UniversityResource::make($university), "University Details", 200);
    }

    public function updateInfo(UpdateUniversityRequest $request)
    {
        $validatedData = $request->validated();

        $university = Auth::user()->university;
    }
}
