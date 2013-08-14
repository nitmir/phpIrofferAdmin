<?php
/*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

class BOT_DATA {
	private $id;
	function BOT_DATA($id){
		$this->id = $id;
	}
	
	public function fetch(){
		$query=db()->query("SELECT * FROM bots WHERE id=".db()->quote($this->id)."") or die(dberror());
		if($data=$query->fetch()){
			return $data;
		}else {
			throw new Exception('Bot id '.$this->id.' not found');
		}
	}
	
	public static function all_bots(){
		$query=db()->query("SELECT * FROM bots ORDER BY name");
		$array=array();
		while($data=$query->fetch()){
			$array[$data['id']]=BOT::withRow($data);
		}
		return $array;
	}
	
	public static function by_user($user_id){
		$query=db()->query("SELECT * FROM bots, bot_user WHERE bots.id=bot_user.bot_id AND bot_user.user_id=".db()->quote($user_id)." ORDER BY name")or die(dberror());
		$array=array();
		while($data=$query->fetch()){
			$array[$data['id']]=BOT::withRow($data);
		}
		return $array;
	}
	
	public function update($values){
		if($values['password']!=''){
		    db()->query("UPDATE bots SET "
			."name=".db()->quote($values['name']).", "
			."host=".db()->quote($values['host']).", "
			."port=".db()->quote($values['port']).", "
			."password=".db()->quote($values['password']).
		    " WHERE id=".db()->quote($values['id'])."")or die(dberror());
		} else {
		    db()->query("UPDATE bots SET "
		    ."name=".db()->quote($values['name']).", "
		    ."host=".db()->quote($values['host']).", "
		    ."port=".db()->quote($values['port']).
		" WHERE id=".db()->quote($values['id'])."")or die(dberror());
		}
	}
	public static function create($name, $host, $port, $password, $user_id){
	    if(db()->query("INSERT INTO bots (name, host, port, password) VALUES (".
		    db()->quote($name).",".
		    db()->quote($host).",".
		    db()->quote($port).",".
		    db()->quote($password).
	    ")")){
		$id=db()->lastInsertId();
		db()->query("INSERT INTO `bot_user` (`bot_id`, `user_id`) VALUES (".
		    db()->quote($id).",".
		    db()->quote($user_id).
		")")or die(dberror());
	    } else {
		$query=db()->query("SELECT id FROM bots WHERE "
		    ."host=".db()->quote($host)." AND "
		    ."port=".db()->quote($port)." AND "
		    ."password=".db()->quote($password)
		)or die(dberror());
		if($data=$query->fetch()){
		    db()->query("INSERT INTO `bot_user` (`bot_id`, `user_id`) VALUES (".
			db()->quote($data['id']).",".
			db()->quote($user_id).
		    ")")or die(dberror());
		}else{
		    messages()->error(_('couple (host, port) already used and wrong password'));
		}
	    }
	}
	public function delete(){
		db()->query("DELECT FROM `bot_user` WHERE `bot_id` = ".db()->quote($this->id));
		db()->query("DELETE FROM bots WHERE id=".db()->quote($this->id))or die(dberror());
	}

}

class BOT {
	private $name;
	private $host;
	private $port;
	private $password;
	private $created;
	private $id;
	private $data;
	
	public function name() { return $this->name;}
	public function host() { return $this->host;}
	public function port() { return $this->port;}
	public function password() { return $this->password;}
	public function created() { return $this->created;}
	public function id() { return $this->id;}
	public function data() { return $this->data;}
	
	private function load($return=false){
		if($return===false)
			$return=$this->data->fetch();
		$this->name = $return['name'];
		$this->host = $return['host'];
		$this->port = $return['port'];
		$this->password = $return['password'];
		$this->created = $return['created'];
		$this->id = $return['id'];
	}
	
	public static function withID($id){
		$inst = new self();
		$inst->data = new BOT_DATA($id);
		$inst->load();
		return $inst;
	}
	
	public static function withRow(array $data){
		$inst = new self();
		$inst->data = new BOT_DATA($data['id']);
		$inst->load($data);
		return $inst;
	}
	function BOT(){
		$this->data = new BOT_DATA(-1);
	}
	
	public static function by_user($user_id){
		return BOT_DATA::by_user($user_id);
	}
	public static function all_bots(){
		return BOT_DATA::all_bots();
	}
	public function update($values){
		$this->data->update($values);
		$this->load();
	}
	public static function create($name, $host, $port, $password, $user_id){
		BOT_DATA::create($name, $host, $port, $password, $user_id);
	}
	public function delete(){
		$this->data->delete();
		if(user())
			user()->load();
	}
}