<?php
namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ProcessingResponseTrait
{
    protected function convertToPercentage($number, $precision = 2)
    {
        return  round($number * 100, $precision);
    }

}
