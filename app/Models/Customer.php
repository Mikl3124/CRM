<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

  protected $guarded = [];
  public $timestamps = true;

  public function project()
  {
    return $this->hasMany('Project', 'project_id');
  }

  public function payments()
  {
    return $this->hasMany('Payment');
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
