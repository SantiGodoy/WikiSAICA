<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = $articles = DB::table('articles')->where('allowed', 'true')->orderBy('created_at', 'desc')->get();
        $user = null;
        return view('articles.index', compact('articles', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       	return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
        'article_title'=>'required',
        'article_description'=> 'required'
      ]);

      $article = new Article;
      $article->title = $request->get('article_title');
      $article->description = $request->get('article_description');
      $article->id_user = Auth::user()->id;
      $article->save();
      return redirect('/articles')->with('success', 'Article has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = DB::table('articles')->where('id', $id)->where('allowed', 'true')->first();
        if($article != null)
            return view('articles.show_article', compact('article'));
        else
            return redirect('');
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

        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $request->validate([
        'article_title'=>'required',
        'article_description'=> 'required'
      ]);

      $article = Article::find($id);
      $article->title = $request->get('article_title');
      $article->description = $request->get('article_description');
      $article->save();

      return redirect('/articles')->with('success', 'Stock has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        $article->delete();

        return redirect('/articles')->with('success', 'Stock has been deleted Successfully');
    }
}
