<?php
//dao = data acces object
//dal = data access layer
class MessageDAO extends GDAO{
    private $table;
    private $connection;
    private $message_list;
	private $UsersDAO;
    private $TypeChatDAO;
	
    function __construct() {
        $this->table = 'message';
        $this->connection = new PDO('mysql:host=localhost;dbname=demo', 'root', '');
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->users_list = array();
		$this->UsersDAO = new UsersDAO();
		$this->TypeChatDAO = new TypeChatDAO;
    }
   
    function save($message,$cookie){
			$data['pk'] = -1;
			$user=$this->UsersDAO->fetchByCookie($cookie);
			$fk_user=$user->__get('pk');
			$users = $this->create([
				'pk' => $data['pk'],
				'message' => $message,
				'dateHeure' =>date('y-m-d h:i:s'),
				'fk_user' =>$fk_user,
				'fk_typechat'=>1
			]);
			
			if ($message) {
				try {
					$statement = $this->connection->prepare(
						"INSERT INTO {$this->table} (message, dateHeure, fk_user, fk_typechat) VALUES (?, ?, ?, ?)"
					);
					$statement->execute([
						$message->__get('message'),
						$message->__get('dateHeure'),
						$message->__get('fk_user'),
						$message->__get('fk_typechat'),
					]);
				} catch(PDOException $e) {
					print $e->getMessage();
				}
			}
    }
    
    
	  
    function create($data) {
        return new message(
            $data['pk'],
            $data['message'],
            $data['dateHeure'],
            $data['fk_user'],
			$data['fk_typechat']
        );
    }
   
}