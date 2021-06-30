<?php
//dao = data acces object
//dal = data access layer
class MatchDAO extends GDAO{
    private $table;
    private $connection;
    
    function __construct() {
        $this->table = 'matchleague';
        $this->connection = new PDO('mysql:host=localhost;dbname=demo', 'root', '');
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
	
    function save($data){
		if($this->verificationTriche($data['note'])==true and $this->verificationTriche($data['mvp']==true) ){
			$data['pk'] = -1;
			$match = $this->create([
				'pk' => $data['pk'],
				'resultat' => $data['resultat'],
				'joueurs' =>$data['joueurs'],
				'side' =>$data['side'],
				'type' =>$data['type'],
				'mvp'=>$data['mvp'],
				'note'=>$data['note'],
				'dateHeure'=>date ('y-m-d h:i:s')
			]);
			
			if ($match) {
				try {
					$statement = $this->connection->prepare(
						"INSERT INTO {$this->table} (resultat, joueurs, side, type, mvp, note, dateHeure) VALUES (?, ?, ?, ?, ?, ?, ?)"
					);
					$statement->execute([
						$match->__get('resultat'),
						$match->__get('joueurs'),
						$match->__get('side'),
						$match->__get('type'),
						$match->__get('mvp'),
						$match->__get('note'),
						$match->__get('dateHeure'),
					]);
				} catch(PDOException $e) {
					print $e->getMessage();
				}
			}
		}
    }
    
	function fetchPkOnNote($note){
		$connection = $this->connection;
		try {
            $statement = $connection->prepare("SELECT pk FROM matchleague WHERE note = ?");
            $statement->execute([$note]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
			return ($result['pk']);
            
        } catch (PDOException $e) {
            print $e->getMessage();
        }
	}
	
	function fetchMatch($pk) {
		$table=$this->table;
		$connection= $this->connection;
		$result=$this->fetch($pk,$connection,$table);
		return $result;     
    }
	  
    function create($data) {
        return new match(
            $data['pk'],
            $data['resultat'],
            $data['joueurs'],
            $data['side'],
            $data['type'],
			$data['mvp'],
			$data['note'],
            $data['dateHeure']
        );
    }
   
	function supprimerMatch($pk) {
		$connection= $this->connection;
		try{
            $statement = $connection->prepare("DELETE FROM match_champions WHERE fk_match = ?");
            $statement->execute([$pk]);
        } catch (PDOException $e){
            print $e->getMessage();
        }
		try{
            $statement = $connection->prepare("DELETE FROM matchleague WHERE pk = ?");
            $statement->execute([$pk]);
        } catch (PDOException $e){
            print $e->getMessage();
        }
	}
}