<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class SectionController extends Controller
{
    public function dash(){
        return view('dash');
    }

    public function settings(){
        return view('settings');
    }


}
