<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class twoFA extends Model
{
    protected $fillable = ['code', 'status'];
}
