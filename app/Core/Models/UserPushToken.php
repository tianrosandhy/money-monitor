<?php
namespace App\Core\Models;

use Illuminate\Database\Eloquent\Model;

class UserPushToken extends Model
{
    public function user(){
        return $this->belongsTo('App\Core\Models\User', 'user_id');
    }
}
