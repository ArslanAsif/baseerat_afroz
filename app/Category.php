<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function articles()
    {
        return $this->hasMany('App\Article');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'category_id');
    }

}
