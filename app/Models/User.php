<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
  use Notifiable;

  protected $guarded = [];
  public $timestamps = true;

  public function customers()
  {
    return $this->hasMany('Customer');
  }
}
