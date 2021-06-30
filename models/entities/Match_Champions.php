<?php 
//objet metier - entities
class Match_Champions {
    private $fk_champions;
    private $fk_match;
    
    function __construct($fk_champions, $fk_match) {
        $this->fk_champions = $fk_champions;
		$this->fk_match = $fk_match;
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
