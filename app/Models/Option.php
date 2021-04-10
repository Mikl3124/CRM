<?php

namespace App\Models;

use App\Models\Quote;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{

  protected $guarded = [];
  public $timestamps = true;

  public function quote()
  {
    return $this->belongsTo(Quote::class);
  }
}
