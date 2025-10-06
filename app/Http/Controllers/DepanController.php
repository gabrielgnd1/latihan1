<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepanController extends Controller
{
    public function superCantik($lanjutan = "beneran") {
        return view('superCantik', ['data' => $lanjutan]);
    }
}
