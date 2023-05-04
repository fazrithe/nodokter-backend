<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
        $data_score = 20;
             return view('pages/dashboard',compact('data_score'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
    }
}
