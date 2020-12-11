<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Artisan;
use App\Modules\Wallet\Models\Wallet;
use App\Core\Models\User;

class GenerateDefaultWallet extends Command
{

    protected $signature = 'generate:wallet';
    protected $description = 'Generate default wallet data';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(){
        $ask = $this->ask('This action will generate default wallet for every user in this app. Are you sure you wanna continue? [Y/N]');
        if(!in_array(strtolower($ask), ['y', 'ya', 'yes'])){
            return;
        }

        $defaults = [
            [
                'title' => 'Cash',
                'category' => 'liquid',
                'wallet_type' => 'credit',
                'sort_no' => 1,
                'is_active' => 1
            ],[
                'title' => 'Rekening ATM',
                'category' => 'liquid',
                'wallet_type' => 'credit',
                'sort_no' => 2,
                'is_active' => 1
            ],[
                'title' => 'OVO',
                'category' => 'liquid',
                'wallet_type' => 'credit',
                'sort_no' => 3,
                'is_active' => 1
            ],[
                'title' => 'GO-PAY',
                'category' => 'liquid',
                'wallet_type' => 'credit',
                'sort_no' => 4,
                'is_active' => 1
            ],[
                'title' => 'Reksadana',
                'category' => 'investasi',
                'wallet_type' => 'credit',
                'sort_no' => 21,
                'is_active' => 1
            ],[
                'title' => 'Deposito',
                'category' => 'investasi',
                'wallet_type' => 'credit',
                'sort_no' => 22,
                'is_active' => 1
            ],[
                'title' => 'Saham',
                'category' => 'investasi',
                'wallet_type' => 'credit',
                'sort_no' => 23,
                'is_active' => 1
            ],[
                'title' => 'Lainnya',
                'category' => 'lainnya',
                'wallet_type' => 'credit',
                'sort_no' => 99,
                'is_active' => 1
            ],            
        ];
        
        $users = User::get(['id', 'name']);
        foreach($users as $user){
            $users_wallet = Wallet::where('user_id', $user->id)->get(['id', 'title']);
            foreach($defaults as $wallet_data){
                if($users_wallet->where('title', $wallet_data['title'])->count() > 0){
                    //sudah ada, skip
                    continue;
                }
                $wall = new Wallet;
                $wall->user_id = $user->id;
                foreach($wallet_data as $fld => $val){
                    $wall->{$fld} = $val;
                }
                $wall->save();
                $this->info('Create new wallet data "'.$wallet_data['title'].'" for ' . $user->name);
            }
        }

    } 
}
