<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DesignerController extends Controller
{
    function index(){
        return view('dashboards.designers.index'); 
     }

}
