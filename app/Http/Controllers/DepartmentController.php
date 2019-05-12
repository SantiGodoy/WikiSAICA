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
        $articles = DB::table('articles')->where('allowed', 'true')->where('department_id', $id)->orderBy('created_at', 'desc')->paginate(10);
        return view('articles.departments', compact('articles'));
    }
}
