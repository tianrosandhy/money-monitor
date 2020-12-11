<?php
namespace App\Core\Exceptions;

use Exception;
use Illuminate\Validation\Validator;

class ProcessException extends Exception
{
	public function __construct($request=null){
		$this->code = 400;
		if($request instanceof Validator){
			$this->message = $request->errors()->toArray();
		}
		else if(is_string($request)){
			//force to single array
			$this->message = [$request];
		}
		else{
			//force to array
			$this->message = json_decode(json_encode($request), true);
		}
	}

	public function setCode($code){
		$this->code = $code;
		return $this;
	}
}