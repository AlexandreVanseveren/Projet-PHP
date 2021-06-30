<?php
class GerantController {
	private $view;
	private $match_manager;
	private $demande_manager;
	private $user_manager;
	private $champions_manager;
	private $match_manager2;
	
    function __construct($get, $post, $route) {
		session_start();
		$this->view = new IndexPageView();
		$this->match_manager = new Match_championsDAO(new MatchBehavior);
		$this->demande_manager = new DemandeDAO();
		$this->user_manager = new UsersDAO();
		$this->champions_manager = new ChampionsDAO();
		$this->match_manager2 = new MatchDAO();
		$this->Action($post);
		$this->generateVue($get);
		}
   
	function generateVue($_get) {
		if(isset($_COOKIE) && isset($_COOKIE['session_token'])) {
			$verification=$this->user_manager->verifyRoleetCookies($_COOKIE['session_token']);
			if ($verification['role']== 2){
				$match = $this->match_manager->fetchAllMatch();
				$demande = $this->demande_manager->fetchAllDemande();
				$utilisateurs= $this->user_manager->fetchAllUser();
				$membre = $this->user_manager->fetchAllMembre();
				$champions = $this->champions_manager->fetchAllChampions();
				echo $this->view->displayPageGerant($match,$demande,$utilisateurs,$membre,$champions);	
			}
		}
    }
	
	function Action($post){
		//GESTION DES UTILISATEURS
		if(isset($_POST) && isset($_POST['type']) && $_POST['type'] == 'createUser') {
			$verification=$this->user_manager->verifyRoleetCookies($_COOKIE['session_token']);
			if ($verification['role'] == 2){
				$user = $this->user_manager->saveadmin($_POST);
				header('Location: ../gerant/rajoutUtilisateur');
				exit();
			}
		}
		else if(isset($_POST) && isset($_POST['SupprimerUser']) && $_POST['SupprimerUser'] == 'supprimer') {
			$verification=$this->user_manager->verifyRoleetCookies($_COOKIE['session_token']);
			if ($verification['role'] == 2){
				$user = $this->user_manager->supprimerUser($_POST['pk']);
				header('Location: ../gerant/supprimerUtilisateur');
				exit();
			}
		}
		else if(isset($_POST) && isset($_POST['modifieUser']) && $_POST['modifieUser'] == 'modifie') {
			$verification=$this->user_manager->verifyRoleetCookies($_COOKIE['session_token']);
			if ($verification['role'] == 2){
				$pk = $_POST['pk'];
				include 'views/template/ModifierUserGerant.php';
			}
		}
		else if(isset($_POST) && isset($_POST['modificationUser']) && $_POST['modificationUser'] == 'modification') {
			$verification=$this->user_manager->verifyRoleetCookies($_COOKIE['session_token']);
			if ($verification['role'] == 2){
				$user = $this->user_manager->updateTransformation($_POST);
				header('Location: ../gerant/modificationUtilisateur');
				exit();
			}
		}
		else if(isset($_POST) && isset($_POST['retrograder']) && $_POST['retrograder'] == 'retrograder') {
			$verification=$this->user_manager->verifyRoleetCookies($_COOKIE['session_token']);
			if ($verification['role'] == 2){
				$user = $this->user_manager->demote($_POST);
				header('Location: ../gerant/retrograder');
				exit();
			}
		}
		//GESTION DES DEMANDES
		else if(isset($_POST) && isset($_POST['modifieDemande']) && $_POST['modifieDemande'] == 'modifieDemande') {
			$verification=$this->user_manager->verifyRoleetCookies($_COOKIE['session_token']);
			if ($verification['role'] == 2){
				$user = $this->demande_manager->changementStatut($_POST);
				header('Location: ../gerant/modificationStatut');
				exit();
			}
		}
		else if(isset($_POST) && isset($_POST['supprDemande']) && $_POST['supprDemande'] == 'supprDemande') {
			$verification=$this->user_manager->verifyRoleetCookies($_COOKIE['session_token']);
			if ($verification['role'] == 2){
				$user = $this->demande_manager->supprimerdemande($_POST);
				header('Location: ../gerant/supprimerDemande');
				exit();
			}
		}
		//GESTION DES MATCH
		else if(isset($_POST) && isset($_POST['nom']) && $_POST['nom'] == 'createMatch') {
			$verification=$this->user_manager->verifyRoleetCookies($_COOKIE['session_token']);
			if ($verification['role'] == 2){
				$user = $this->match_manager2->save($_POST);
				$user = $this->match_manager->save($_POST);
				header('Location: ../gerant/rajoutMatch');
				exit();
			}
		}
		else if(isset($_POST) && isset($_POST['deleteMatch']) && $_POST['deleteMatch'] == 'delete') {
			$verification=$this->user_manager->verifyRoleetCookies($_COOKIE['session_token']);
			if ($verification['role'] == 2){
				$user = $this->match_manager2->supprimerMatch($_POST['pk']);
				header('Location: ../gerant/supprimerMatch');
				exit();
			}
		}
	}
}

?>