<?php
/*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

class USER_DATA {
	private $id;
	
	function USER_DATA($id){
		$this->id = $id;
	}
	
	public static function byName($name){
		$query=db()->query("SELECT id FROM users WHERE name=".db()->quote($name)."") or die(dberror());
		if($data=$query->fetch()){
			return new USER_DATA($data['id']);
		} else {
			throw new Exception('User '.$name.' not found');
		}
	}
	public static function byRow(array $data){
		if(isset($data['id'])){
			return new USER_DATA($data['id']);
		} else {
			throw new Exception('User id not found in row');
		}
	}
	public function fetch(){
		$query=db()->query("SELECT * FROM users WHERE id=".db()->quote($this->id)."") or die(dberror());
		if($data=$query->fetch()){
			return $data;
		}else {
			throw new Exception('User id '.$this->id.' not found');
		}
	}
	
	public function login(){
		db()->exec("UPDATE users SET last_login=NOW(), ip='".$_SERVER['REMOTE_ADDR']."' WHERE id=".db()->quote($this->id))or die(dberror());
	}

	public static function all_users(){
		$query=db()->query("SELECT * FROM users ORDER BY name");
		$array=array();
		while($data=$query->fetch()){
			$array[]=USER::byRow($data);
		}
		return $array;
	}
	
	public function add_bot($bot_id){
		db()->query("INSERT INTO bot_user (bot_id, user_id) VALUES (".db()->quote($bot_id).", ".db()->quote($this->id).")")or die(dberror());
	}
	public function delete_bot($bot_id){
		db()->query("DELETE FROM bot_user WHERE bot_id=".db()->quote($bot_id)." AND user_id=".db()->quote($this->id))or die(dberror());
	}
	
	public static function create($name, $email, $password){
		return db()->query("INSERT INTO users (name, email, password) VALUES ("
                    .db()->quote($name).", "
                    .db()->quote($email).", "
                    .db()->quote(crypt($password)).")");
	}
	
	public function delete(){
		return db()->query("DELETE FROM users WHERE id=".db()->quote($this->id));
	}

	public function update($name=false, $email=false, $password=false, $right=false){
		$succs=array();
		$erros=array();
		$SET='';
		if($right)
			$SET.=', `right`='.db()->quote($right);
		if($name)
			$SET.=', name='.db()->quote($name);
		if($email)
			$SET.=', email='.db()->quote($email);
		if($password)
			$SET.=', password='.db()->quote(crypt($password));
		if(db()->query('UPDATE users SET id=id'.$SET.' WHERE id='.db()->quote($this->id))){
			return true;
		} else {
			 messages()->error(sprintf(_('Update error: %s'), dberror().' '.'UPDATE users SET id=id'.$SET.' WHERE id='.db()->quote($this->id)));
			 return false;
		}
	}

}

class USER {
	private $name;
	private $right;
	private $email;
	private $created;
	private $last_login;
	private $id;
	private $password;
	private $valid = false;
	private $data;
	private $bots = false;
	
	public function name() { return $this->name;}
	public function right() { return $this->right;}
	public function level() { return constant($this->right);}
	public function email() { return $this->email;}
	public function created() { return $this->created;}
	public function last_login() { return $this->last_login;}
	public function id() { return $this->id;}
	public function data() { return $this->data;}
	
	public function valid($password=false){
		if($password!==false){
			$this->valid = $this->check_pass($password);
			if($this->valid)
				$this->data->login();
		}
		return $this->valid;
	}
	
	public function load($return=false){
		if($return===false)
			$return=$this->data->fetch();
		$this->name = $return['name'];
		$this->right = $return['right'];
		$this->email = $return['email'];
		$this->created = $return['created'];
		$this->last_login = $return['last_login'];
		$this->id = $return['id'];
		$this->password = $return['password'];
		$this->bots = false;
	}
	
	public static function byName($name){
		$inst = new self();
		$inst->data=USER_DATA::byName($name);
		$inst->load();
		return $inst;
	}
	
	public static function byID($id){
		$inst = new self();
		$inst->data=new USER_DATA($id);
		$inst->load();
		return $inst;
	}
	public static function byRow(array $data){
		$inst = new self();
		$inst->data=USER_DATA::byRow($data);
		$inst->load($data);
		return $inst;
	}
	function USER(){
		$this->data = new USER_DATA(-1);
	}
	
	private function check_pass($password){
		list($_,$algo,$salt,$_)=explode('$', $this->password);
		return crypt($password, '$'.$algo.'$'.$salt)==$this->password;
	}
	
	public function all_users(){
		if($this->right == 'ADMIN')
			return USER_DATA::all_users();
		else
			return array();
	}
	
	public function bots($refresh=false){
		if($this->bots===false||$refresh){
			$this->bots = BOT::by_user($this->id);
		}
		return $this->bots;
	}
	
	public function add_bot($bot_id){
		$this->bots = false;
		$this->data->add_bot($bot_id);
	}
	public function delete_bot($bot_id){
		$this->bots = false;
		$this->data->delete_bot($bot_id);
	}
	public function create_bot($name, $host, $port, $password){
		$this->bots = false;
		BOT::create($name, $host, $port, $password, $this->id);
	}
	public function own_bot($bot_id){
		$bots=$this->bots();
		return isset($bots[$bot_id]);
	}
	
	public static function create($name, $email, $password){
		return USER_DATA::create($name, $email, $password);
	}
	
	public function delete(){
		return $this->data->delete();
	}

	public function update($name=false, $email=false, $password=false, $right=false){
		return $this->data->update($name, $email, $password, $right);
	}
}


function user($name=false){
	if($name!==false&&session_started()){
		try{
			$_SESSION['user']=USER::byName($name);
		} catch(Exception $e) {
			return new USER();
		}
	}
	if(isset($_SESSION['user'])){
		return $_SESSION['user'];
	} else {
		return new USER();;
	}
}



