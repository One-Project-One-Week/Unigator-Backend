<?php

namespace App\Services;

use App\Models\University;

class UniversityService extends CommonService
{
    public function connection()
    {
        return new University();
    }

    public function handleLogoUpload($image)
    {
        if ($image) {
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('logos', $filename, 'r2');

            return $filename;
        } else {
            return null;
        }
    }

    public function handleImageUpload(array $data)
    {
        
    }
}
