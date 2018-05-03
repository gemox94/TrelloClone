<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    public function admin(){
        return $this->belongsTo('App\User', 'admin_id', 'id');
    }

    public function project(){
        return $this->belongsTo('App\Project', 'project_id', 'id');
    }

    public function cards(){
        return $this->hasMany('App\Card', 'board_id', 'id');
    }
}
