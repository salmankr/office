<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'address', 'city', 'country_id', 'state_id', 'encrypted_key', 'api_key',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function country(){
        return $this->belongsTo('App\models\userdata\country','country_id');
    }

    public function state(){
        return $this->belongsTo('App\models\userdata\state','state_id');
    }

    public static function APIsave($apiKey){
        $user = Auth::user();
        $user->forceFill([
            'api_key' => Hash::make($apiKey),
        ])->save();
        return true;
    }

    public static function passwordSave($password){
        $user = Auth::user();
        User::where('id', $user->id)->update(['password' => Hash::make($password)]);
    }
}
