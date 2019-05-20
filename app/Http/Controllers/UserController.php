<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $articles = DB::table('articles')->where('id_user', $user->id)->orWhere('updated_by', $user->id)->orderBy('updated_at', 'desc')->get();
        return view('user.articles_by_user', compact('articles'));
    }

    public function show($id)
    {
        $article = Article::find($id);
        $user = DB::table('users')->where('id', $article->id_user)->first();
        $userUpdate = DB::table('users')->where('id', $article->updated_by)->first();
        $department = DB::table('departments')->where('id', $article->department_id)->first();
        $documents = DB::table('documents')->where('article_id', $id)->pluck('filename');
        return view('articles.show_article', compact('article', 'user', 'userUpdate', 'department','documents'));
    }

    public function destroy($id)
    {
        $article = Article::find($id);

        if($article->created_at == $article->updated_at)
        {
            $article->delete();
        }
        else{
            $new = new Article;
            $restaurado = DB::table('versions')->where('id_article', $article->id)->orderBy('updated_at','desc')->first();
            $new->id = $restaurado->id_article;
            $new->title = $restaurado->title;
            $new->description = $restaurado->description;
            $new->department_id = $restaurado->department_id;
            $new->id_user = $restaurado->id_user;
            $new->updated_by = $restaurado->updated_by;
            $new->created_at = $restaurado->created_at;
            $new->updated_at = $restaurado->updated_at;
            $new->allowed = true;
            $article->delete();
            $new->save();
        }

        return redirect()->back();
    }
}
