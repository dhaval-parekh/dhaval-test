<?php
class IndexModal extends Modal{
	public function __construct(){
		parent::__construct();
	}
	
	public function addUpdateUser($data,$id = false){
		if(! (isset($data['name'],$data['email'],$data['phone']))){ return false; }
		$data['name'] = $this->Database->escape_string($data['name']);
		$is_update = false;
		if(isset($id) && $id && is_numeric($id)){
			$is_update = true;
			$query  = "UPDATE usermaster SET ";
			$query .= " name = '".$data['name']."', ";
			$query .= " email = '".$data['email']."', ";
			$query .= " phone = '".$data['phone']."' ";
			$query .= " WHERE id = ".$id."; ";
			// udpate	
		}else{
			// insert
			$query = "INSERT INTO usermaster (name,email,phone) VALUES
						('".$data['name']."','".$data['email']."','".$data['phone']."')";
		}
		
		if($this->Database->ExecuteNoneQuery($query) == 1){
			if($is_update){
				return $id;	
			}
			return $this->Database->get_last_inserted_id();
		}
		return false;
	}
	
	public function getUser($id = false){
		if(isset($id) && is_numeric($id)){
			$query = "SELECT * FROM usermaster WHERE id = ".$id."; ";
			$result = $this->Database->getRow($query);
			return $result;
		}else{
			$query = "SELECT * FROM usermaster ";
			$result = (array) $this->Database->ExecuteQuery($query);
			return $result;	
		}
		return false;
	}
}