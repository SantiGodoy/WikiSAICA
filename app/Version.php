<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    protected $fillable = [
        'title',
        'description',
        'id_article',
        'department_id',
        'id_user',
        'updated_by',
        'last_action',
        'created_at',
        'updated_at'
      ];

      public static function addVersion($article, $new)
      {
          $version = new Version;
          $version->title = $article->title;
          $version->description = $article->description;
          $version->id_article = $article->id; //MIRAR
          $version->department_id = $article->department_id;
          $version->id_user = $article->id_user;
          $version->updated_by = $article->updated_by;
          $version->created_at = $article->created_at;
          $version->updated_at = $article->updated_at;
          if($new)
          {
            $version->last_action = "Creación";
          }
          else{
            $version->last_action = "Actualización";
          }
          $version->save();
      }

public static function addDeleteVersion($article)
{
	  $version = new Version;
          $version->title = $article->title;
          $version->description = $article->description;
          $version->id_article = $article->id;
          $version->department_id = $article->department_id;
          $version->id_user = $article->id_user;
          $version->updated_by = $article->updated_by;
          $version->created_at = $article->created_at;
          $version->updated_at = $article->updated_at;

	  $version->last_action = "Borrado";

	$version->save();
}

}
