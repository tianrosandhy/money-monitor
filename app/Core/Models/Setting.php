<?php
namespace App\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    protected $fillable = [
    	'param',
    	'name',
    	'description',
    	'default_value',
    	'options',
        'group',
    	'type',
    ];

}
