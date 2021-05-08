<?php

namespace App\Models;

use App\Models\File;
use App\Models\User;
use App\Models\Quote;
use App\Models\Project;
use App\Models\Interaction;
use Laravel\Cashier\Billable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  use Billable;

  protected $guarded = [];
  public $timestamps = true;

  public function project()
  {
    return $this->hasMany(Project::class);
  }

  public function quotes()
  {
    return $this->hasMany(Quote::class);
  }

  public function payments()
  {
    return $this->hasMany('Payment');
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function files()
  {
    return $this->hasMany(File::class);
  }

  public function interactions()
  {
    return $this->hasMany(Interaction::class);
  }
}
