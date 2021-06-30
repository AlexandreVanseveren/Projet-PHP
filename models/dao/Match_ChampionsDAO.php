<?php
//dao = data acces object
//dal = data access layer
class Match_championsDAO extends GDAO{
    private $table;
    private $connection;
	private $championsDAO;
	private $matchDAO;
	private $matchlist;
	private $strategy;
    
    function __construct(IMatch $IMatch) {
        $this->table = 'match_champions';
        $this->connection = new PDO('mysql:host=localhost;dbname=demo', 'root', '');
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->championsDAO = new ChampionsDAO();
		$this->matchDAO = new MatchDAO();
		$this->matchlist = array();
		$this->strategy = $IMatch;
    }
	
	function saveArray($fk_match,$fk_champions){
			foreach($fk_champions as $champions){
				$this->save($fk_match,fk_champions);
			}			
	}
	
	function save($data){
			$i=0;
			while ($i <10){
				$i=$i+1;
				$nom='champions'.$i;
				$nom=$_POST[$nom];
				$fk_champions=$this->championsDAO->fetchnom($nom,$this->connection,'champions');
				$fk_match=$this->matchDAO->fetchPkOnNote($data['note']);
				$Match_Champions = $this->createSave([
				'fk_champions' => $fk_champions,
				'fk_match' => $fk_match
				]);
				if ($Match_Champions){
					try {
						$statement = $this->connection->prepare(
							"INSERT INTO {$this->table} (fk_champions, fk_match) VALUES ( ?, ?)"
						);
						$statement->execute([
							$Match_Champions->__get('fk_champions'),
							$Match_Champions->__get('fk_match')
						]);
					} catch(PDOException $e) {
						print $e->getMessage();
					}
				}
			}
    }
	
	function createSave($data) {
        return new Match_Champions(
			$data['fk_champions'],
			$data['fk_match']
        );
    }
	
	function fetchAllMatch() {
		$table=$this->table;
		$connection= $this->connection;
		$list= $this->matchlist;	
		$match_list = $this->strategy->fetchAllMatch($table,$connection,$list);
		foreach($match_list as $object) {
                array_push($list, $this->create($object));				
            }
        return $list;	
    }
	
    function create($data) {
        return new Match_Champions(
			$this->championsDAO->fetchChampions($data['fk_champions']),
			$this->matchDAO->fetchmatch($data['fk_match'])	
        );
    }
   
}