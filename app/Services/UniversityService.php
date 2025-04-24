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

    public function handleSingleUpload($image)
    {
        if ($image) {
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('images', $filename, 'r2');

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
                $filename = $this->handleSingleUpload($item);
                $path[] = $filename;
            }
        }
        return $path;
    }

    public function deleteLogo($image)
    {
        if ($image && Storage::disk('r2')->exists('logos/' . $image)) {
            Storage::disk('r2')->delete('logos/' . $image);
        }
        else {
            return null;
        }
    }

    public function deleteSingleImage($image)
    {
        if ($image && Storage::disk('r2')->exists('images/' . $image)) {
            Storage::disk('r2')->delete('images/' . $image);
        }
        else {
            return null;
        }
    }

    public function deleteMultipleImages(array $image, $existingImages)
    {
        $deletingImgs = array_diff($image, $existingImages);
        foreach ($deletingImgs as $img) {
            $this->deleteSingleImage($img);
        }
    }
}
