<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AutocrudRole extends Command
{
    protected $signature = 'autocrud:role';
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        //super admin ga butuh list priviledge        
        $cek = DB::table('roles')->where('is_sa', 1);
        $save_data = [
            'name' => 'Super Admin',
            'priviledge_list' => null,
            'is_sa' => 1
        ];
        if($cek->count() == 0){
            DB::table('roles')->insert($save_data);
        }
        else{
            $cek->update($save_data);
        }

        //generate normal admin data kalau kosong
        $normal = DB::table('roles')->whereNull('is_sa')->first();
        if(empty($normal)){
            DB::table('roles')->insert([
                'name' => 'Admin',
                'priviledge_list' => null
            ]);
        }
    }
}
