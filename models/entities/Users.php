<?php 
//objet metier - entities
class Users {
    private $pk;
    private $username;
    private $password;
    private $created_at;
    private $updated_at;
	private $session_token;
    private $session_time;
	private $fk_roles;
    
    function __construct($pk, $username, $password, $created_at, $updated_at,$session_token, $session_time,$fk_roles) {
        $this->pk = $pk;
        $this->username = $username;
        $this->password = $password;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
		$this->session_token = $session_token;
        $this->session_time = $session_time;
		$this->fk_roles = $fk_roles;
    }
    
    function __get($property) {
        if (property_exists($this, $property)) {
			return $this->$property;
		}
    }
    
    function __set($property, $value) {
        if (property_exists($this, $property)) {
			$this->$property = $value;
		}
    }
}
