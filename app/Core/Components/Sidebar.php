<?php
namespace App\Core\Components;

class Sidebar
{
	public $data = [];
	public $structured = [];

	public function __construct(){
		$this->loadSidebarRegistrations();
		$this->generateStructuredSidebar();
	}

	public function all(){
		return $this->data;
	}

	public function generate(){
		return $this->structured;
	}

	public function fallbackSelectedMenu(){
		return 'homepage';
	}


	public function loadSidebarRegistrations(){
		$reg_suffix = 'Extenders\\SidebarGenerator';
		$lists = config('modules.load');
		if(empty($lists)){
			$lists = [];
		}

		$lists = array_map(function($item) use($reg_suffix){
			$split = explode('Providers\\', $item);
			return $split[0] . $reg_suffix;
		}, $lists);
		$lists = array_merge(['\\App\\Core\\' . $reg_suffix], $lists);

		//load class lists
		foreach($lists as $class_name){
			if(!class_exists($class_name)){
				continue;
			}
			$generator = app($class_name);
			foreach($generator->output() as $group_key => $sidebar){
				$this->data[$sidebar->getName()] = $sidebar;
			}
		}
	}

	public function generateStructuredSidebar(){
		$output = [];
		$collection = collect($this->data);
		$first_level = $collection->filter(function($item){
			return empty($item->getParent());
		})->sortBy(function($item){
			return $item->getSortNo();
		});

		// MOHON MAAF SEPERTI BIASA SAYA LEMAH DI FUNGSI RECURSIVE :(
		// JADI PAKE TAB2 KAMEHAMEHA DULU YA
		foreach($first_level as $group_key => $group_value){
			#level 0
			$output[$group_key] = $group_value;

			$grab = $collection->filter(function($item) use($group_key){
				return $item->getParent() == $group_key;
			})->sortBy(function($item){
				return $item->getSortNo();
			});


			if($grab->count() > 0){
				foreach($grab as $kn => $kv){
					#level 1
					$output[$group_key]->addChildren($kn, $kv);

					$grab = $collection->filter(function($item) use($kn){
						return $item->getParent() == $kn;
					})->sortBy(function($item){
						return $item->getSortNo();
					});
					if($grab->count() > 0){
						foreach($grab as $kkn => $kkv){
							#level 2
							$kv->addChildren($kkn, $kkv);

							$grab = $collection->filter(function($item) use($kkn){
								return $item->getParent() == $kkn;
							})->sortBy(function($item){
								return $item->getSortNo();
							});
							if($grab->count() > 0){
								foreach($grab as $kkkn => $kkkv){
									#level 3
									$kkv->addChildren($kkkn, $kkkv);

									$grab = $collection->filter(function($item) use($kkkn){
										return $item->getParent() == $kkkn;
									})->sortBy(function($item){
										return $item->getSortNo();
									});
									if($grab->count() > 0){
										foreach($grab as $kkkkn => $kkkkv){
											#level 4
											$kkkv->addChildren($kkkkn, $kkkkv);
											#MAAF LIMITNYA CUMA SAMPAI LEVEL 4 DULU YA..
											#MINTA TOLONG DIUBAH KE RECURSIVE BIAR LEBIH CANTIK
										}
									}
									
								}
							}
						}
					}
				}
			}
		}
		$this->structured = $output;
	}




}