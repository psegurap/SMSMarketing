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

    public function contact(){
        return $this->hasMany('App\MailAddress', 'contact_id', 'id');   
    }

    public function getCreatedAtAttribute($date) {
        return date('Y-m-d', strtotime($date));
    }
}
