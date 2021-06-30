<?php
//dao = data acces object
//dal = data access layer
class RoleDAO extends GDAO{
    private $table;
    private $connection;
    
    function __construct() {
        $this->table = 'role';
        $this->connection = new PDO('mysql:host=localhost;dbname=demo', 'root', '');
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
   
    function fetchTypechat($nom) {
		$table=$this->table;
		$connection= $this->connection;
		$result=$this->fetchpk($nom,$connection,$table);
		return $result;     
    }
	  
    function create($data) {
        return new role(
            $data['pk'],
            $data['nom']
        );
    }
}