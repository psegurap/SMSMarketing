<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    
    use SoftDeletes;
    
    protected $table = 'contacts';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

   
}