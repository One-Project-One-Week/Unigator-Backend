<?php

namespace App\Services;

use App\Models\University;

class UniversityService extends CommonService
{
    public function connection()
    {
        return new University();
    }

    public function handleImageUpload($image)
    {
        if ($image) {
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('logos', $filename, 'r2');

            return $filename;
        } else {
            return null;
        }
    }

    public function handleMultipleUpload(array $image)
    {
        $path = [];

        if(isset($image) && is_array($image)) {
            foreach ($image as $item) {
                $this->handleImageUpload($item);
            }
        }
    }
}
