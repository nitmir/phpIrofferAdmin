<?php
/*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
class IROFFER_ERROR extends Exception {}

class IROFFER {
	var $conn;
	var $server;
	var $port;
	var $password;
	var $bot;
	var $version;
	var $error_number;
	var $error_message;
	var $timeout = 5;

	function IROFFER ($server, $port, $password, $timeout=NULL) {
		$this->server = $server;
		$this->port = $port;
		$this->password = $password;
		if($timeout) $this->timeout = $timeout;
		$this->connect();
	}

	function connect() {
		if($this->conn) {
			return true;
		}
		$this->nntp = fsockopen($this->server, $this->port, $this->error_number, $this->error_message, $this->timeout);
		if ($this->nntp === false) throw new IROFFER_ERROR('Unable to connect to the bot at address '.$this->server.':'.$this->port.'. Error n°'.$this->error_number.': '.$this->error_message);
		if($this->nntp) {
			//stream_set_blocking($this->nntp, 0);
			$this->bot=explode(' ', fgets($this->nntp, 4096), 4)[2];
			$this->version=fgets($this->nntp, 4096);
			while(strlen(fgets($this->nntp, 4096))>2);
			$this->send($this->password);
			while(strlen(fgets($this->nntp, 4096))>2);
			while(strlen(fgets($this->nntp, 4096))>2);

			return true;
		} else {
			return false;
		}
	}
	function send($str) {
		fputs($this->nntp, $str . "\r\n");
	}
	function quit() {
		$this->send('QUIT');
	}
	function command($str) {
		$this->connect();
		$this->send($str);
		$this->quit();
		stream_set_timeout($this->nntp, 5);
		$output=array();
		while(($output[]=fgets($this->nntp))!==false);
		return preg_replace('/[\x00-\x1F]/', '', $output);
	}

	function xdl($group_only=false){ return $this->_xdl('XDL', $group_only);}
	function xdlfull(){ return $this->_xdl('XDLFULL')[0];}
	function xdlgroup($group){ return $this->_xdl('XDLGROUP "'.$group.'"')[0];}
	function xdlock(){ return $this->_xdl('XDLOCK')[0];}
	function xdtrigger(){ return $this->_xdl('XDTRIGGER')[0];}

	private function _xdl($cmd, $group_only=false) {
		$array=array_slice($this->command($cmd),7,-4);
		$groups=array();
		for($i=0; isset($array[$i]); $i++){
			if(!preg_match('/^group:/', $array[$i])){
				if(!$group_only){
					$array[$i]=preg_split('/ +/', preg_replace(array('/\[ */'), array('['), $array[$i]), 4);
					$array[$i]['pack']=substr(trim($array[$i][0]), 1);
					$array[$i]['downloaded']=substr(trim($array[$i][1]), 0, -1);
					$array[$i]['size']=substr(trim($array[$i][2]), 1, -1);
					$array[$i]['file']=trim($array[$i][3]);
					for($j=0; isset($array[$i][$j]); $j++){ unset($array[$i][$j]);}
				} else {
					unset($array[$i]);
				}
			} else {
				$group=preg_split('/ +- +/', preg_replace(array('/\[ */'), array('['), $array[$i]), 2);
				$groups[]=array(
					'name' => trim(preg_replace('/^.*group: +/', '', $group[0])),
					'description' => trim($group[1]),
				);
				unset($array[$i]);
			}
		}
		if($group_only){
			return $groups;
		} else {
			return array($array, $groups);
		}
	}
	function listul($path=''){
		$array=$this->command('LISTUL "'.$path.'"');
		if(isset($array[1])){
			$message=$array[1];
			if(substr($message, 0, 7)=='Listing'){
				$array=array_slice($array, 2, -4);
				for($i=0; isset($array[$i]); $i++){
					$array[$i]=preg_split('/ +/', trim($array[$i]), 2);
					$array[$i]['size']=trim($array[$i][0]);
					$array[$i]['name']=trim($array[$i][1]);
					for($j=0; isset($array[$i][$j]); $j++){ unset($array[$i][$j]);}
				}
				return $array;
			} else {
				return $message;
			}
		}
	}
	function renumber($x, $y){
		return $this->command('RENUMBER '.$x.' '.$y)[1];
	}
	function remove($n, $m=false){
		return $this->command('REMOVE '.$n.($m!==false?' '.$m:''))[1];
	}
	function removegroup($group){
		return $this->command('REMOVEGROUP "'.$group.'"')[1];
	}
	function group($n, $group){
		return $this->command('GROUP '.$n.' "'.$group.'"')[1];
	}
	function regroup($src, $dst){
		return $this->command('REGROUP "'.$src.'" "'.$dst.'"')[1];
	}
	function groupdesc($group, $desc){
		return $this->command('GROUPDESC "'.$group.'" "'.$desc.'"')[1];
	}
	function add($path){
		return $this->command('ADD "'.$path.'"')[1];
	}
	function adddir($path){
		return $this->command('ADDDIR "'.$path.'"')[1];
	}
	function removedir($path){
		return $this->command('REMOVEDIR "'.$path.'"')[1];
	}
	function addgroup($group, $dir){
		return $this->command('ADDGROUP "'.$group.'" "'.$dir.'"')[1];
	}
	function addnew($path){
		return $this->command('ADDNEW "'.$path.'"')[1];
	}
	function chdesc($pack, $desc){
		return $this->command('CHDESC '.$pack.' "'.$desc.'"')[1];
	}
	function status(){
		return $this->command('STATUS')[1];
	}
	function info($n){
		$array=array_slice($this->command('INFO '.$n), 2, -3);
		for($i=0; isset($array[$i]); $i++){
			$array[$i]=preg_split('/  +/', trim($array[$i]), 2);

			$array[strtolower(trim($array[$i][0]))]=trim(@$array[$i][1]);
			unset($array[$i]);
		}
		return $array;
	}
}

