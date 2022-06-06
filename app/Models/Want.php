<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Want extends Model
{
    use HasFactory;

    public function user() {

        return $this->belongsTo('App\Models\User');
    }

    public function pet() {

        return $this->belongsTo('App\Models\Pet');
    }

    public function reaction() {

        return $this->hasMany('App\Models\Reaction' ,'from_user_id', 'user_id');
    }
}
