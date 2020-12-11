<?php
namespace App\Modules\Wallet\Extenders;

use App\Core\Components\Sidebar\SidebarRegistration;
use SidebarItem;

class SidebarGenerator extends SidebarRegistration
{
	public function handle(){
		// generate sidebar for core menus
		$this->registerSidebars([
			SidebarItem::setName('ADMIN.Wallet')
				->setLabel(__('wallet::module.menu.wallet'))
				->setRoute('admin.wallet.index')
				->setIcon('database')
				->setSortNo(5)
				->setActiveKey('wallet'),
			SidebarItem::setName('ADMIN.Wallet.RECORD')
				->setLabel(__('wallet::module.menu.wallet_record'))
				->setRoute('admin.wallet-record.index')
				->setIcon('paperclip')
				->setSortNo(6)
				->setActiveKey('wallet-record'),
			SidebarItem::setName('ADMIN.Wallet.TRANSACTION')
				->setLabel('Transaction History')
				->setRoute('admin.wallet-record.transaction')
				->setIcon('dollar-sign')
				->setSortNo(7)
				->setActiveKey('wallet-transaction'),
			SidebarItem::setName('ADMIN.Wallet.REPORT')
				->setLabel('Dashboard Report')
				->setRoute('admin.wallet-record.report')
				->setIcon('pie-chart')
				->setSortNo(1)
				->setActiveKey('wallet-report'),
		]);
	}
}