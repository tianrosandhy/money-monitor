<?php
namespace App\Modules\Wallet\Services;

use App\Core\Exceptions\InstanceException;
use App\Core\Services\BaseInstance;
use App\Modules\Wallet\Models\Wallet;
use App\Modules\Wallet\Models\WalletRecord;

class WalletInstance extends BaseInstance
{
	public function __construct(){
		parent::__construct(new Wallet);
	}

	public function getTotal($list_wallet = [], $date=null){
		if(empty($list_wallet)){
			$list_wallet = $this->listWallets($date);
		}
		$data = [
			'total' => 0
		];
		foreach($list_wallet as $cat => $wallets){
			foreach($wallets as $wallet){
				if($wallet['wallet_type'] == 'credit'){
					if(isset($data['category'][$cat])){
						$data['category'][$cat] += $wallet['balance'];
					}
					else{
						$data['category'][$cat] = $wallet['balance'];
					}
					$data['total'] += $wallet['balance'];
				}
				else{
					if(isset($data['category'][$cat])){
						$data['category'][$cat] -= $wallet['balance'];
					}
					else{
						$data['category'][$cat] = $wallet['balance'] * -1;
					}
					$data['total'] -= $wallet['balance'];
				}
			}
		}
		return $data;
	}

	public function listWallets($date=null){
		$wallets = Wallet::where('user_id', $this->request->get('user')->id)
			->where('is_active', 1)
			->orderBy('sort_no', 'ASC')
			->get();

		if(empty($date)){
			$date = date('Y-m-d');
		}
		return $this->generateWalletBalance($wallets, $date);
	}

	public function generateWalletBalance($wallets, $date=null){
		if(empty($date)){
			$date = date('Y-m-d');
		}

		$data = [];
		foreach($wallets as $wallet){
			$temp = $wallet->toArray();
			$temp['balance'] = $this->getWalletBalance($wallet, $date);

			$data[$wallet->category][] = $temp;
		}
		return $data;
	}

	public function getWalletBalance($wallet_instance, $date){
		$grab = WalletRecord::where('wallet_id', $wallet_instance->id)
			->where('tanggal', '<=', $date)
			->orderBy('tanggal', 'DESC')
			->first();
		
		return $grab->nominal ?? 0;
	}

	public function addRecord($param){
		$wr = WalletRecord::where('user_id', $param['user_id'])
			->where('wallet_id', $param['wallet_id'])
			->where('tanggal', $param['tanggal'])
			->first();
		
		if(empty($wr)){
			$wr = new WalletRecord;
			$wr->user_id = $param['user_id'];
			$wr->wallet_id = $param['wallet_id'];
			$wr->tanggal = $param['tanggal'];
		}

		$wr->nominal = $param['nominal'] ?? null;
		$wr->save();

		return $wr;
	}

	public function generateReport($start_date, $end_date){
		$initial_wallet_data = $this->listWallets($start_date);
		$raw_records = WalletRecord::where('user_id', $this->request->get('user')->id)
			->whereBetween('tanggal', [$start_date.' 00:00:00' , $end_date.' 23:59:59'])
			->get();

		if(strtotime($end_date) - strtotime($start_date) > 3 * 30 * 86400){
			//mode bulan
			$month = date('Y-m-01', strtotime($start_date));
			$end = date('Y-m-t', strtotime($end_date));
			while(strtotime($month) < strtotime($end)){
				$daterange[] = strtotime(date('Y-m-t', strtotime($month)));
				$month = date('Y-m-d', strtotime($month . '+1 month'));
			}
			$key_format = 'M Y';
		}
		else{
			$daterange = range(strtotime($start_date), strtotime($end_date), 86400);
			$key_format = 'd M';
		}

		$final = [];
		$temp = [];
		$category = [];


		foreach($daterange as $dateint){
			$current_report_data = $initial_wallet_data;

			$current_total = 0;
			foreach($initial_wallet_data as $cat => $wallets){
				foreach($wallets as $indexwallet => $wall){
					$rec = $raw_records
						->where('tanggal', '<=', date('Y-m-d', $dateint))
						->where('wallet_id', $wall['id'])
						->sortByDesc('tanggal')
						->first();
					
					$nominal = $rec->nominal ?? $wall['balance'];
					if(!empty($rec)){
						$initial_wallet_data[$cat][$indexwallet]['balance'] = $nominal;
					}
					$temp[$wall['id']][date($key_format, $dateint)] = $nominal;

					if(isset($category[$wall['category']][date($key_format, $dateint)])){
						if($wall['wallet_type'] == 'credit'){
							$category[$wall['category']][date($key_format, $dateint)] += $nominal;
						}
						else{
							$category[$wall['category']][date($key_format, $dateint)] -= $nominal;
						}
					}
					else{
						if($wall['wallet_type'] == 'credit'){
							$category[$wall['category']][date($key_format, $dateint)] = $nominal;
						}
						else{
							$category[$wall['category']][date($key_format, $dateint)] = $nominal;
						}
					}

					if($wall['wallet_type'] == 'credit'){
						$current_total += $nominal;
					}
					else{
						$current_total -= $nominal;
					}
				}
			}
			$final[date($key_format, $dateint)] = $current_total;	
		}

		return [
			'total_report' => $final,
			'category_report' => $category,
			'wallet_report' => $temp,
		];
	}

	public function getTransactions($config=[]){
		$wallets = $config['wallets'] ?? [];
		$periode = $config['periode'] ?? [];

		$total_transactions = WalletRecord::where("user_id", $this->request->get('user')->id);
		if(is_array($wallets) && !empty($wallets)){
			$total_transactions = $total_transactions->whereIn('wallet_id', $wallets);
		}
		if(isset($periode[0]) || isset($periode[1])){
			if(isset($periode[0])){
				$total_transactions = $total_transactions->where('tanggal', '>=', date('Y-m-d', strtotime($periode[0])));
			}
			if(isset($periode[1])){
				$total_transactions = $total_transactions->where('tanggal', '<=', date('Y-m-d', strtotime($periode[1])));
			}
		}

		$total_transactions_count = $total_transactions->count();

		$per_page = $config['per_page'] ?? 20;
		if($per_page < 5){
			$per_page = 5;
		}
		if($per_page > 100){
			$per_page = 100;
		}

		$max_page = ceil($total_transactions_count / $per_page);
		
		$page = $config['page'] ?? 1;
		if($page < 1){
			$page = 1;
		}
		if($page > $max_page){
			$page = $max_page;
		}
		$offset = ($page - 1) * $per_page;
		$grab_transaction = $total_transactions->orderBy('tanggal', 'DESC')->skip($offset)->take($per_page)->get();
		return [
			'page' => $page,
			'per_page' => $per_page,
			'total_page' => intval($max_page),
			'total_data' => $total_transactions_count,
			'has_prev_page' => $page > 1,
			'has_next_page' => $page < $max_page,
			'data' => $grab_transaction,
		];
	}
}