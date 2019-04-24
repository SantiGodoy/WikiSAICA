<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
   protected $fillable = [
	'article_title',
	'article_description',
	'article_allowed'
  ];

  public static function getArticle($department_id)
    {
		$article = DB::table('articles')->where('department_id', $department_id)->orderBy('created_at', 'desc')->first();
		return $article;
    }
}
