<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;
    
    protected $table = 'properties';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function getCreatedAtAttribute($date) {
        return date('Y-m-d H:i:s', strtotime($date));
    }

    public function getUpdatedAtAttribute($date) {
        return date('Y-m-d H:i:s', strtotime($date));
    }
}
