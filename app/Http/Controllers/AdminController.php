<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Version;
use App\Articles_deleted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
        $article->timestamps = false;
        $article->save();
        $article->timestamps = true;
        if($article->created_at == $article->updated_at)
        {
            Version::addVersion($article, 1);
        }
        else
        {
            Version::addVersion($article, 0);
        }

    	error_log('Artículo');
       	return $this->index();
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

        $documents = DB::table('documents')->where('article_id', $id)->pluck('filename');

        if($documents != NULL)
        {
            foreach($documents as $document)
            {
             unlink(storage_path('app/documents/'.$document));
             DB::table('documents')->where('article_id', '=', $id)->delete();
            }
        }

        $article->delete();

        return redirect('/articles')->with('success', 'Artículo borrado');
    }

}
