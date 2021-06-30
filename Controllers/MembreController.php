<?php
class MembreController {
	private $view;
	private $match_manager;
	private $demande_manager;
	private $user_manager;
	
    function __construct($get, $post, $route) {
		session_start();
		$this->view = new IndexPageView();
		$this->match_manager = new Match_ChampionsDAO(new MatchBehavior);
		$this->demande_manager = new DemandeDAO();
		$this->user_manager = new UsersDAO();
		$this->Action($post);
		$this->generateVue($get);
		}
   
	function generateVue($_get) {
		if(isset($_COOKIE) && isset($_COOKIE['session_token'])) {
			$verification=$this->user_manager->verifyRoleetCookies($_COOKIE['session_token']);
			if ($verification['role'] == 1){
				$match = $this->match_manager->fetchAllMatch();
				$demandeMembre = $this->demande_manager->fetchonUser($_COOKIE['session_token']);
				echo $this->view->displayPageMembre($match,$demandeMembre);
			}
		}
    }
	
	function Action($post){
		if(isset($_POST) && isset($_POST['type']) && $_POST['type'] == 'createDemande') {
			$demande = $this->demande_manager->save($_POST,$_COOKIE['session_token']);
			header('location: ../membre/rajoutDemande');
			exit();
		}
	}
}

?>