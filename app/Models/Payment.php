<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

  protected $guarded = [];
  public $timestamps = true;

  public function user()
  {
    return $this->belongsTo(Customer::class);
  }
}
