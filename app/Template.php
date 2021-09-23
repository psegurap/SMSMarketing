<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends Model
{
    use SoftDeletes;
    
    protected $table = 'templates';
    protected $guarded = [];
    protected $dates = ['deleted_at'];
}
