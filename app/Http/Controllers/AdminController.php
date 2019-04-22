<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = $articles = DB::table('articles')->where('allowed', 'false')->orderBy('created_at', 'desc')->get();
        $user = null;
        return view('admin.index', compact('articles', 'user'));
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$article = Article::find($id);
    	$article->allowed = true;
    	$article->save();
    	error_log('Articulo');
       	return $this->index();
    }
}
