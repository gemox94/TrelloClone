<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function admin(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function users(){
        return $this->belongsToMany('App\User', 'user_teams', 'team_id', 'user_id');
    }

    public function projects(){
        return $this->hasMany('App\Project', 'project_id', 'id');
    }
}
