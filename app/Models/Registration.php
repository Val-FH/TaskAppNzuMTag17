<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Registration extends Model
{
    protected $fillable = ['name', 'email', 'password'];
}
