<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use SoftDeletes;
    
    protected $table = 'conversations';
    protected $guarded = [];
    protected $dates = ['deleted_at'];
}
