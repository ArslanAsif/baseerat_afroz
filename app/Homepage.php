<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Homepage extends Model
{
    public function users()
    {
        return $this->belongsTo('App\User');
    }

    public function article()
    {
        return $this->belongsTo('App\Article');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
