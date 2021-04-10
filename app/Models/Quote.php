<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;

class Quote extends Model implements Viewable
{
  use InteractsWithViews;

  protected $guarded = [];
  public $timestamps = true;

  public function project()
  {
    return $this->belongsTo(Project::class);
  }
}
