<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateUniversityRequest;
use App\Http\Resources\UniversityDetailResource;
use App\Http\Resources\UniversityResource;
use App\Models\University;
use App\Services\UniversityService;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UniversityController extends Controller
{
    use HttpResponses;

    protected $university;
    public function __construct(UniversityService $university)
    {
        $this->university = $university;
    }

    public function allUniversities(Request $request)
    {
        $perPage = $request->query('per_page');
        if ($perPage) {
            $perPage = $request->query('per_page') > 0 ? $request->query('per_page') : 10;
        } else {
            $perPage = 10;
        }
        $search = $request->search;
        $city = $request->city;
        $country = $request->country;
        $price = $request->price;

        $universities = University::with('user')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('slug', 'like', '%' . $search . '%')
                        ->orWhereHas('user', function ($q2) use ($search) {
                            $q2->where('name', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when($country, function ($query, $country) {
                $query->where('country', $country);
            })
            ->when($city, function ($query, $city) {
                $query->where('city', $city);
            })
            ->when($price, function ($query, $price) {
                $query->whereHas('programs', function ($q) use ($price) {
                    $q->groupBy('university_id')
                        ->havingRaw('AVG(price) <= ?', [$price]);
                });
            })
            ->orderBy('ranking', 'asc')
            ->paginate($perPage);

        if (!$universities) {
            return $this->fail('not-found', null, "No University Available.", 404);
        }

        return $this->success('success', [
            'data' => UniversityResource::collection($universities),
            'meta' => [
                'current_page' => $universities->currentPage(),
                'last_page' => $universities->lastPage(),
                'per_page' => $universities->perPage(),
                'total' => $universities->total(),
                'next_page_url' => $universities->nextPageUrl(),
                'prev_page_url' => $universities->previousPageUrl(),
                'first_page_url' => $universities->url(1),
                'last_page_url' => $universities->url($universities->lastPage()),
            ]
        ], "All Universities", 200);
    }

    public function topUniversities()
    {
        $universities = University::orderBy('ranking', 'asc')->take(6)->get();
        if (!$universities) {
            return $this->fail('not-found', null, "No University Available.", 404);
        }

        return $this->success('success', UniversityResource::collection($universities), "Top Universities", 200);
    }

    public function detail($slug)
    {
        $university = University::with(['programs', 'accommodations'])->where('slug', $slug)->first();
        if (!$university) {
            return $this->fail('not-found', null, "University Not Found", 404);
        }
        $similarUniversities = University::where('country', $university->country)
            ->where('id', '!=', $university->id)
            ->take(2)
            ->get();

        

        return $this->success('success', UniversityDetailResource::make($university), "University Details", 200);
    }

    public function dashboard()
    {
        $user = Auth::user();
        $university = University::with(['programs', 'accommodations'])->where('user_id', $user->id)->first();
        if (!$university) {
            return $this->fail('not-found', null, "University Not Found", 404);
        }

        return $this->success('success', UniversityDetailResource::make($university), "University Dashboard", 200);
    }

    public function updateInfo(UpdateProfileRequest $request, UpdateUniversityRequest $uniRequest)
    {
        $validatedData = $request->validated();
        $validatedUniData = $uniRequest->validated();

        $user = Auth::user();
        $university = $user->university;

        $user->update($validatedData);

        if (isset($uniRequest['image'])) {
            $existingImages = [];
            if ($university->image) {
                $existingImages = $request->existing_img ?? [];
                $this->university->deleteMultipleImages($university->image, $existingImages);
            }
            $newImages = $this->university->handleMultipleUpload($uniRequest['image']);

            $validatedUniData['image'] = array_merge($newImages, $existingImages);
        } else {
            $validatedUniData['image'] = $university->image;
        }

        if ($uniRequest->hasFile('logo')) {
            $this->university->deleteLogo($university->logo);
            $validatedUniData['logo'] = $this->university->handleLogoUpload($uniRequest['logo']);
        } else {
            $validatedUniData['logo'] = $university->logo;
        }

        if ($uniRequest->hasFile('cover')) {
            $this->university->deleteSingleImage($university->cover);
            $validatedUniData['cover'] = $this->university->handleSingleUpload($uniRequest['cover']);
        } else {
            $validatedUniData['cover'] = $university->cover;
        }

        $university->update($validatedUniData);
        $university->load(['user', 'programs']);

        return $this->success('success', UniversityDetailResource::make($university), "University profile updated successfully", 200);
    }
}
