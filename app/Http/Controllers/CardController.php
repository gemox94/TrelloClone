<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardController extends Controller
{
    //Prueba
    public function index(){
    	return response()->json(['response' => 'test response']);
    }
}
