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
            $path = 'logos/' . $filename;
            $image->storeAs('logos', $filename, 'r2');

            return $path;
        } else {
            return null;
        }
    }

    public function handleSingleUpload($image)
    {
        if ($image) {
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = 'covers/' . $filename;
            $image->storeAs('covers', $filename, 'r2');

            return $path;
        } else {
            return null;
        }
    }

    public function handleMultipleUpload(array $image)
    {
        $paths = [];

        if(isset($image) && is_array($image)) {
            foreach ($image as $item) {
                $filename = time() . '_' . $item->getClientOriginalName();
                $path = 'images/' . $filename;
                $item->storeAs('images', $filename, 'r2');
                $paths[] = $path;
            }
        }
        return $paths;
    }

    public function deleteLogo($image)
    {
        if ($image && Storage::disk('r2')->exists($image)) {
            Storage::disk('r2')->delete($image);
        }
        else {
            return null;
        }
    }

    public function deleteSingleImage($image)
    {
        if ($image && Storage::disk('r2')->exists($image)) {
            Storage::disk('r2')->delete($image);
        }
        else {
            return null;
        }
    }

    public function deleteMultipleImages(array $image, $existingImages)
    {
        $deletingImgs = array_diff($image, $existingImages);
        foreach ($deletingImgs as $img) {
            if ($img && Storage::disk('r2')->exists($img)) {
                Storage::disk('r2')->delete($img);
            }
        }
    }
}
