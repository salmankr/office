<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\userdata\state;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class userDataController extends Controller
{
    public function states($id){
    	$states = state::where('country_id', $id)->get();
    	return $states;
    }

    public function apiKeys(){
    	$apiKey = Str::random(25);
    	$user = Auth::user();
    	$user->forceFill([
            'api_key' => Hash::make($apiKey),
        ])->save();
    	return view('custom.api', compact('apiKey'));
    }

    public function localization(){
    	$user = Auth::user();
    	$this->authorize('view');
    	return redirect('/home');
    }
}
