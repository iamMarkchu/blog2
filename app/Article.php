<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
	public static function rules ($id=0, $merge=[])
	{
		return array_merge(
			[
            	'title' => 'required|unique:articles,title'.($id?",$id" : ''),
            	'content' => 'required',
            	'display_order' => 'required|integer',
            	'category_id' => 'required|integer',
        	],
			$merge);
	}
    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'category_id' );
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'article_tags', 'article_id', 'tag_id');
    }
}
