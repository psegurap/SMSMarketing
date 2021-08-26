<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailAddress extends Model
{
    use SoftDeletes;
    
    protected $table = 'mail_address';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function getCreatedAtAttribute($date) {
        return date('Y-m-d H:i:s', strtotime($date));
    }

    public function getUpdatedAtAttribute($date) {
        return date('Y-m-d H:i:s', strtotime($date));
    }
}
