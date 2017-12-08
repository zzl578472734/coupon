<?php

namespace App\Http\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    public $timestamps = true;

    protected $fillable = [
      'username', 'email', 'password'
    ];

    protected $hidden = [
        'password'
    ];
}
