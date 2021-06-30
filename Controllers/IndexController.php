<?php
class IndexController {
	private $view;
	private $match_manager;
	private $user_manager;
	
    function __construct($get, $post, $route) {
		if (isset ($_SESSION)){
		session_destroy();
		}
		session_start();
		$this->view = new IndexPageView();
		$this->match_manager = new Match_ChampionsDAO(new MatchUtilisateurBehavior);
		$this->user_manager = new UsersDAO();
		$this->Action($post);
		$this->generateVue($get);
		$_SESSION['cookie']='';
		if(isset($_COOKIE) && isset($_COOKIE['session_token'])) {
			setcookie('session_token', '', time() - 36000,'/');
			unset($_COOKIE['session_token']);
		}
		}
   
	function generateVue($_get) {
		$matchOffi = $this->match_manager->fetchAllMatch();
		echo $this->view->displayPageAccueil($matchOffi);
    }
	
	function Action($post){
		if(isset($_POST) && isset($_POST['type']) && $_POST['type'] == 'createUser') {
			$user = $this->user_manager->save($_POST);
			header('Location: index');
			exit();
		}
		else if(isset($_POST) && isset($_POST['login']) && $_POST['login'] == 'login') {
			if(isset($_COOKIE) && isset($_COOKIE['session_token'])) {
			setcookie('session_token', '', time() - 36000,'/');
			unset($_COOKIE['session_token']);
			}
			$reponse=$this->user_manager->verifypw($_POST['mdp'],$_POST['psedo']);
			if (($reponse)==false){
				echo "mauvais pw";
			}else{
				if(!isset ($_COOKIE['session_token'])){
					$this->user_manager->getRandomToken($reponse);
					$this->user_manager->redirection($_SESSION['cookie']);
					header('Location: ../index/rajoutUser');
					exit();
				}
				$this->user_manager->redirection($_COOKIE['session_token']);
				header('Location: index');
				exit();
			}
		}
	}
}

?>