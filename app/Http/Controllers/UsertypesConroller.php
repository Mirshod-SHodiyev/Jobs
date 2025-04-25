<?php

namespace App\Http\Controllers;

use App\Models\Usertypes;
use Illuminate\Http\Request;



class UsertypesConroller extends Controller
{
    public function index()
    {
        return Usertypes::all();
    }
}
