<?php
namespace App\Traits;

use Illuminate\Support\Facades\Storage;

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
}
