<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'pet_id',
        // 'is_like',

    ];

    public function toUser() {

        return $this->belongsTo('App\Models\User', 'to_user_id', 'id');
    }

    public function fromUser() {

        return $this->belongsTo('App\Models\User', 'from_user_id', 'id');
    }

    public function pets() {

        return $this->belongsTo('App\Models\Pet', 'pet_id', 'id');
    }

    public function ToPetUser() {
                                                //自分のカラム　相手のカラム
        return $this->belongsTo('App\Models\Pet', 'to_user_id', 'user_id');
    }

    public function want() {
                                                //自分のカラム　相手のカラム
        return $this->belongsTo('App\Models\Want', 'from_user_id', 'user_id');
    }
}
