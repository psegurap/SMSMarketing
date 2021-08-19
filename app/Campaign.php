<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use SoftDeletes;
    
    protected $table = 'campaigns';
    protected $guarded = [];
    protected $dates = ['deleted_at'];
}
