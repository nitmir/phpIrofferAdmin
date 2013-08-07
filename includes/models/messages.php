<?php

class MESSAGES {
	private $error = array();
	private $warning = array();
	private $info = array();
	private $success = array();
	
	function MESSAGES(){}
	
	public function error($str=false){
		if($str!==false){
			if(is_array($str))
				$this->error=array_merge($this->error, $str);
			else
				$this->error[]=$str;
		} else {
			return array_pop($this->error);
		}
	}
	public function info($str=false){
		if($str!==false){
			if(is_array($str))
				$this->info=array_merge($this->info, $str);
			else
			$this->info[]=$str;
		} else {
			return array_pop($this->info);
		}
	}
	public function success($str=false){
		if($str!==false){
			if(is_array($str))
				$this->success=array_merge($this->success, $str);
			else
				$this->success[]=$str;
		} else {
			return array_pop($this->success);
		}
	}
	function warning($str=false){
		if($str!==false){
			if(is_array($str))
				$this->warning=array_merge($this->warning, $str);
			else
				$this->warning[]=$str;
		} else {
			return array_pop($this->warning);
		}
	}
}

function messages(){
	static $messages=false;
	if($messages!==false)
		return $messages;
	else {
		if(session_started()){
			if(!isset($_SESSION['messages']))
				$_SESSION['messages']=new MESSAGES();
			$messages = $_SESSION['messages'];
		} else {
			$messages = new MESSAGES();
		}
		return $messages;
	}
}