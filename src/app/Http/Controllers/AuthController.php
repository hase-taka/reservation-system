<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
{
  return view('index');
}

    public function thanks(){
      return view('thanks');
    }
    
    public function done(){
      return view('done');
    }

}
