<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
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
        $universities = University::with('programs')->get();

        return $this->success('success', UniversityResource::collection($universities), "All Universities", 200);
    }

    public function topUniversities()
    {
        $universities = University::orderBy('ranking', 'asc')->take(6)->get();

        return $this->success('success', UniversityResource::collection($universities), "Top Universities", 200);
    }

    public function detail($slug)
    {
        $university = University::with('programs')->where('slug', $slug)->first();

        if (!$university) {
            return $this->fail('not-found', null, "University Not Found", 404);
        }

        return $this->success('success', UniversityResource::make($university), "University Details", 200);
    }

    public function updateInfo(UpdateProfileRequest $request, UpdateUniversityRequest $uniRequest)
    {
        $validatedData = $request->validated();
        $validatedUniData = $uniRequest->validated();

        $user = Auth::user();
        $university = $user->university;

        $user->update($validatedData);

        if(isset($uniRequest['image'])) {
            if($university->image) {
                $this->university->deleteMultipleImages($university->image, );
            }
            $validatedUniData['image'] = $this->university->handleMultipleUpload($uniRequest['image']);
        }
        else {
            $validatedUniData['image'] = $university->image;
        }

        if($uniRequest->hasFile('logo')) {
            $this->university->deleteImage($university->logo);
            $validatedUniData['logo'] = $this->university->handleImageUpload($uniRequest['logo']);
        }
        else {
            $validatedUniData['logo'] = $university->logo;
        }

        $university->update($validatedUniData);
        $university->load('user');
        $university->load('programs');

        return $this->success('success', UniversityResource::make($university), "Profile Updated Successfully", 200);
    }
}
