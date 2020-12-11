<?php
namespace App\Modules\Wallet\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
	public function records(){
		return $this->hasMany('App\Modules\Wallet\Models\WalletRecord', 'wallet_id');
	}
}
