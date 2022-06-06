<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    public function user() {

        return $this->belongsTo('App\Models\User');
    }

    public function wants() {

        return $this->hasMany('App\Models\Want');
    }

    //リアクションテーブルに入るpet_id
    public function users() {

        return $this->hasMany('App\Models\Reaction', 'pet_id', 'id');
    }

    public function ToUser() {

                                                    //相手のカラム　自分のカラム
        return $this->hasMany('App\Models\Reaction', 'to_user_id', 'user_id');
    }


    public function room() {
        return $this->belongsTo('App\Models\ChatRoom', 'chat_room_id', 'id');
    }

    public function chat_messages() {

        return $this->hasMany('App\Models\ChatMessage',  'chat_room_id', 'chat_room_id');
    }
 }


