<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Artisan;
use App\Modules\Wallet\Models\Wallet;
use App\Modules\Wallet\Models\WalletRecord;
use App\Core\Models\User;

class GenerateDummyWalletRecord extends Command
{

    protected $signature = 'generate:dummy-record';
    protected $description = 'Generate dummy wallet record';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(){
        $month_count = $this->ask('This command will generate dummy wallet record in default wallets only. Please type how many data that you want to create in month count (1-24) : ');
        while(intval($month_count) == 0 || intval($month_count) > 24){
            $this->error('Please insert values between 1-24 only');
            $month_count = $this->ask('This command will generate dummy wallet record in default wallets only. Please type how many data that you want to create in month count (1-24) : ');
        }

        $this->info('Please wait, we will generate dummy data for ' . $month_count . ' months from now');
        $this->months = $month_count;
        $this->generateDummyData();
    }

    protected function generateDummyData(){
        $this->start_date = date('Y-m-d', strtotime('-' . $this->months.' months'));
        $this->end_date = date('Y-m-d', strtotime('-1 day'));
        $this->generateDateRange();

        $users = User::get(['id', 'name']);
        foreach($users as $user){
            $wallets = Wallet::where('user_id', $user->id)->get(['id', 'title']);
            foreach($wallets as $row){
                $this->clearOldWalletRecord($row);

                $ttl = strtolower($row->title);
                if($ttl == 'cash'){
                    $this->generateCashDummyData($row, $user);
                }
                else if($ttl == 'rekening atm'){
                    $this->generateAtmDummyData($row, $user);
                }
                else if( in_array($ttl, ['ovo', 'go-pay', 'gopay', 'shopeepay', 'dana', 'linkaja']) ){
                    $this->generateEmoneyDummyData($row, $user);
                }
                else if($ttl == 'deposito' || $ttl == 'reksadana'){
                    $this->generateDepositoDummyData($row, $user);
                }
                else if($ttl == 'saham'){
                    $this->generateSahamDummyData($row, $user);
                }
                else{
                    $this->generateRandomDummyData($row, $user);
                }
            }
        }
    }

    protected function generateDateRange(){
        $this->daily_range = [];
        $this->weekly_range = [];
        $this->monthly_range = [];

        //daily range
        $this->daily_range = range(strtotime($this->start_date), strtotime($this->end_date), 86400);

        //weekly range
        $week = date('Y-m-d', strtotime($this->start_date));
        $end = date('Y-m-d', strtotime($this->end_date));
        while(strtotime($week) < strtotime($end)){
            $this->weekly_range[] = strtotime(date('Y-m-d', strtotime($week)));
            $week = date('Y-m-d', strtotime($week . '+'.rand(2,8).' days'));
        }

        //monthly range
        $month = date('Y-m-d', strtotime($this->start_date));
        $end = date('Y-m-d', strtotime($this->end_date));
        while(strtotime($month) < strtotime($end)){
            $this->monthly_range[] = strtotime(date('Y-m-t', strtotime($month)));
            $month = date('Y-m-d', strtotime($month . '+1 month'));
        }

    }

    protected function clearOldWalletRecord($wallet){
        WalletRecord::where('wallet_id', $wallet->id)->delete();
    }

    protected function generateCashDummyData($wallet, $user){
        $money = rand(10, 765) * 1000;
        $records = [];
        foreach($this->daily_range as $dateint){
            $date_string = date('Y-m-d', $dateint);
            $substraction = rand(1,200) * 500;

            $records[] = [
                'user_id' => $user->id,
                'wallet_id' => $wallet->id,
                'tanggal' => $date_string,
                'nominal' => $money,
            ];
            $money -= $substraction;
            if($money < 0){
                //ceritanya narik duwid kalo udh abis
                $money += rand(3,10) * 100000;
            }
        }
        
        if(!empty($records)){
            WalletRecord::insert($records);
            $this->info('Generated '.count($records).' dummy record for wallet "'.$wallet->title.'"');
        }
        else{
            $this->error('No dummy record generated for wallet "'.$wallet->title.'"');
        }
    }
    
    protected function generateAtmDummyData($wallet, $user){
        $money = rand(300, 765) * 10000;

        $records = [];
        $last_save = $money;
        foreach($this->daily_range as $dateint){
            $ceritanya_ini_gaji = rand(7500, 9000) * 1000; //kisaran 7.5jt - 9jt
            $date_string = date('Y-m-d', $dateint);
            $substraction = rand(1,20) * 50000;

            //mencegah nominal yg sama terinput lebih dari 1x
            if($last_save <> $money){
                $records[] = [
                    'user_id' => $user->id,
                    'wallet_id' => $wallet->id,
                    'tanggal' => $date_string,
                    'nominal' => $money,
                ];
                $last_save = $money;
            }

            if(rand(1,2) == 2){
                //kurangi nominalnya
                $money -= $substraction;
                if($money < 0){
                    $money = 50000; //ceritanya ini sbg nominal terkecil di bank
                }
            }

            if(date('d', $dateint) == 25){
                //ceritanya ini lagi gajian
                $money += $ceritanya_ini_gaji;
            }

        }
        
        if(!empty($records)){
            WalletRecord::insert($records);
            $this->info('Generated '.count($records).' dummy record for wallet "'.$wallet->title.'"');
        }
        else{
            $this->error('No dummy record generated for wallet "'.$wallet->title.'"');
        }
    }
    
    protected function generateEmoneyDummyData($wallet, $user){
        $this->generateDateRange(); //biar tanggal weekly yg kegenerate jd random
                
        $money = rand(100, 300) * 1000;
        $records = [];
        foreach($this->weekly_range as $dateint){
            $date_string = date('Y-m-d', $dateint);
            $substraction = rand(1,200) * 500;

            $records[] = [
                'user_id' => $user->id,
                'wallet_id' => $wallet->id,
                'tanggal' => $date_string,
                'nominal' => $money,
            ];
            $money -= $substraction;
            if($money < 0){
                //ceritanya narik duwid kalo udh abis
                $money += rand(2,5) * 100000;
            }
        }
        
        if(!empty($records)){
            WalletRecord::insert($records);
            $this->info('Generated '.count($records).' dummy record for wallet "'.$wallet->title.'"');
        }
        else{
            $this->error('No dummy record generated for wallet "'.$wallet->title.'"');
        }
    }
    
    protected function generateDepositoDummyData($wallet, $user){                
        $money = rand(1, 10) * 1000000;
        $records = [];
        foreach($this->monthly_range as $dateint){
            $date_string = date('Y-m-d', $dateint);
            $additional = 5/100 * $money; //ceritanya deposito dgn bunga 5%

            $records[] = [
                'user_id' => $user->id,
                'wallet_id' => $wallet->id,
                'tanggal' => $date_string,
                'nominal' => $money,
            ];
            $money += $additional;
        }
        
        if(!empty($records)){
            WalletRecord::insert($records);
            $this->info('Generated '.count($records).' dummy record for wallet "'.$wallet->title.'"');
        }
        else{
            $this->error('No dummy record generated for wallet "'.$wallet->title.'"');
        }
    }
    
    protected function generateSahamDummyData($wallet, $user){
        $this->generateDateRange();
        $money = rand(1, 25) * 1000000;
        $records = [];
        foreach($this->weekly_range as $dateint){
            $date_string = date('Y-m-d', $dateint);
            $changes = rand(1,1000) * 400;

            $records[] = [
                'user_id' => $user->id,
                'wallet_id' => $wallet->id,
                'tanggal' => $date_string,
                'nominal' => $money,
            ];

            //saham itu kadang2 naik, kadang2 turun
            if(rand(1, 3) == 2){
                //turun
                $money -= $changes;
            }
            else{
                //naik
                $money += $changes;
            }
            if($money < 0){
                //jadiin fix 100rb, ceritanya topup gara2 wik abis
                $money = 100000;
            }
        }
        
        if(!empty($records)){
            WalletRecord::insert($records);
            $this->info('Generated '.count($records).' dummy record for wallet "'.$wallet->title.'"');
        }
        else{
            $this->error('No dummy record generated for wallet "'.$wallet->title.'"');
        }
    }
    
    protected function generateRandomDummyData($wallet, $user){
        $this->generateDateRange();
        $money = 0;
        $batas_naik_random = ceil(count($this->weekly_range) / 4);
        $records = [];
        foreach($this->weekly_range as $dateint){
            $date_string = date('Y-m-d', $dateint);
            $changes = rand(1,1000) * 100;

            $records[] = [
                'user_id' => $user->id,
                'wallet_id' => $wallet->id,
                'tanggal' => $date_string,
                'nominal' => $money,
            ];

            if($batas_naik_random > 0){
                $money += rand(1,50) * 1000;
            }
            else{
                $money -= rand(1,50) * 1000;
            }

            if($money < 0){
                $money = 0;
            }
            $batas_naik_random--;
        }
        
        if(!empty($records)){
            WalletRecord::insert($records);
            $this->info('Generated '.count($records).' dummy record for wallet "'.$wallet->title.'"');
        }
        else{
            $this->error('No dummy record generated for wallet "'.$wallet->title.'"');
        }

    }
    
}
