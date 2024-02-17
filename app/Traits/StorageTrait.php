<?php
namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

trait StorageTrait
{
    protected function createFolder($folderPath): void
    {
        // Check if the folder already exists, if not, create it
        if (!Storage::exists($folderPath)) {
            Storage::makeDirectory($folderPath);
        }
    }
    protected function deleteFolder($folderPath): void
    {
        // Check if the folder exists before attempting to delete it
        if (Storage::exists($folderPath)) {
            // Delete the folder
            Storage::deleteDirectory($folderPath);
        }
    }

    protected function getBase64($path): string
    {
        $file = Storage::get($path);
        return base64_encode($file);
    }


    /**
     * @throws InvalidManipulation
     */
    protected function cropImage($path, $x, $y, $width, $height): void
    {
        Image::load(Storage::get($path))
            ->manualCrop($width, $height, $x, $y)->save(Storage::get($path));
    }
}
