<?php
namespace App\Modules\Wallet\Models;

use Illuminate\Database\Eloquent\Model;

class WalletRecord extends Model
{
	public function wallet(){
		return $this->belongsTo('App\Modules\Wallet\Models\Wallet', 'wallet_id');
	}
}
