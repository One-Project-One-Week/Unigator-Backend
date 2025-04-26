<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scholarship;

class ScholarshipController extends Controller
{
    //
    public function getScholarshipInfoAll()
    {
        $scholarships = Scholarship::with('program')->get();
    
        $result = $scholarships->map(function ($scholarship) {
            return [
                "id" => $scholarship->id,
                "program_name" => $scholarship->program->name ?? null,
                "type" => $scholarship->type,
                "scholarship_percentage" => $scholarship->scholarship_percentage,
            ];
        });
    
        return response()->json([
            "scholarships" => $result,
        ]);
    }
    
    
    public function getScholarshipInfo($id)
    {
        $scholarship = Scholarship::with('program')->where('uuid', $id)->firstOrFail();
        return response()->json($scholarship);
    }

}
