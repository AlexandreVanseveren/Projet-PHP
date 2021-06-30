<?php 
//objet metier - entities
class Message {
    private $pk;
    private $message;
    private $dateHeure;
    private $fk_user;
    private $fk_typechat;
    
    function __construct($pk, $message, $dateHeure, $fk_user, $fk_typechat) {
        $this->pk = $pk;
        $this->message = $message;
        $this->dateHeure = $dateHeure;
        $this->fk_user = $fk_user;
        $this->fk_typechat = $fk_typechat;
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