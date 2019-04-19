<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
   protected $fillable = [
	'article_title',
	'article_description',
	'article_allowed'
  ];
}
