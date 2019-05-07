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
        $user =  Auth::user();
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
      $article->updated_by = $article->id_user;
      $article->department_id = $request->get('Department');
      $article->save();

      foreach($request->documents as $document){
        $filename = $document->getClientOriginalName();
        $document->storeAs('document', $filename);
        DB::table('documents')->insert(['article_id' => $article->id, 'filename'=> $filename, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]);
      }

      return redirect('/articles')->with('success', 'Artículo añadido con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = null;
        if((Auth::user()->role) == "admin")
            $article = DB::table('articles')->where('id', $id)->first();
        else
            $article = DB::table('articles')->where('id', $id)->where('allowed', 'true')->first();
        if($article != null)
        {
            $user = DB::table('users')->where('id', $article->id_user)->first();
            $userUpdate = DB::table('users')->where('id', $article->updated_by)->first();
            $department = DB::table('departments')->where('id', $article->department_id)->first();
            $documents = DB::table('documents')->where('article_id', $id)->pluck('filename');
            return view('articles.show_article', compact('article', 'user', 'userUpdate', 'department','documents'));
        }
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
      $article->updated_by = Auth::user()->id;
      $article->allowed = false;
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

        return redirect('/articles')->with('success', 'Articulo borrado');
    }


}
