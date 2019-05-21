<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Email;
use App\User;
use App\Article;
use App\Version;
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
        if($article->created_at == $article->updated_at)//si ha sido creado
        {
            Version::addVersion($article, 1);
            $user = User::find($article->id_user)->first();

            $documents = DB::table('documents')->where('article_id', $id)->get();
            if($documents != NULL)
            {
              $version = DB::table('versions')->where('id_article', $id)->first();
              foreach ($documents as $doc) {
                DB::table('documents')->where('id', $doc->id)->update(['article_version' => $version->id]);
              }
            }
            Mail::raw("El artículo: ". $article->title. " ha sido permitido". $user->email, function ($message) use ($article, $user){
                $message->from('tecnophonepw@gmail.com', 'Administración WikiSaica');
                $message->to($user->email);
                $message->subject('Articulo: '. $article->title. " permitido");
            });
        }
        else {
            Version::addVersion($article, 0);
            $user = User::find($article->updated_by);

            $documents = DB::table('documents')->where([['article_id', $id],['article_version', null],])->get();
            if($documents != NULL)
            {
              $version = DB::table('versions')->where('id_article', $id)->orderBy('updated_at', 'desc')->first();
              foreach ($documents as $doc) {
                DB::table('documents')->where('id', $doc->id)->update(['article_version' => $version->id]);
              }
            }

            Mail::raw("El artículo: ". $article->title. " ha sido permitido", function ($message) use ($article, $user){
                $message->from('tecnophonepw@gmail.com', 'Administración WikiSaica');
                $message->to($user->email);
                $message->subject('Articulo: '. $article->title. " permitido");
            });
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

        $documents = DB::table('documents')->where([['article_id', $id],['article_version', null],])->pluck('filename');

        if($article->created_at == $article->updated_at)
        {
            if($documents != NULL)
            {
                foreach($documents as $document)
                {
                  //  unlink(storage_path('app/documents/'.$document));
                    DB::table('documents')->where([['article_id', $id],['article_version', null],])->delete();
                }
            }

            $article->delete();
        }

        else{
            $new = new Article;
            $restaurado = DB::table('versions')->where('id_article', $article->id)->orderBy('updated_at','desc')->first(); //version
            $article->delete();

            $documents = DB::table('documents')->where([['article_id', $id],['article_version', null],])->pluck('filename');
            if($documents != NULL)
            {
                foreach($documents as $document)
                {
                  //  unlink(storage_path('app/documents/'.$document));
                    DB::table('documents')->where([['article_id', $id],['article_version', null],])->delete();
                }
            }

            $new->title = $restaurado->title;
            $new->description = $restaurado->description;
            $new->id = $restaurado->id_article;
            $new->department_id = $restaurado->department_id;
            $new->id_user = $restaurado->id_user;
            $new->updated_by = $restaurado->updated_by;
            $new->created_at = $restaurado->created_at;
            $new->updated_at = $restaurado->updated_at;
            $new->allowed = true;
            $new->save();
        }


        return redirect('/articles')->with('success', 'Artículo borrado');
    }

}
