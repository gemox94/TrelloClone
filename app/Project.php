<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function admin(){
        return $this->belongsTo('App\User', 'admin_id', 'id');
    }

    public function team(){
        return $this->belongsTo('App\Team', 'team_id', 'id');
    }

    public function boards(){
        return $this->hasMany('App\Boards', 'admin_id', 'id');
    }
}
