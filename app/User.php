<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public function role(){
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    public function teams_owner(){
        return $this->hasMany('App\Team', 'admin_id', 'id');
    }

    public function teams(){
        return $this->belongsToMany('App\Team', 'user_teams', 'user_id', 'team_id');
    }

    public function projects(){
        return $this->hasMany('App\Project', 'admin_id', 'id');
    }

    public function boards(){
        return $this->hasMany('App\Board', 'admin_id', 'id');
    }

    public function cards(){
        return $this->hasMany('App\Card', 'admin_id', 'id');
    }
}
