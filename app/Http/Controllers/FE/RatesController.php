<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RatesController extends Controller
{
    public function index(){
        return view('rate.index');
    }
}
