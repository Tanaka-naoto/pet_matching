<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image_url',
        'sex',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pets() {

        return $this->hasMany('App\Models\Pet');
    }

    public function want() {

        return $this->hasMany('App\Models\Want');
    }

    //リアクションリレーション
    public function ToUser() {

        return $this->hasMany('App\Models\Reaction', 'to_user_id', 'id');
    }

    public function FromUser() {

        return $this->hasMany('App\Models\Reaction', 'from_user_id', 'id');
    }

    public function chatMessages()
    {
        return $this->hasMany('App\ChatMessage');
    }

    public function chatRoomUsers()
    {
        return $this->hasMany('App\ChatRoomUsers');
    }
}
