<?php

namespace App\Models;

use App\Models\Option;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

  protected $guarded = [];
  public $timestamps = true;

  public function options()
  {
    return $this->hasMany(Option::class);
  }

  public function customer()
  {
    return $this->belongsTo(Customer::class);
  }

  public function quotes()
  {
    return $this->hasMany(Quote::class);
  }
}
