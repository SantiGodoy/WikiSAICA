<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Version;
use App\Article;
use Illuminate\Support\Facades\DB;

class VersionController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = DB::table('versions')->orderBy('updated_at', 'desc')->get();
        return view('admin.versions', compact('articles'));
    }

    public function show($id)
    {
        $article = DB::table('versions')->where('id', $id)->first();
        $user = DB::table('users')->where('id', $article->id_user)->first();
        $userUpdate = DB::table('users')->where('id', $article->updated_by)->first();
        $department = DB::table('departments')->where('id', $article->department_id)->first();
        $documents = DB::table('documents')->where('article_version', $id)->pluck('filename');

        return view('articles.show_article', compact('article', 'user', 'userUpdate', 'department','documents'));
    }

    public function edit($id)
    {
        $article = Version::find($id);
        $actual = Article::find($article->id_article);
        $new = new Article;
        if($actual != NULL)
        {

            $new->title = $article->title;
            $new->description = $article->description;
            $new->id = $article->id_article;
            $new->department_id = $article->department_id;
            $new->id_user = $article->id_user;
            $new->updated_by = $article->updated_by;
            $new->created_at = $article->created_at;
            $timestamp = now();
            $new->updated_at = $timestamp;
            $new->allowed = true;

            $actual->delete();

            $new->save();
            Version::addVersion($new, 0);

            $version = Version::all()->last();

            $docs = DB::table('documents')->where('article_version', $id)->get();
            if($docs != null)
            {
              foreach ($docs as $doc) {

                  if(DB::table('documents')->where('id', $doc->id)->value('deleted'))
                    DB::table('documents')->where('id', $doc->id)->update(['deleted' => 'false']);

                  DB::table('documents')->insert(['article_id' => $doc->article_id, 'filename'=> $doc->filename,'article_version' => $version->id, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'deleted' => 'false']);
              }
            }

        }
        else
        {
            $deleted = DB::table('articles_deleted')->where('id_article', $article->id_article)->first();
            $article->id = $deleted->id_article;

            $new->id = $deleted->id_article;
            $new->title = $article->title;
            $new->description = $article->description;
            $new->department_id = $article->department_id;
            $new->id_user = $article->id_user;
            $new->updated_by = $article->updated_by;
            $new->created_at = $article->created_at;
            $timestamp = now();
            $new->updated_at = $timestamp;
            $new->allowed = true;
            $new->save();

            Version::addVersion($new, 0);

            $version = Version::all()->last();
            $docs = DB::table('documents')->where('article_version', $id)->get();
            if($docs != null)
            {
              foreach ($docs as $doc) {

            //      if(DB::table('documents')->where('id', $doc->id)->value('deleted'))
          //          DB::table('documents')->where('id', $doc->id)->update(['deleted' => 'false']);

                  DB::table('documents')->insert(['article_id' => $doc->article_id, 'filename'=> $doc->filename,'article_version' => $version->id, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'deleted' => 'false']);
              }
            }

            //Aqui controlar los docs de los articulos eliminados

            DB::table('articles_deleted')->where('id', $deleted->id)->delete();
        }
        return back();
    }

    public function destroy($id)
    {
        $version = Version::find($id);

  //      $documents = DB::table('documents')->where('article_version', $id)->delete();
        //Eliminar los documentos asociados a esa version

        $version->delete();

        return back();
    }
}
