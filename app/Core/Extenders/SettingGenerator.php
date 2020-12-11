<?php
namespace App\Core\Extenders;

use App\Core\Components\Setting\SettingRegistration;
use App\Core\Components\Setting\SettingItem;

class SettingGenerator extends SettingRegistration
{
	public function handle(){
		$this->addSettingGroup('general', [
			new SettingItem('title', 'Site Title', 'text', [
				'placeholder' => "Your Site Title",
				'required' => 'required'
			]),
			new SettingItem('description', 'Site Description', 'textarea'),
			new SettingItem('favicon', 'Site Favicon', 'image', [
				'accept' => 'image/*'
			]),
			new SettingItem('logo', 'Site Logo', 'image', [
				'accept' => 'image/*'
			]),

		], 1);

		$this->addSettingGroup('log', [
			new SettingItem('active', 'Log Service', 'yesno'),
			// new SettingItem('email_receiver', 'Log Email Receiver', 'text')
		], 3);

	}

}