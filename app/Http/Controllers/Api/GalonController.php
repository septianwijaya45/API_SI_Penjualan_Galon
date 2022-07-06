<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Galon;
use Illuminate\Http\Request;

class GalonController extends Controller
{
    function index(){
        $galon = Galon::all();

        return response()->json([
            'status'    => true,
            'data'      => $galon
        ]);
    }
}
