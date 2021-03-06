<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'article_tag');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function delete()
    {
        if(file_exists('public/images/articles')){
            @unlink(public_path('public/images/articles'));
        }
        parent::delete();
    }
}
