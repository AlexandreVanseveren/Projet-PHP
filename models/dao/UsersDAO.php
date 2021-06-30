<?php
//dao = data acces object
//dal = data access layer
class UsersDAO extends GDAO{
    private $table;
    private $connection;
    private $users_list;
	private $roleDAO;
    
    function __construct() {
        $this->table = 'users';
        $this->connection = new PDO('mysql:host=localhost;dbname=demo', 'root', '');
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->users_list = array();
		$this->roleDAO = new RoleDAO();
    }
   
    function saveadmin($data){
		if($this->verificationTriche($data['username'])==true and $this->verificationTriche($data['password']==true) ){
			$data['pk'] = -1;
			$users = $this->createsave([
				'pk' => $data['pk'],
				'username' => $data['username'],
				'password' =>password_hash($data['password'], PASSWORD_DEFAULT),
				'created_at' =>date('y-m-d h:i:s'),
				'updated_at' =>date('y-m-d h:i:s'),
				'session_token'=>"undefined",
				'session_time'=>date ('y-m-d h:i:s'),
				'fk_roles'=>$this->roleDAO->fetchnom($data['role'],$this->connection,'roles')
			]);
			
			if ($users) {
				try {
					$statement = $this->connection->prepare(
						"INSERT INTO {$this->table} (username, password, created_at, updated_at,session_token,session_time,fk_roles) VALUES (?, ?, ?, ?, ?, ?, ?)"
					);
					$statement->execute([
						$users->__get('username'),
						$users->__get('password'),
						$users->__get('created_at'),
						$users->__get('updated_at'),
						$users->__get('session_token'),
						$users->__get('session_time'),
						$users->__get('fk_roles')
					]);
				} catch(PDOException $e) {
					print $e->getMessage();
				}
			}
		}
		else {
			echo " <br> <br> Donnée invalide";
		}
    }
    
	function save($data){
		if($this->verificationTriche($data['username'])==true and $this->verificationTriche($data['password']==true) ){
			$data['pk'] = -1;
			$users = $this->createsave([
				'pk' => $data['pk'],
				'username' => $data['username'],
				'password' =>password_hash($data['password'], PASSWORD_DEFAULT),
				'created_at' =>date('y-m-d h:i:s'),
				'updated_at' =>date('y-m-d h:i:s'),
				'session_token'=>"undefined",
				'session_time'=>date ('y-m-d h:i:s'),
				'fk_roles'=>3
			]);
			
			if ($users) {
				try {
					$statement = $this->connection->prepare(
						"INSERT INTO {$this->table} (username, password, created_at, updated_at, session_token, session_time, fk_roles) VALUES ( ?, ?, ?, ?, ?, ?, ?)"
					);
					$statement->execute([
						$users->__get('username'),
						$users->__get('password'),
						$users->__get('created_at'),
						$users->__get('updated_at'),
						$users->__get('session_token'),
						$users->__get('session_time'),
						$users->__get('fk_roles')
					]);
				} catch(PDOException $e) {
					print $e->getMessage();
				}
			}
		}
		else {
			echo " <br> <br> Donnée invalide";
		}
    }
	
	function fetchAllMembre(){
		$table=$this->table;
		$connection= $this->connection;
		$list= $this->users_list;
		try {
            $statement = $connection->prepare("SELECT * FROM $table where fk_roles = 1");
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
	
	function fetchusername($nom) {
		$connection=$this->connection;
        try {
            $statement = $connection->prepare("SELECT pk FROM user WHERE username = ?");
            $statement->execute([$nom]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
			return ($result['pk']);
            
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }
	
    function fetchAllUser() {	
		$table=$this->table;
		$connection= $this->connection;
		$list= $this->users_list;
		$user_list=$this->fetchALL($connection,$table,$list);
		return $user_list;        
    }
    
    function fetchUser($pk) {
		$table=$this->table;
		$connection= $this->connection;
		$result=$this->fetch($pk,$connection,$table);
		return $result;     
    }
	function createsave($data) {
       return new users(
            $data['pk'],
            $data['username'],
            $data['password'],
            $data['created_at'],
            $data['updated_at'],
			$data['session_token'],
            $data['session_time'],
			$data['fk_roles']
       );
    }
	 
    function create($data) {
        return new users(
            $data['pk'],
            $data['username'],
            $data['password'],
            $data['created_at'],
            $data['updated_at'],
			$data['session_token'],
            $data['session_time'],
			$this->roleDAO->fetch($data['fk_roles'],$this->connection,'roles')
        );
    }
   
	function supprimerUser($pk) {
		$table=$this->table;
		$connection= $this->connection;
		$this->supprimer($pk,$table,$connection);
	}
	
	function updateTransformation($params){
		$changement=$params['changement'];
		if ($changement=='membre'){
			$changement=1;
		}
		else if ($changement=='utilisateur'){
			$changement=3;
		}
		$this->requeteUpdate($params,$changement);
	}
	
	function demote($params){
		$this->requeteUpdate($params,3);
	}
			
	function requeteUpdate ($params,$changement){
	try{
			
			$nomdeparametre=$params['parametre'];
            $statement = $this->connection->prepare("Update {$this->table} SET $nomdeparametre = '".$changement."' WHERE pk = ?");
            $statement->execute([$params['pk']]);
        } catch (PDOException $e){
            print $e->getMessage();
        }
	}
	function verifypw($username, $password) {
		if($this->verificationTriche($username)==true and $this->verificationTriche($password)==true){
        try {
            $statement = $this->connection->prepare("SELECT * FROM {$this->table} WHERE username = ?");
            $statement->execute([$username]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $user = $this->create($result);
            
            if(password_verify($password, $user->__get('password'))) {
				
                return $user;
            }
            return false;
        } catch (PDOException $e) {
           
            print $e->getMessage();
        }
		}
    }
	
	function redirection($cookie){
		$verification = $this->fetchByCookie($cookie);
		var_dump($verification);
		if ($verification != false){
			$role=$verification->__get('fk_roles');
			$role=$role->__get('pk');
			var_dump($verification);
			if ($role=='1'){
				header('location: ../membre/');
				exit();
			}
			else if ($role=='2'){
				header('Location: ../gerant/');
				exit();
			}
			else{
				header('Location: ../utilisateur/');
				exit();
			}
		}else{
			header('Location: index');
			exit();
		}
	}
	
	function verifyRoleetCookies($cookie){
		$verification = $this->fetchByCookie($cookie);
		if ($verification != false){
			$role=$verification->__get('fk_roles');
			$role=$role->__get('pk');
			$retour = array('role'=>$role,'user'=>$verification);
			return $retour;
		}else{
			header('Location: ../index/');
			exit();
		}
	}
	
	function fetchByCookie($cookie) {
        if($cookie) {
            try {
                $statement = $this->connection->prepare("SELECT * FROM {$this->table} WHERE session_token = ?");
                $statement->execute([$cookie]);
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                $user = $this->create($result);
                
                if($user && $user->__get('session_time')) {
                    $cookieDatetime = new DateTime($user->__get('session_time'));
                    $cookieDatetime = $cookieDatetime->getTimestamp();
                    $actualDatetime = new DateTime();
                    $actualDatetime = $actualDatetime->getTimestamp();
                    $expired = 36000;
                    if ( $cookieDatetime+$expired >= $actualDatetime ){
                        return $user;
                    } else {
                      $this->getRandomToken($user);
                    }
                }  else {
                    return false;
                }
            } catch (PDOException $e) {
                print $e->getMessage();
            }
        }else{
			
		}
		
        return false;
    }
	
	function getRandomToken($user) {
        $token = bin2hex(random_bytes(8)) . "." . time();
        $user->__set('session_token', $token);
        $user->__set('session_time', date('Y-m-d H:i:s'));
        setcookie('session_token', $token, time()+60*60*24,"/");
        $this->updateCookies($user);
		$_SESSION['cookie']=$token;
    }
	
	function updateCookies($user) {
        try {
            $statement = $this->connection->prepare("UPDATE {$this->table} SET session_token = ?, session_time = ? WHERE pk = ?");
            $statement->execute([$user->__get('session_token'), $user->__get('session_time'), $user->__get('pk')]);
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }
}