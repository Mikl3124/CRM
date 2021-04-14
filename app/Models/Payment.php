<?php

namespace App\Models;

use App\Models\Quote;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

  protected $guarded = [];
  public $timestamps = true;

  public function user()
  {
    return $this->belongsTo(Customer::class);
  }

  public function quote()
  {
    return $this->belongsTo(Quote::class);
  }
}
