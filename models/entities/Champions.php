<?php 
//objet metier - entities
class Champions {
    private $pk;
    private $nom;
    
    function __construct($pk, $nom) {
        $this->pk = $pk;
        $this->nom = $nom;
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
