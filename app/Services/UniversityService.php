<?php

namespace App\Services;

use App\Models\University;
use Illuminate\Support\Facades\Storage;

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
                $filename = uniqid() . '_' . $item->getClientOriginalName();
                $item->storeAs('images', $filename, 'r2');
                $path[] = $filename;
            }
        }
        return $path;
    }

    public function deleteImage($image)
    {
        if ($image && Storage::disk('r2')->exists('logos/' . $image)) {
            Storage::disk('r2')->delete('logos/' . $image);
        }
        else {
            return null;
        }
    }

    public function deleteMultipleImages(array $image, )
    {
        
    }
}
