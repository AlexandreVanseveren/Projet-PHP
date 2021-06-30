<?php

class UtilisateurController {
	
	private $view;
	private $match_manager;
	private $user_manager;
	private $message_manager;
	
    function __construct($get, $post, $route) {
		session_start();
		$this->view = new IndexPageView();
		$this->match_manager = new Match_ChampionsDAO(new MatchUtilisateurBehavior);
		$this->user_manager = new UsersDAO();
		$this->message_manager = new MessageDAO;
		$this->Action($post);
		$this->generateVue($get);
		
		
	}

	function generateVue($_get) {
		if(isset($_COOKIE) && isset($_COOKIE['session_token'])) {
			$verification=$this->user_manager->verifyRoleetCookies($_COOKIE['session_token']);
			if ($verification['role'] == 3){
				$matchOffi = $this->match_manager->fetchAllMatch();
				echo $this->view->displayPageUtilisateurConnecté($matchOffi, $verification['user']);
			}
		}
	}
		
	function Action($post){
		if(isset($_POST['text'])){
			echo'ola';
		}
	}
}
?>
