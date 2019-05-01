<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
   protected $fillable = [
	'article_title',
	'article_description',
	'article_allowed',
	'article_updated_by',
	'article_department_id'
  ];

  public static function getArticle($department_id)
    {
		$article = DB::table('articles')->where('department_id', $department_id)->where('allowed', 'true')->orderBy('created_at', 'desc')->first();
		return $article;
    }

    public static function getOwner($article)
    {
    	$user = DB::table('users')->where('id', $article->id_user)->first();
    	return $user;
		}
		
		public static function getModifier($article)
    {
    	$user = DB::table('users')->where('id', $article->updated_by)->first();
    	return $user;
    }
}
