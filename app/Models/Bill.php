<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{

  protected $guarded = [];
  public $timestamps = true;

  public function project()
  {
    return $this->hasOne('Project');
  }
}
