<?php 
//objet metier - entities
class Demande {
    private $pk;
    private $montant;
    private $description;
    private $created_at;
	private $fk_user;
    private $statut;
    
    function __construct($pk, $montant, $description, $created_at, $fk_user,$statut) {
        $this->pk = $pk;
        $this->montant = $montant;
        $this->description = $description;
        $this->created_at = $created_at;
        $this->fk_user = $fk_user;
		$this->statut = $statut;
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
