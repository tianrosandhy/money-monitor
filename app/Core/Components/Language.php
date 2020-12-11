<?php
namespace App\Core\Components;

use App\Core\Shared\DynamicProperty;
use App\Core\Models\Language as Model;
use App;

class Language
{
	use DynamicProperty;
	
	public $lists = [
	    'ab' => 'Abkhazian',
	    'aa' => 'Afar',
	    'af' => 'Afrikaans',
	    'ak' => 'Akan',
	    'sq' => 'Albanian',
	    'am' => 'Amharic',
	    'ar' => 'Arabic',
	    'an' => 'Aragonese',
	    'hy' => 'Armenian',
	    'as' => 'Assamese',
	    'av' => 'Avaric',
	    'ae' => 'Avestan',
	    'ay' => 'Aymara',
	    'az' => 'Azerbaijani',
	    'bm' => 'Bambara',
	    'ba' => 'Bashkir',
	    'eu' => 'Basque',
	    'be' => 'Belarusian',
	    'bn' => 'Bengali',
	    'bh' => 'Bihari languages',
	    'bi' => 'Bislama',
	    'bs' => 'Bosnian',
	    'br' => 'Breton',
	    'bg' => 'Bulgarian',
	    'my' => 'Burmese',
	    'ca' => 'Catalan, Valencian',
	    'km' => 'Central Khmer',
	    'ch' => 'Chamorro',
	    'ce' => 'Chechen',
	    'ny' => 'Chichewa, Chewa, Nyanja',
	    'zh' => 'Chinese',
	    'cu' => 'Church Slavonic, Old Bulgarian, Old Church Slavonic',
	    'cv' => 'Chuvash',
	    'kw' => 'Cornish',
	    'co' => 'Corsican',
	    'cr' => 'Cree',
	    'hr' => 'Croatian',
	    'cs' => 'Czech',
	    'da' => 'Danish',
	    'dv' => 'Divehi, Dhivehi, Maldivian',
	    'nl' => 'Dutch, Flemish',
	    'dz' => 'Dzongkha',
	    'en' => 'English',
	    'eo' => 'Esperanto',
	    'et' => 'Estonian',
	    'ee' => 'Ewe',
	    'fo' => 'Faroese',
	    'fj' => 'Fijian',
	    'fi' => 'Finnish',
	    'fr' => 'French',
	    'ff' => 'Fulah',
	    'gd' => 'Gaelic, Scottish Gaelic',
	    'gl' => 'Galician',
	    'lg' => 'Ganda',
	    'ka' => 'Georgian',
	    'de' => 'German',
	    'ki' => 'Gikuyu, Kikuyu',
	    'el' => 'Greek (Modern)',
	    'kl' => 'Greenlandic, Kalaallisut',
	    'gn' => 'Guarani',
	    'gu' => 'Gujarati',
	    'ht' => 'Haitian, Haitian Creole',
	    'ha' => 'Hausa',
	    'he' => 'Hebrew',
	    'hz' => 'Herero',
	    'hi' => 'Hindi',
	    'ho' => 'Hiri Motu',
	    'hu' => 'Hungarian',
	    'is' => 'Icelandic',
	    'io' => 'Ido',
	    'ig' => 'Igbo',
	    'id' => 'Indonesian',
	    'ia' => 'Interlingua (International Auxiliary Language Association)',
	    'ie' => 'Interlingue',
	    'iu' => 'Inuktitut',
	    'ik' => 'Inupiaq',
	    'ga' => 'Irish',
	    'it' => 'Italian',
	    'ja' => 'Japanese',
	    'jv' => 'Javanese',
	    'kn' => 'Kannada',
	    'kr' => 'Kanuri',
	    'ks' => 'Kashmiri',
	    'kk' => 'Kazakh',
	    'rw' => 'Kinyarwanda',
	    'kv' => 'Komi',
	    'kg' => 'Kongo',
	    'ko' => 'Korean',
	    'kj' => 'Kwanyama, Kuanyama',
	    'ku' => 'Kurdish',
	    'ky' => 'Kyrgyz',
	    'lo' => 'Lao',
	    'la' => 'Latin',
	    'lv' => 'Latvian',
	    'lb' => 'Letzeburgesch, Luxembourgish',
	    'li' => 'Limburgish, Limburgan, Limburger',
	    'ln' => 'Lingala',
	    'lt' => 'Lithuanian',
	    'lu' => 'Luba-Katanga',
	    'mk' => 'Macedonian',
	    'mg' => 'Malagasy',
	    'ms' => 'Malay',
	    'ml' => 'Malayalam',
	    'mt' => 'Maltese',
	    'gv' => 'Manx',
	    'mi' => 'Maori',
	    'mr' => 'Marathi',
	    'mh' => 'Marshallese',
	    'ro' => 'Moldovan, Moldavian, Romanian',
	    'mn' => 'Mongolian',
	    'na' => 'Nauru',
	    'nv' => 'Navajo, Navaho',
	    'nd' => 'Northern Ndebele',
	    'ng' => 'Ndonga',
	    'ne' => 'Nepali',
	    'se' => 'Northern Sami',
	    'no' => 'Norwegian',
	    'nb' => 'Norwegian Bokmål',
	    'nn' => 'Norwegian Nynorsk',
	    'ii' => 'Nuosu, Sichuan Yi',
	    'oc' => 'Occitan (post 1500)',
	    'oj' => 'Ojibwa',
	    'or' => 'Oriya',
	    'om' => 'Oromo',
	    'os' => 'Ossetian, Ossetic',
	    'pi' => 'Pali',
	    'pa' => 'Panjabi, Punjabi',
	    'ps' => 'Pashto, Pushto',
	    'fa' => 'Persian',
	    'pl' => 'Polish',
	    'pt' => 'Portuguese',
	    'qu' => 'Quechua',
	    'rm' => 'Romansh',
	    'rn' => 'Rundi',
	    'ru' => 'Russian',
	    'sm' => 'Samoan',
	    'sg' => 'Sango',
	    'sa' => 'Sanskrit',
	    'sc' => 'Sardinian',
	    'sr' => 'Serbian',
	    'sn' => 'Shona',
	    'sd' => 'Sindhi',
	    'si' => 'Sinhala, Sinhalese',
	    'sk' => 'Slovak',
	    'sl' => 'Slovenian',
	    'so' => 'Somali',
	    'st' => 'Sotho, Southern',
	    'nr' => 'South Ndebele',
	    'es' => 'Spanish, Castilian',
	    'su' => 'Sundanese',
	    'sw' => 'Swahili',
	    'ss' => 'Swati',
	    'sv' => 'Swedish',
	    'tl' => 'Tagalog',
	    'ty' => 'Tahitian',
	    'tg' => 'Tajik',
	    'ta' => 'Tamil',
	    'tt' => 'Tatar',
	    'te' => 'Telugu',
	    'th' => 'Thai',
	    'bo' => 'Tibetan',
	    'ti' => 'Tigrinya',
	    'to' => 'Tonga (Tonga Islands)',
	    'ts' => 'Tsonga',
	    'tn' => 'Tswana',
	    'tr' => 'Turkish',
	    'tk' => 'Turkmen',
	    'tw' => 'Twi',
	    'ug' => 'Uighur, Uyghur',
	    'uk' => 'Ukrainian',
	    'ur' => 'Urdu',
	    'uz' => 'Uzbek',
	    've' => 'Venda',
	    'vi' => 'Vietnamese',
	    'vo' => 'Volap_k',
	    'wa' => 'Walloon',
	    'cy' => 'Welsh',
	    'fy' => 'Western Frisian',
	    'wo' => 'Wolof',
	    'xh' => 'Xhosa',
	    'yi' => 'Yiddish',
	    'yo' => 'Yoruba',
	    'za' => 'Zhuang, Chuang',
	    'zu' => 'Zulu'
	];

	public $default = 'en';

	public function __construct(){

	}

	public function name($code){
		$code = strtolower($code);
		return $this->lists[$code] ?? null;
	}

	public function available($secondary_only=false){
		if($secondary_only){
			$sc = app('language')->where('is_default_language', 0);
		}
		else{
			$sc = app('language');
		}

		$lists = $sc->sortBy(function($item){
			$score = 0;
			if($item->is_default_language){
				return '0';
			}
			return $item->name;
		});
		$out = [];
		foreach($lists as $row){
			$out[$row->code] = $row->name;
		}
		return $out;
	}

	public function current(){
		return session('lang');
	}

	public function default($field='code'){
		$grab = app('language')->where('is_default_language', 1)->first();
		if(empty($grab)){
			//create new default language instance in database
			$instance = new Model;
			$instance->code = $this->default;
			$instance->name = $this->lists[$this->default] ?? null;
			$instance->is_default_language = 1;
			$instance->sort_no = 0;
			$instance->save();
			$grab = $instance;
		}
		return strtolower($grab->{$field});
	}

	public function secondary(){
		$grab = app('language')->where('is_default_language', 0);
		$out = [];
		foreach($grab as $row){
			$out[$row->code] = $row->name;
		}
		return $out;
	}

	public function remove($code){
		$code = strtolower($code);
		$grab = app('language')->where('code', $code)->first();
		if(!$grab->is_default_language){
			$grab->delete();
		}
	}

	public function setAsDefault($code){
		$code = strtolower($code);
		if($this->checkCodeExists($code)){
			if($this->default() <> $code){
				//set new language
				$old = app('language')->where('is_default_language', 1)->first();
				$old->is_default_language = 0;
				$old->save();

				$this->insertNewLanguage($code, 1);
			}
		}
	}

	public function setAsSecondary($code){
		$code = strtolower($code);
		if($this->checkCodeExists($code)){
			if($this->default() <> $code){
				$this->insertNewLanguage($code, 0);
			}
		}
	}

	protected function checkCodeExists($code){
		$code = strtolower($code);
		return array_key_exists($code, $this->lists);
	}

	protected function insertNewLanguage($code, $is_default_language=0){
		$check = Model::where('code', $code)->first();
		if(empty($check)){
			$check = new Model;
			$check->code = $code;
			$check->name = $this->lists[$code];
		}
		$check->is_default_language = intval($is_default_language);
		$check->save();

		$check->sort_no = $check->id;
		$check->save();
	}

}