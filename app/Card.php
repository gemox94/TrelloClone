<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    public function admin(){
        return $this->belongsTo('App\User', 'admin_id', 'id');
    }

    public function board(){
        return $this->belongsTo('App\Board', 'board_id', 'id');
    }
}
