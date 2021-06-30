<?php
//dao = data acces object
//dal = data access layer
class DemandeDAO extends GDAO{
    private $table;
    private $connection;
    private $demande_list;
	private $UsersDAO;
    
    function __construct() {
        $this->table = 'demande';
        $this->connection = new PDO('mysql:host=localhost;dbname=demo', 'root', '');
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->UsersDAO = new UsersDAO();
        $this->demande_list = array();
    }
   
    function save($data,$cookie){
		if($this->verificationTriche($data['description'])==true){
			$pk = $this->UsersDAO->fetchByCookie($cookie);
			$pk = $pk->__get('pk');
			$data['pk'] = -1;
			$demande = $this->createSave([
				'pk' => $data['pk'],
				'montant' => $data['montant'],
				'description' =>$data['description'],
				'created_at' =>date('y-m-d h:i:s'),
				'fk_user' =>$pk,
				'statut'=>'En attente'
			]);
			if ($demande) {
				try {
					$statement = $this->connection->prepare(
						"INSERT INTO {$this->table} (montant, description, created_at, fk_user, statut) VALUES (?, ?, ?, ?,?)"
					);
					$statement->execute([
						$demande->__get('montant'),
						$demande->__get('description'),
						$demande->__get('created_at'),
						$demande->__get('fk_user'),
						$demande->__get('statut'),
					]);
				} catch(PDOException $e) {
					print $e->getMessage();
				}
			}
		}
    }
	
	function createSave($data) {
        return new demande(
            $data['pk'],
            $data['montant'],
            $data['description'],
            $data['created_at'],
            $data['fk_user'],
			$data['statut']
        );
    }
    
    function fetchAlldemande() {	
		$table=$this->table;
		$connection= $this->connection;
		$list= $this->demande_list;
		$demande_list=$this->fetchALL($connection,$table,$list);
		return $demande_list;        
    }
	
    function fetchonUser($cookie) {
		$pk = $this->UsersDAO->fetchByCookie($cookie);
		$pk = $pk->__get('pk');
		$table=$this->table;
		$connection= $this->connection;
		$list = $this->demande_list;
		try {
            $statement = $connection->prepare("SELECT * FROM $table where fk_user = ?");
			$statement->execute([$pk]);
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach($results as $object) {
                array_push($list, $this->create($object));
            }
            return $list;
            
        } catch (PDOException $e) {
            print $e->getMessage();
        }      
    }
	  
    function create($data) {
        return new demande(
            $data['pk'],
            $data['montant'],
            $data['description'],
            $data['created_at'],
            $this->UsersDAO->fetchuser($data['fk_user']),
			$data['statut']
        );
    }
   
	function supprimerdemande($params) {
		$pk=$params['pk'];
		$table=$this->table;
		$connection= $this->connection;
		$this->supprimer($pk,$table,$connection);
	}
	
	function changementStatut($params){
		$pk=$params['pk'];
		try{
            $statement = $this->connection->prepare("Update {$this->table} SET statut = 'valide' WHERE pk = ?");
            $statement->execute([$pk]);
        } catch (PDOException $e){
            print $e->getMessage();
        }
	}
}