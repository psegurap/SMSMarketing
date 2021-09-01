<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Contact extends Model
{
    
    use SoftDeletes;
    
    protected $table = 'contacts';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function properties(){
        return $this->hasMany('App\Property', 'contact_id', 'id');   
    }

    public function mail_addresses(){
        return $this->hasMany('App\MailAddress', 'contact_id', 'id');   
    }

    public function conversations(){
        return $this->hasMany('App\Conversation', 'contact_id', 'id');   
    }


    public function getCreatedAtAttribute($date) {
        return date('Y-m-d H:i:s', strtotime($date));
    }

    public function getUpdatedAtAttribute($date) {
        return date('Y-m-d H:i:s', strtotime($date));
    }
   
}
