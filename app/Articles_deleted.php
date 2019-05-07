<?php

namespace App;
use Illuminate\Support\Facades\DB;
use App\Version;
use Illuminate\Database\Eloquent\Model;

class Articles_deleted extends Model
{
    protected $fillable = [
        'title',
        'description',
        'department_id',
        'id_user',
        'updated_by',
        'created_at',
        'updated_at'
      ];

      public static function addDeleteArticle($article)
      {

          DB::table('articles_deleted')->insert(
            ['title' => $article->title,
            'description' => $article->description,
            'department_id' => $article->department_id,
            'id_user' => $article->id_user,
            'updated_by' => $article->updated_by,
            'created_at' => $article->created_at,
            'updated_at' => $article->updated_at]
          );

          Version::addDeleteVersion($article);

      }
}