<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

use App\Articles_deleted;
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
        $title = "Artículos";
        return view('articles.index', compact('articles', 'user','title'));
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

        $documents = $request->documents;
        if($documents != NULL) {
            foreach($documents as $document){
                $filename = $document->getClientOriginalName();
                $document->storeAs('documents', $filename);

              DB::table('documents')->insert(['article_id' => $article->id, 'filename'=> $filename, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'deleted' => 'false']);
            }
        }
        return redirect('/articles')->with('success', 'Artículo añadido con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //Mostrar la ultima version del articulo con ese id
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
            $version = DB::table('versions')->where('id_article', $id)->orderBy('updated_at','desc')->first();

            $documents = null;
            if($version != null)
              $documents = DB::table('documents')->where([['article_id', '=', $id], ['article_version', '=', $version->id]])->pluck('filename');

            $isVersion = 0;
            return view('articles.show_article', compact('article', 'user', 'userUpdate', 'department','documents', 'version', 'isVersion'));
        }
        else
            return redirect('');
    }

    public function getFile($filename)
    {
        $pathToFile = storage_path('app/documents/'.$filename);
        return response()->download($pathToFile, null, [], null);
    }

    /**
     *
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteFile($id)
    {
          DB::table('documents')->where('id', '=', $id)->update(['deleted' => 'true']);

        /*  return response()->json([
            'success' => 'File deleted successfully!'
          ]); */
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
        $version =  DB::table('versions')->where('id_article', $id)->orderBy('updated_at', 'desc')->first();
        $documents = DB::table('documents')->where([['article_id', $id],['article_version', $version->id],])->get();
        return view('articles.edit', compact('article','documents'));
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

      $newDocuments = $request->documents;
      if($newDocuments != NULL) {
          foreach($newDocuments as $document){
              $filename = $document->getClientOriginalName();
              $document->storeAs('documents', $filename);

              DB::table('documents')->insert(['article_id' => $article->id, 'filename'=> $filename, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'deleted' => 'false']);
          }
      }

      //Miro si ya tenia docs asociados a la version de ese Articulo
      $version = DB::table('versions')->where('id_article', $id)->orderBy('updated_at', 'desc')->first();
      $actualDocuments = DB::table('documents')->where([['article_version', $version->id],['deleted', 'false'],])->get();
      if($actualDocuments != NULL)
      {
        foreach($actualDocuments as $documents){
            DB::table('documents')->insert(['article_id' => $article->id, 'filename'=> $documents->filename, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]);
        }
      }

      return redirect('/articles')->with('success', 'Artículo actualizado');
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

        Articles_deleted::addDeleteArticle($article);

    /*    $documents = DB::table('documents')->where('article_id', $id)->pluck('filename');

        if($documents != NULL)
        {
            foreach($documents as $document)
            {
             //unlink(storage_path('app/documents/'.$document));
             DB::table('documents')->where('article_id', '=', $id)->delete();
            }
        } */

        $article->delete();

        return redirect('/articles')->with('success', 'Artículo borrado');
    }
}
