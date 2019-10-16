<?php

namespace App\Http\Controllers;

use App\Parametros;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $par = Parametros::find(1);

        if(isset($par)){
            return view('parametros',compact('par'));
        }
    }
}
