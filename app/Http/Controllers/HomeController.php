<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function redirectUser(): \Illuminate\Http\RedirectResponse
    {
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.homepage');
        } else {
            return redirect()->route('user.project.index');
        }
    }
    public function test(){
        $keepingAIClass = Label::imageQuality()->where('status','=', 1)->pluck('id')->toArray();
        echo "<pre>";
        print_r($keepingAIClass);
        echo "</pre>";


        if (in_array('42', $keepingAIClass)) echo "XXX";
        else echo "YYY";

    }
}
