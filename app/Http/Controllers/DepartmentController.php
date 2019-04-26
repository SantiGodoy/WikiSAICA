<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{

	public function index()
    {
        
    }

	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $articles = $articles = DB::table('articles')->where('allowed', 'true')->where('department_id', $id)->orderBy('created_at', 'desc')->get();
        $user = null;
        return view('articles.index', compact('articles', 'user'));
    }
}
