<?php 
//objet metier - entities
class Match {
    private $pk;
    private $resultat;
    private $joueurs;
    private $side;
    private $type;
	private $mvp;
    private $note;
	private $dateHeure;
    
    function __construct($pk, $resultat, $joueurs, $side, $type ,$mvp, $note,$dateHeure) {
        $this->pk = $pk;
        $this->resultat = $resultat;
        $this->joueurs = $joueurs;
        $this->side = $side;
        $this->type = $type;
		$this->mvp = $mvp;
        $this->note = $note;
		$this->dateHeure = $dateHeure;
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
