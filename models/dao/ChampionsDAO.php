<?php
//dao = data acces object
//dal = data access layer
class ChampionsDAO extends GDAO{
    private $table;
    private $connection;
    private $champions_list;
    
    function __construct() {
        $this->table = 'champions';
        $this->connection = new PDO('mysql:host=localhost;dbname=demo', 'root', '');
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->champions_list = array();
    }
  
    function fetchAllChampions() {	
		$table=$this->table;
		$connection= $this->connection;
		$list= $this->champions_list;
		$champions_list=$this->fetchALL($connection,$table,$list);
		return $champions_list;        
    }
	
	function fetchChampions($pk) {
		$table=$this->table;
		$connection= $this->connection;
		$result=$this->fetch($pk,$connection,$table);
		return $result;     
    }
	
    function fetchChampionsnom($nom) {
		$table=$this->table;
		$connection= $this->connection;
		$result=$this->fetchpk($nom,$connection,$table);
		return $result;     
    }
	  
    function create($data) {
        return new champions(
            $data['pk'],
            $data['nom']
        );
    }
}