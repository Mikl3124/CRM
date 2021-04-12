<?php

namespace App\Models;

use Laravel\Cashier\Billable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
  use Notifiable;
  use Billable;

  protected $guarded = [];
  public $timestamps = true;

  public function customers()
  {
    return $this->hasMany('Customer');
  }
}
