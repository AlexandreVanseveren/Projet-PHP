<?php
//dao = data acces object
//dal = data access layer
abstract class GDAO {

    
	
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
	
	function verificationNombreRationelEntierPositif($valeur){
		if ((int)$valeur==$valeur and (int)$valeur >0){
			return true;
		} else {
			return false;
		}		
	}

	function verificationNombreRationelPositif($valeur){
		if ((float)$valeur==$valeur and (float)$valeur >0){
			return true;
		} else {
			return false;
		}
	}
	
	function verificationTriche($valeur){
		$verif = array('<html','<?php','select');
		$fin=0;
		foreach ($verif as $text){
			$verification = strpos($valeur,$text);
			if ($verification !== false){
				$fin =1;
			}
		}
		if ($fin==0){
			return true;
		}else{
			return false;
		}
	}

	function supprimer($pk,$table,$connection) {
		try{
            $statement = $connection->prepare("DELETE FROM $table WHERE pk = ?");
            $statement->execute([$pk]);
        } catch (PDOException $e){
            print $e->getMessage();
        }
	}
	
	function create($data) {
        
    }
	
	function fetchAll($connection,$table,$list) {
        try {
            $statement = $connection->prepare("SELECT * FROM $table");
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($results as $object) {
				
                array_push($list, $this->create($object));
            }
            return $list;
            
        } catch (PDOException $e) {
            print $e->getMessage();
        }    
    }
	
	function fetch($pk,$connection,$table) {
        try {
            $statement = $connection->prepare("SELECT * FROM $table WHERE pk = ?");
            $statement->execute([$pk]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $this->create($result);
            
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }
	function fetchnom($nom,$connection,$table) {
        try {
            $statement = $connection->prepare("SELECT pk FROM $table WHERE nom = ?");
            $statement->execute([$nom]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
			return ($result['pk']);
            
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }
}